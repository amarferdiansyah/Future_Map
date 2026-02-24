<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function apply(Request $request, $jobId)
    {
        $job = Job::findOrFail($jobId);
        
        // Check if already applied
        $existingApplication = JobApplication::where('job_listing_id', $jobId)
            ->where('user_id', auth()->id())
            ->first();
            
        if ($existingApplication) {
            return back()->with('error', 'Anda sudah melamar lowongan ini.');
        }

        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        // Upload CV
        $file = $request->file('cv');
        $filename = time() . '_' . auth()->id() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/cvs'), $filename);

        // Calculate match score (optional)
        $matchScore = rand(60, 95); // Sementara random, nanti bisa dibuat algoritma

        $application = JobApplication::create([
            'job_listing_id' => $jobId,
            'user_id' => auth()->id(),
            'cv_path' => $filename,
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
            'match_score' => $matchScore,
            'applied_at' => now(),
        ]);

        // Increment applications count
        $job->increment('applications_count');

        return redirect()->route('jobs.show', $jobId)
            ->with('success', 'Lamaran berhasil dikirim!');
    }

    public function updateStatus(Request $request, $applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);
        
        // Authorize that user is the company owner
        if (auth()->id() != $application->job->company_id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,reviewed,interview,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function myApplications()
    {
        $applications = JobApplication::where('user_id', auth()->id())
            ->with(['job.company'])
            ->latest()
            ->paginate(10);

        return view('jobs.my-applications', compact('applications'));
    }

    public function downloadCv($applicationId)
    {
        $application = JobApplication::findOrFail($applicationId);
        
        // Authorize that user can download this CV
        if (auth()->id() != $application->user_id && 
            auth()->id() != $application->job->company_id) {
            abort(403);
        }

        $path = public_path('uploads/cvs/' . $application->cv_path);
        
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($path, 'CV_' . $application->user->name . '.pdf');
    }
}