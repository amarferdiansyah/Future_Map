<?php

namespace App\Http\Controllers;

use App\Models\CareerPath;
use App\Models\CareerPathCourse;
use Illuminate\Http\Request;

class CareerPathController extends Controller
{
    /**
     * Display a listing of the career paths.
     */
    public function index(Request $request)
    {
        $query = CareerPath::query();

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('industry', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by industry
        if ($request->filled('industry')) {
            $query->where('industry', $request->industry);
        }

        $careerPaths = $query->withCount('courses')->paginate(9);
        
        // Get distinct industries for filter
        $industries = CareerPath::distinct('industry')->pluck('industry');

        return view('career-paths.index', compact('careerPaths', 'industries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method is not used in this implementation
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // This method is not used in this implementation
        abort(404);
    }

    /**
     * Display the specified career path.
     */
    public function show($slug)
    {
        $careerPath = CareerPath::where('slug', $slug)
                                ->with('courses')
                                ->firstOrFail();
        
        // Get related career paths (same industry)
        $relatedPaths = CareerPath::where('industry', $careerPath->industry)
            ->where('id', '!=', $careerPath->id)
            ->limit(3)
            ->get();

        return view('career-paths.show', compact('careerPath', 'relatedPaths'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // This method is not used in this implementation
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // This method is not used in this implementation
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // This method is not used in this implementation
        abort(404);
    }
}