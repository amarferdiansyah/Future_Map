<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CareerPath;
use App\Http\Resources\CareerPathResource;
use Illuminate\Http\Request;

class CareerPathController extends Controller
{
    /**
     * Display a listing of career paths with filters.
     */
    public function index(Request $request)
    {
        $query = CareerPath::withCount('courses');

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'LIKE', "%{$request->search}%")
                  ->orWhere('description', 'LIKE', "%{$request->search}%")
                  ->orWhere('industry', 'LIKE', "%{$request->search}%");
            });
        }

        // Industry filter
        if ($request->has('industry') && !empty($request->industry)) {
            $query->where('industry', $request->industry);
        }

        // Skill filter
        if ($request->has('skills') && !empty($request->skills)) {
            $skills = explode(',', $request->skills);
            $query->where(function($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->whereJsonContains('required_skills', $skill);
                }
            });
        }

        // Salary range filter
        if ($request->has('min_salary') && !empty($request->min_salary)) {
            $query->where('avg_salary_max', '>=', $request->min_salary);
        }

        // Sorting
        $sort = $request->get('sort', 'title');
        switch ($sort) {
            case 'popular':
                $query->orderBy('courses_count', 'desc');
                break;
            case 'salary_high':
                $query->orderBy('avg_salary_max', 'desc');
                break;
            default:
                $query->orderBy('title', 'asc');
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $careerPaths = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => CareerPathResource::collection($careerPaths),
            'meta' => [
                'current_page' => $careerPaths->currentPage(),
                'last_page' => $careerPaths->lastPage(),
                'per_page' => $careerPaths->perPage(),
                'total' => $careerPaths->total(),
                'filters' => [
                    'industries' => CareerPath::distinct('industry')->pluck('industry'),
                ],
            ],
        ]);
    }

    /**
     * Display the specified career path.
     */
    public function show($slug)
    {
        $careerPath = CareerPath::where('slug', $slug)
            ->with('courses')
            ->withCount('courses')
            ->firstOrFail();
        
        // Get related career paths
        $relatedPaths = CareerPath::where('industry', $careerPath->industry)
            ->where('id', '!=', $careerPath->id)
            ->limit(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'career_path' => new CareerPathResource($careerPath),
                'related_paths' => CareerPathResource::collection($relatedPaths),
            ],
        ]);
    }

    /**
     * Get career path by industry.
     */
    public function byIndustry($industry)
    {
        $careerPaths = CareerPath::where('industry', $industry)
            ->withCount('courses')
            ->get();

        return response()->json([
            'success' => true,
            'data' => CareerPathResource::collection($careerPaths),
        ]);
    }

    /**
     * Get all industries.
     */
    public function industries()
    {
        $industries = CareerPath::distinct('industry')
            ->select('industry')
            ->orderBy('industry')
            ->get()
            ->pluck('industry');

        return response()->json([
            'success' => true,
            'data' => $industries,
        ]);
    }
}