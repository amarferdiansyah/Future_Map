<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\Event;
use App\Models\Scholarship;
use App\Models\JobApplication;
use App\Http\Resources\JobResource;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get dashboard data based on user role.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole(['mahasiswa', 'alumni'])) {
            return $this->studentDashboard($user);
        } elseif ($user->hasRole('company')) {
            return $this->companyDashboard($user);
        } elseif ($user->hasRole('dosen')) {
            return $this->lecturerDashboard($user);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'message' => 'Welcome to FutureMap',
            ],
        ]);
    }

    /**
     * Admin dashboard.
     */
    private function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => JobListing::count(),
            'total_events' => Event::count(),
            'total_applications' => JobApplication::count(),
            'users_by_role' => User::selectRaw('role_id, count(*) as total')
                ->groupBy('role_id')
                ->get(),
            'jobs_by_type' => JobListing::selectRaw('type, count(*) as total')
                ->groupBy('type')
                ->get(),
            'recent_jobs' => JobListing::with('company')->latest()->limit(5)->get(),
            'recent_events' => Event::withCount('registrations')->latest()->limit(5)->get(),
            'recent_applications' => JobApplication::with(['user', 'job'])
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
     * Student dashboard.
     */
    private function studentDashboard($user)
    {
        // Recommended jobs based on profile
        $recommendedJobs = JobListing::with(['company', 'skills'])
            ->where('is_active', true)
            ->where('deadline', '>', now())
            ->get()
            ->map(function ($job) use ($user) {
                $job->match_score = $job->getMatchScoreForUser($user);
                return $job;
            })
            ->sortByDesc('match_score')
            ->take(5);

        // Upcoming events
        $upcomingEvents = Event::where('start_date', '>', now())
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        // User's applications
        $myApplications = JobApplication::where('user_id', $user->id)
            ->with('job')
            ->latest()
            ->limit(5)
            ->get();

        // Available scholarships
        $scholarships = Scholarship::where('deadline', '>', now())
            ->where('is_active', true)
            ->latest()
            ->limit(3)
            ->get();

        // Statistics
        $stats = [
            'total_applications' => $user->jobApplications()->count(),
            'pending_applications' => $user->jobApplications()->where('status', 'pending')->count(),
            'accepted_applications' => $user->jobApplications()->where('status', 'accepted')->count(),
            'events_registered' => $user->eventRegistrations()->count(),
            'profile_completeness' => $this->calculateProfileCompleteness($user),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'recommended_jobs' => JobResource::collection($recommendedJobs),
                'upcoming_events' => EventResource::collection($upcomingEvents),
                'my_applications' => $myApplications,
                'scholarships' => $scholarships,
            ],
        ]);
    }

    /**
     * Company dashboard.
     */
    private function companyDashboard($user)
    {
        $stats = [
            'total_jobs' => JobListing::where('company_id', $user->id)->count(),
            'active_jobs' => JobListing::where('company_id', $user->id)
                ->where('is_active', true)
                ->where('deadline', '>', now())
                ->count(),
            'total_applications' => JobApplication::whereIn('job_listing_id', 
                JobListing::where('company_id', $user->id)->pluck('id')
            )->count(),
            'pending_applications' => JobApplication::whereIn('job_listing_id', 
                JobListing::where('company_id', $user->id)->pluck('id')
            )->where('status', 'pending')->count(),
        ];

        $recentJobs = JobListing::where('company_id', $user->id)
            ->withCount('applications')
            ->latest()
            ->limit(5)
            ->get();

        $recentApplications = JobApplication::whereIn('job_listing_id', 
                JobListing::where('company_id', $user->id)->pluck('id')
            )
            ->with(['user', 'job'])
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'stats' => $stats,
                'recent_jobs' => $recentJobs,
                'recent_applications' => $recentApplications,
            ],
        ]);
    }

    /**
     * Lecturer dashboard.
     */
    private function lecturerDashboard($user)
    {
        // Placeholder for lecturer dashboard
        return response()->json([
            'success' => true,
            'data' => [
                'message' => 'Lecturer dashboard coming soon',
                'stats' => [
                    'total_mentees' => 0,
                    'upcoming_sessions' => 0,
                ],
            ],
        ]);
    }

    /**
     * Calculate profile completeness percentage.
     */
    private function calculateProfileCompleteness($user)
    {
        $fields = [
            'profile.major_id' => 15,
            'profile.semester' => 10,
            'profile.gpa' => 15,
            'profile.bio' => 10,
            'profile.linkedin_url' => 10,
            'profile.cv_path' => 20,
            'user.phone' => 10,
            'user.skills' => 10,
        ];

        $score = 0;
        foreach ($fields as $field => $weight) {
            if ($field == 'user.skills') {
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
}