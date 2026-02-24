<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ScholarshipController;
use App\Http\Controllers\Api\CareerPathController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\DashboardController;

// Public API Routes
Route::prefix('v1')->group(function () {
    // Auth Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Public listings
    Route::get('/jobs', [JobController::class, 'index']);
    Route::get('/jobs/{id}', [JobController::class, 'show']);
    Route::get('/jobs/stats', [JobController::class, 'stats']);
    
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{id}', [EventController::class, 'show']);
    
    Route::get('/scholarships', [ScholarshipController::class, 'index']);
    Route::get('/scholarships/{id}', [ScholarshipController::class, 'show']);
    Route::get('/scholarships/stats', [ScholarshipController::class, 'stats']);
    
    Route::get('/career-paths', [CareerPathController::class, 'index']);
    Route::get('/career-paths/{slug}', [CareerPathController::class, 'show']);
    Route::get('/career-paths/industries/list', [CareerPathController::class, 'industries']);
    Route::get('/career-paths/industry/{industry}', [CareerPathController::class, 'byIndustry']);

    // Protected API Routes
    Route::middleware('auth:sanctum')->group(function () {
        // Auth
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);
        
        // Job Applications
        Route::post('/jobs/{id}/apply', [JobController::class, 'apply']);
        Route::get('/jobs/recommendations', [JobController::class, 'recommendations']);
        
        // Applications Management
        Route::get('/applications', [ApplicationController::class, 'index']);
        Route::get('/applications/{id}', [ApplicationController::class, 'show']);
        Route::put('/applications/{id}/status', [ApplicationController::class, 'updateStatus']);
        Route::delete('/applications/{id}', [ApplicationController::class, 'withdraw']);
        Route::get('/applications/{id}/download', [ApplicationController::class, 'downloadCv']);
        
        // Event Registration
        Route::post('/events/{id}/register', [EventController::class, 'register']);
        Route::get('/my-events', [EventController::class, 'myEvents']);
        Route::post('/events/checkin/{token}', [EventController::class, 'checkIn']);
    });
});

// API Documentation (if using Swagger)
Route::get('/docs', function () {
    return view('api-docs');
});