<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the scholarships.
     */
    public function index(Request $request)
    {
        $query = Scholarship::where('is_active', true)
            ->where('deadline', '>', now());

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('provider', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $scholarships = $query->orderBy('deadline')->paginate(9);
        
        // Get distinct values for filters
        $types = Scholarship::distinct('type')->pluck('type');
        $levels = Scholarship::distinct('level')->pluck('level');

        return view('scholarships.index', compact('scholarships', 'types', 'levels'));
    }

    /**
     * Display the specified scholarship.
     */
    public function show($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        
        // Get related scholarships (same type or level)
        $relatedScholarships = Scholarship::where('is_active', true)
            ->where('id', '!=', $scholarship->id)
            ->where(function($query) use ($scholarship) {
                $query->where('type', $scholarship->type)
                      ->orWhere('level', $scholarship->level);
            })
            ->where('deadline', '>', now())
            ->limit(3)
            ->get();

        return view('scholarships.show', compact('scholarship', 'relatedScholarships'));
    }
}