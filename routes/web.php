<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\CareerPathController;

// Public Routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes - PASTIKAN INI ADA
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-profile', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update-profile');
    Route::post('/profile/upload-cv', [App\Http\Controllers\ProfileController::class, 'uploadCv'])->name('profile.upload-cv');
    Route::post('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::post('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    
    // Jobs
    Route::resource('jobs', JobController::class);
    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'apply'])->name('jobs.apply');
    Route::get('/my-applications', [JobApplicationController::class, 'myApplications'])->name('my-applications');
    
    // Events
    Route::resource('events', EventController::class);
    Route::post('/events/{event}/register', [EventRegistrationController::class, 'register'])->name('events.register');
    Route::get('/my-events', [EventRegistrationController::class, 'myEvents'])->name('my-events');

    // Scholarships
    Route::resource('scholarships', ScholarshipController::class)->only(['index', 'show']);
    
    // Career Paths
    Route::get('/career-paths', [App\Http\Controllers\CareerPathController::class, 'index'])->name('career-paths.index');
    Route::get('/career-paths/{slug}', [App\Http\Controllers\CareerPathController::class, 'show'])->name('career-paths.show');

    Route::get('/debug-avatar', function() {
    $user = auth()->user();
    
    if (!$user) {
        return "Please login first";
    }
    
    $output = "<h1>Debug Avatar</h1>";
    
    // Cek data user
    $output .= "<h2>User Data:</h2>";
    $output .= "<pre>";
    $output .= "Name: " . $user->name . "\n";
    $output .= "Avatar path in DB: " . ($user->avatar ?? 'null') . "\n";
    $output .= "</pre>";
    
    // Cek file
    if ($user->avatar) {
        $output .= "<h2>File Check:</h2>";
        
        // Cek di storage
        $storagePath = storage_path('app/public/' . $user->avatar);
        $output .= "Storage path: " . $storagePath . "<br>";
        $output .= "File exists in storage: " . (file_exists($storagePath) ? 'YES' : 'NO') . "<br>";
        
        // Cek di public
        $publicPath = public_path('storage/' . $user->avatar);
        $output .= "Public path: " . $publicPath . "<br>";
        $output .= "File exists in public: " . (file_exists($publicPath) ? 'YES' : 'NO') . "<br>";
        
        // URL
        $url = Storage::url($user->avatar);
        $output .= "Storage::url(): " . $url . "<br>";
        $output .= "Full URL: " . url($url) . "<br>";
        
        // Tampilkan gambar
        $output .= "<h2>Image Test:</h2>";
        $output .= "<img src='" . Storage::url($user->avatar) . "' style='max-width:200px; border:1px solid red;'><br>";
        $output .= "<img src='" . url('storage/' . $user->avatar) . "' style='max-width:200px; border:1px solid blue;'><br>";
    }
    
    return $output;
})->middleware('auth');
});

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/jobs/matches', [App\Http\Controllers\Api\JobMatchController::class, 'getMatches']);
});