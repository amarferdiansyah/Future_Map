<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Http\Resources\ScholarshipResource;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of scholarships with filters.
     */
    public function index(Request $request)
    {
        $query = Scholarship::where('is_active', true)
            ->where('deadline', '>', now());

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('provider', 'LIKE', "%{$request->search}%")
                  ->orWhere('description', 'LIKE', "%{$request->search}%");
            });
        }

        // Type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Level filter
        if ($request->has('level') && !empty($request->level)) {
            $query->where('level', $request->level);
        }

        // Amount range filter
        if ($request->has('min_amount') && !empty($request->min_amount)) {
            $query->where('amount', '>=', $request->min_amount);
        }
        
        if ($request->has('max_amount') && !empty($request->max_amount)) {
            $query->where('amount', '<=', $request->max_amount);
        }

        // Deadline filter
        if ($request->has('deadline_before') && !empty($request->deadline_before)) {
            $query->where('deadline', '<=', $request->deadline_before);
        }

        // Sorting
        $sort = $request->get('sort', 'deadline');
        switch ($sort) {
            case 'amount_high':
                $query->orderBy('amount', 'desc');
                break;
            case 'amount_low':
                $query->orderBy('amount', 'asc');
                break;
            case 'latest':
                $query->latest();
                break;
            default:
                $query->orderBy('deadline', 'asc');
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $scholarships = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => ScholarshipResource::collection($scholarships),
            'meta' => [
                'current_page' => $scholarships->currentPage(),
                'last_page' => $scholarships->lastPage(),
                'per_page' => $scholarships->perPage(),
                'total' => $scholarships->total(),
                'filters' => [
                    'types' => Scholarship::distinct('type')->pluck('type'),
                    'levels' => Scholarship::distinct('level')->pluck('level'),
                ],
            ],
        ]);
    }

    /**
     * Display the specified scholarship.
     */
    public function show($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        
        // Get related scholarships
        $relatedScholarships = Scholarship::where('is_active', true)
            ->where('id', '!=', $scholarship->id)
            ->where(function($query) use ($scholarship) {
                $query->where('type', $scholarship->type)
                      ->orWhere('level', $scholarship->level);
            })
            ->where('deadline', '>', now())
            ->limit(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'scholarship' => new ScholarshipResource($scholarship),
                'related_scholarships' => ScholarshipResource::collection($relatedScholarships),
            ],
        ]);
    }

    /**
     * Get scholarship statistics.
     */
    public function stats()
    {
        $stats = [
            'total' => Scholarship::count(),
            'active' => Scholarship::where('is_active', true)
                ->where('deadline', '>', now())
                ->count(),
            'by_type' => Scholarship::selectRaw('type, count(*) as total')
                ->where('is_active', true)
                ->where('deadline', '>', now())
                ->groupBy('type')
                ->get(),
            'by_level' => Scholarship::selectRaw('level, count(*) as total')
                ->where('is_active', true)
                ->where('deadline', '>', now())
                ->groupBy('level')
                ->get(),
            'deadline_soon' => Scholarship::where('is_active', true)
                ->where('deadline', '>', now())
                ->where('deadline', '<=', now()->addWeeks(2))
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}