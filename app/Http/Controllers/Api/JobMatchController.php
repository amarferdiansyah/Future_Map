<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class JobMatchController extends Controller
{
    public function getMatches(Request $request)
    {
        $user = auth()->user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $jobs = Job::where('is_active', true)
            ->where('deadline', '>', now())
            ->with(['company', 'skills'])
            ->get()
            ->map(function ($job) use ($user) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'company' => $job->company->name,
                    'type' => $job->type,
                    'location' => $job->location,
                    'match_score' => $job->getMatchScoreForUser($user),
                    'deadline' => $job->deadline->format('Y-m-d'),
                    'skills' => $job->skills->pluck('name')
                ];
            })
            ->sortByDesc('match_score')
            ->values()
            ->take(10);

        return response()->json([
            'success' => true,
            'data' => $jobs
        ]);
    }

    public function analyzeProfile($userId)
    {
        $user = User::with(['skills', 'profile.major'])->findOrFail($userId);
        
        // Get recommended jobs
        $recommendedJobs = Job::where('is_active', true)
            ->where('deadline', '>', now())
            ->with(['company', 'skills'])
            ->get()
            ->map(function ($job) use ($user) {
                return [
                    'job_id' => $job->id,
                    'title' => $job->title,
                    'match_score' => $job->getMatchScoreForUser($user),
                    'missing_skills' => $this->getMissingSkills($user, $job)
                ];
            })
            ->sortByDesc('match_score')
            ->take(5);

        // Get skill gaps
        $skillGaps = $this->analyzeSkillGaps($user);

        return response()->json([
            'success' => true,
            'data' => [
                'profile_completeness' => $this->calculateProfileCompleteness($user),
                'top_matches' => $recommendedJobs,
                'skill_gaps' => $skillGaps,
                'recommended_courses' => $this->getRecommendedCourses($skillGaps)
            ]
        ]);
    }

    private function getMissingSkills($user, $job)
    {
        $userSkills = $user->skills->pluck('id')->toArray();
        $requiredSkills = $job->skills->pluck('id')->toArray();
        
        return array_diff($requiredSkills, $userSkills);
    }

    private function analyzeSkillGaps($user)
    {
        // Get all jobs in user's field
        $relevantJobs = Job::where('is_active', true)
            ->where(function($query) use ($user) {
                if ($user->profile && $user->profile->major_id) {
                    $query->where('major_id', $user->profile->major_id);
                }
            })
            ->with('skills')
            ->get();

        $allRequiredSkills = [];
        foreach ($relevantJobs as $job) {
            foreach ($job->skills as $skill) {
                if (!isset($allRequiredSkills[$skill->id])) {
                    $allRequiredSkills[$skill->id] = [
                        'id' => $skill->id,
                        'name' => $skill->name,
                        'count' => 0,
                        'importance' => 0
                    ];
                }
                $allRequiredSkills[$skill->id]['count']++;
                $allRequiredSkills[$skill->id]['importance'] += $skill->pivot->importance_level;
            }
        }

        // Sort by frequency and importance
        uasort($allRequiredSkills, function($a, $b) {
            return $b['importance'] <=> $a['importance'];
        });

        $userSkillIds = $user->skills->pluck('id')->toArray();
        
        $gaps = [];
        foreach (array_slice($allRequiredSkills, 0, 10) as $skill) {
            if (!in_array($skill['id'], $userSkillIds)) {
                $gaps[] = [
                    'skill' => $skill['name'],
                    'demand_score' => round(($skill['count'] / $relevantJobs->count()) * 100, 2)
                ];
            }
        }

        return $gaps;
    }

    private function calculateProfileCompleteness($user)
    {
        $fields = [
            'profile.major_id' => 20,
            'profile.semester' => 10,
            'profile.gpa' => 15,
            'profile.bio' => 10,
            'skills' => 25,
            'profile.work_experience' => 20
        ];

        $score = 0;
        foreach ($fields as $field => $weight) {
            if ($field == 'skills') {
                if ($user->skills->count() > 0) {
                    $score += $weight;
                }
            } elseif (str_contains($field, '.')) {
                list($relation, $attribute) = explode('.', $field);
                if ($user->$relation && $user->$relation->$attribute) {
                    $score += $weight;
                }
            } else {
                if ($user->$field) {
                    $score += $weight;
                }
            }
        }

        return $score;
    }

    private function getRecommendedCourses($skillGaps)
    {
        // This could be integrated with external course APIs
        $courses = [];
        foreach ($skillGaps as $gap) {
            $courses[] = [
                'skill' => $gap['skill'],
                'recommended_courses' => [
                    [
                        'title' => 'Belajar ' . $gap['skill'] . ' untuk Pemula',
                        'platform' => 'Coursera',
                        'duration' => '4 minggu',
                        'level' => 'Pemula'
                    ],
                    [
                        'title' => 'Mastering ' . $gap['skill'] . ': Advanced Techniques',
                        'platform' => 'Udemy',
                        'duration' => '8 minggu',
                        'level' => 'Menengah'
                    ]
                ]
            ];
        }

        return $courses;
    }
}