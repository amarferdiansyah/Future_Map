<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Http\Resources\JobResource;
use App\Http\Resources\JobCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    /**
     * Display a listing of jobs with filters.
     * 
     * @OA\Get(
     *     path="/api/jobs",
     *     summary="Get all jobs with filters",
     *     tags={"Jobs"},
     *     @OA\Parameter(name="search", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="type", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="work_style", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="major_id", in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="min_salary", in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="max_salary", in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="skills", in="query", @OA\Schema(type="string")),
     *     @OA\Parameter(name="sort", in="query", @OA\Schema(type="string", enum={"latest", "deadline", "salary_high", "salary_low"})),
     *     @OA\Parameter(name="per_page", in="query", @OA\Schema(type="integer", default=15)),
     *     @OA\Response(response=200, description="Successful response")
     * )
     */
    public function index(Request $request)
    {
        $query = JobListing::with(['company', 'skills', 'major'])
            ->where('is_active', true)
            ->where('deadline', '>', now());

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('requirements', 'LIKE', "%{$search}%")
                  ->orWhereHas('company', function($cq) use ($search) {
                      $cq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Work style filter
        if ($request->has('work_style') && !empty($request->work_style)) {
            $query->where('work_style', $request->work_style);
        }

        // Major filter
        if ($request->has('major_id') && !empty($request->major_id)) {
            $query->where('major_id', $request->major_id);
        }

        // Salary range filter
        if ($request->has('min_salary') && !empty($request->min_salary)) {
            $query->where('salary_max', '>=', $request->min_salary);
        }
        
        if ($request->has('max_salary') && !empty($request->max_salary)) {
            $query->where('salary_min', '<=', $request->max_salary);
        }

        // Skills filter
        if ($request->has('skills') && !empty($request->skills)) {
            $skillIds = explode(',', $request->skills);
            $query->whereHas('skills', function($q) use ($skillIds) {
                $q->whereIn('skills.id', $skillIds);
            });
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'deadline':
                $query->orderBy('deadline', 'asc');
                break;
            case 'salary_high':
                $query->orderBy('salary_max', 'desc');
                break;
            case 'salary_low':
                $query->orderBy('salary_min', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $jobs = $query->paginate($perPage);

        // Add match score for authenticated user
        if ($request->user()) {
            $jobs->getCollection()->transform(function ($job) use ($request) {
                $job->match_score = $job->getMatchScoreForUser($request->user());
                return $job;
            });
        }

        return (new JobCollection($jobs))
            ->additional([
                'meta' => [
                    'filters' => [
                        'types' => JobListing::distinct('type')->pluck('type'),
                        'work_styles' => JobListing::distinct('work_style')->pluck('work_style'),
                    ],
                ],
            ]);
    }

    /**
     * Display the specified job.
     */
    public function show($id)
    {
        $job = JobListing::with(['company', 'skills', 'major', 'applications'])
            ->findOrFail($id);
        
        // Increment views
        $job->increment('views_count');

        // Get related jobs
        $relatedJobs = JobListing::with(['company'])
            ->where('is_active', true)
            ->where('id', '!=', $job->id)
            ->where(function($query) use ($job) {
                $query->where('major_id', $job->major_id)
                      ->orWhere('type', $job->type);
            })
            ->limit(5)
            ->get();

        $data = [
            'job' => new JobResource($job),
            'related_jobs' => JobResource::collection($relatedJobs),
        ];

        // Add match score for authenticated user
        if (request()->user()) {
            $data['match_score'] = $job->getMatchScoreForUser(request()->user());
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * Apply for a job.
     */
    public function apply(Request $request, $id)
    {
        $job = JobListing::findOrFail($id);

        // Check if job is still active
        if (!$job->is_active || $job->deadline->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'This job is no longer accepting applications.',
            ], 400);
        }

        // Check if already applied
        $existingApplication = $job->applications()
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existingApplication) {
            return response()->json([
                'success' => false,
                'message' => 'You have already applied for this job.',
            ], 400);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        // Upload CV
        $file = $request->file('cv');
        $filename = time() . '_' . $request->user()->id . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/cvs'), $filename);

        // Calculate match score
        $matchScore = $job->getMatchScoreForUser($request->user());

        // Create application
        $application = $job->applications()->create([
            'user_id' => $request->user()->id,
            'cv_path' => $filename,
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
            'match_score' => $matchScore,
            'applied_at' => now(),
        ]);

        // Increment applications count
        $job->increment('applications_count');

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully.',
            'data' => [
                'application' => new ApplicationResource($application),
                'match_score' => $matchScore,
            ],
        ], 201);
    }

    /**
     * Get job statistics.
     */
    public function stats()
    {
        $stats = [
            'total' => JobListing::count(),
            'active' => JobListing::where('is_active', true)
                ->where('deadline', '>', now())
                ->count(),
            'by_type' => JobListing::selectRaw('type, count(*) as total')
                ->groupBy('type')
                ->get(),
            'by_work_style' => JobListing::selectRaw('work_style, count(*) as total')
                ->groupBy('work_style')
                ->get(),
            'recent' => JobListing::with('company')
                ->latest()
                ->limit(5)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    /**
     * Get job recommendations for current user.
     */
    public function recommendations(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required.',
            ], 401);
        }

        $jobs = JobListing::with(['company', 'skills'])
            ->where('is_active', true)
            ->where('deadline', '>', now())
            ->get()
            ->map(function ($job) use ($user) {
                $job->match_score = $job->getMatchScoreForUser($user);
                return $job;
            })
            ->sortByDesc('match_score')
            ->take(10);

        return response()->json([
            'success' => true,
            'data' => JobResource::collection($jobs),
        ]);
    }
}