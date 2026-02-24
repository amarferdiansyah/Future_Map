<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Http\Resources\ApplicationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    /**
     * Display user's applications.
     */
    public function index(Request $request)
    {
        $query = $request->user()->jobApplications()
            ->with(['job.company']);

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->where('applied_at', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->where('applied_at', '<=', $request->to_date);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'match_score':
                $query->orderBy('match_score', 'desc');
                break;
            default:
                $query->latest('applied_at');
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $applications = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => ApplicationResource::collection($applications),
            'meta' => [
                'current_page' => $applications->currentPage(),
                'last_page' => $applications->lastPage(),
                'per_page' => $applications->perPage(),
                'total' => $applications->total(),
                'stats' => [
                    'pending' => $request->user()->jobApplications()->where('status', 'pending')->count(),
                    'accepted' => $request->user()->jobApplications()->where('status', 'accepted')->count(),
                    'rejected' => $request->user()->jobApplications()->where('status', 'rejected')->count(),
                ],
            ],
        ]);
    }

    /**
     * Display the specified application.
     */
    public function show($id)
    {
        $application = JobApplication::with(['job.company', 'user'])
            ->findOrFail($id);

        // Authorize
        if ($application->user_id !== request()->user()->id && 
            $application->job->company_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => new ApplicationResource($application),
        ]);
    }

    /**
     * Update application status (for companies).
     */
    public function updateStatus(Request $request, $id)
    {
        $application = JobApplication::with('job')->findOrFail($id);

        // Authorize
        if ($application->job->company_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,reviewed,interview,accepted,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $application->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Application status updated successfully.',
            'data' => new ApplicationResource($application),
        ]);
    }

    /**
     * Download application CV.
     */
    public function downloadCv($id)
    {
        $application = JobApplication::findOrFail($id);

        // Authorize
        if ($application->user_id !== request()->user()->id && 
            $application->job->company_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $path = public_path('uploads/cvs/' . $application->cv_path);
        
        if (!file_exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found.',
            ], 404);
        }

        return response()->download($path, 'CV_' . $application->user->name . '.pdf');
    }

    /**
     * Withdraw application (for users).
     */
    public function withdraw($id)
    {
        $application = JobApplication::findOrFail($id);

        // Authorize
        if ($application->user_id !== request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        // Can only withdraw if status is pending
        if ($application->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot withdraw application that is already ' . $application->status,
            ], 400);
        }

        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Application withdrawn successfully.',
        ]);
    }
}