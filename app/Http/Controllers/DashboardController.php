<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobListing;
use App\Models\Event;
use App\Models\Scholarship;
use App\Models\JobApplication;
use App\Models\MentoringSession; // Tambahkan jika ingin pakai mentoring
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('mahasiswa') || $user->hasRole('alumni')) {
            return $this->studentDashboard();
        } elseif ($user->hasRole('company')) {
            return $this->companyDashboard();
        } elseif ($user->hasRole('dosen')) {
            return $this->lecturerDashboard();
        }

        return view('dashboard.general');
    }

    private function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => JobListing::count(),
            'total_events' => Event::count(),
            'total_applications' => JobApplication::count(),
        ];

        $recentJobs = JobListing::with('company')->latest()->take(5)->get();
        $recentEvents = Event::latest()->take(5)->get();

        return view('dashboard.admin', compact('stats', 'recentJobs', 'recentEvents'));
    }

    private function studentDashboard()
    {
    $user = auth()->user();
    
    // Recommended jobs (simple version)
    $recommendedJobs = JobListing::where('is_active', true)
        ->where('deadline', '>', now())
        ->with('company')
        ->latest()
        ->take(5)
        ->get();

    $upcomingEvents = Event::where('start_date', '>', now())
        ->orderBy('start_date')
        ->take(3)
        ->get();

    $myApplications = JobApplication::where('user_id', $user->id)
        ->with('job')
        ->latest()
        ->take(5)
        ->get();

    $scholarships = Scholarship::where('deadline', '>', now())
        ->where('is_active', true)
        ->latest()
        ->take(3)
        ->get();

    // Tambahkan ini untuk mentoring sessions (kosong dulu)
    $mentoringSessions = collect([]); // Empty collection

    return view('dashboard.student', compact(
        'recommendedJobs',
        'upcomingEvents',
        'myApplications',
        'scholarships',
        'mentoringSessions'  // Tambahkan ini
    ));
    }

    private function companyDashboard()
    {
    $user = auth()->user();

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
        ->take(5)
        ->get();

    $recentApplications = JobApplication::whereIn('job_listing_id', 
            JobListing::where('company_id', $user->id)->pluck('id')
        )
        ->with(['user', 'job'])
        ->latest()
        ->take(10)
        ->get();

    return view('dashboard.company', compact('stats', 'recentJobs', 'recentApplications'));
    }

    private function lecturerDashboard()
    {
        return view('dashboard.lecturer');
    }
}