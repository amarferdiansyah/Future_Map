<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\Skill;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::where('is_active', true)
            ->where('deadline', '>', now())
            ->with(['company', 'skills', 'major']);

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by work style
        if ($request->filled('work_style')) {
            $query->where('work_style', $request->work_style);
        }

        // Filter by major
        if ($request->filled('major_id')) {
            $query->where('major_id', $request->major_id);
        }

        // Filter by skills
        if ($request->filled('skills')) {
            $skillIds = explode(',', $request->skills);
            $query->whereHas('skills', function($q) use ($skillIds) {
                $q->whereIn('skills.id', $skillIds);
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        if ($sort == 'latest') {
            $query->latest();
        } elseif ($sort == 'deadline') {
            $query->orderBy('deadline');
        } elseif ($sort == 'salary_high') {
            $query->orderBy('salary_max', 'desc');
        }

        $jobs = $query->paginate(12);
        
        $filters = [
            'types' => Job::distinct('type')->pluck('type'),
            'work_styles' => Job::distinct('work_style')->pluck('work_style'),
            'majors' => Major::all(),
            'skills' => Skill::all(),
        ];

        // Calculate match score for authenticated user
        if (auth()->check()) {
            $user = auth()->user();
            foreach ($jobs as $job) {
                $job->match_score = $job->getMatchScoreForUser($user);
            }
        }

        return view('jobs.index', compact('jobs', 'filters'));
    }

    public function show($id)
    {
        $job = Job::with(['company', 'skills', 'major', 'applications'])
            ->findOrFail($id);
        
        // Increment views
        $job->increment('views_count');

        $relatedJobs = Job::where('is_active', true)
            ->where('id', '!=', $job->id)
            ->where(function($query) use ($job) {
                $query->where('major_id', $job->major_id)
                      ->orWhere('type', $job->type);
            })
            ->with('company')
            ->limit(3)
            ->get();

        $hasApplied = false;
        if (auth()->check()) {
            $hasApplied = $job->applications()
                ->where('user_id', auth()->id())
                ->exists();
        }

        // Calculate match score for current user
        $matchScore = null;
        if (auth()->check()) {
            $matchScore = $job->getMatchScoreForUser(auth()->user());
        }

        return view('jobs.show', compact('job', 'relatedJobs', 'hasApplied', 'matchScore'));
    }

    public function create()
    {
        $this->authorize('create', Job::class);
        
        $majors = Major::all();
        $skills = Skill::all();
        
        return view('jobs.create', compact('majors', 'skills'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Job::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'nullable|string',
            'type' => 'required|in:fulltime,parttime,internship,freelance',
            'work_style' => 'required|in:onsite,remote,hybrid',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'major_id' => 'nullable|exists:majors,id',
            'min_gpa' => 'nullable|numeric|min:0|max:4',
            'min_semester' => 'nullable|integer|min:1|max:14',
            'deadline' => 'required|date|after:today',
            'slots' => 'required|integer|min:1',
            'skills' => 'array',
            'skills.*' => 'exists:skills,id'
        ]);

        $validated['company_id'] = auth()->id();
        $validated['is_active'] = true;

        \DB::transaction(function () use ($validated, $request) {
            $job = Job::create($validated);
            
            if ($request->has('skills')) {
                $skills = [];
                foreach ($request->skills as $skillId) {
                    $skills[$skillId] = ['importance_level' => 3];
                }
                $job->skills()->sync($skills);
            }
        });

        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan kerja berhasil dipublikasikan.');
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('update', $job);
        
        $majors = Major::all();
        $skills = Skill::all();
        
        return view('jobs.edit', compact('job', 'majors', 'skills'));
    }

    public function update(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'nullable|string',
            'type' => 'required|in:fulltime,parttime,internship,freelance',
            'work_style' => 'required|in:onsite,remote,hybrid',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'major_id' => 'nullable|exists:majors,id',
            'min_gpa' => 'nullable|numeric|min:0|max:4',
            'min_semester' => 'nullable|integer|min:1|max:14',
            'deadline' => 'required|date',
            'slots' => 'required|integer|min:1',
            'skills' => 'array',
            'skills.*' => 'exists:skills,id'
        ]);

        \DB::transaction(function () use ($job, $validated, $request) {
            $job->update($validated);
            
            if ($request->has('skills')) {
                $skills = [];
                foreach ($request->skills as $skillId) {
                    $skills[$skillId] = ['importance_level' => 3];
                }
                $job->skills()->sync($skills);
            } else {
                $job->skills()->detach();
            }
        });

        return redirect()->route('jobs.show', $job->id)
            ->with('success', 'Lowongan kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $this->authorize('delete', $job);
        
        $job->delete();
        
        return redirect()->route('jobs.index')
            ->with('success', 'Lowongan kerja berhasil dihapus.');
    }
}