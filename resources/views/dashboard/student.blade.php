@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Halo, {{ auth()->user()->name }}! 👋</h1>
                    <p class="mt-2 text-gray-600">Selamat datang kembali di dashboard mahasiswa. Yuk, lihat perkembangan karirmu!</p>
                </div>
                <div class="flex space-x-3">
                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        <i class="fas fa-user-graduate mr-2"></i> Mahasiswa Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Lamaran</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $myApplications->count() }}</p>
                        <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up mr-1"></i> +2 minggu ini</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Event Terdaftar</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ auth()->user()->eventRegistrations->count() }}</p>
                        <p class="text-xs text-blue-600 mt-2"><i class="fas fa-calendar mr-1"></i> 3 event bulan ini</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Beasiswa Tersedia</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $scholarships->count() }}</p>
                        <p class="text-xs text-orange-600 mt-2"><i class="fas fa-clock mr-1"></i> 5 deadline minggu ini</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Skill Profile</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ auth()->user()->skills->count() }} Skills</p>
                        <p class="text-xs text-purple-600 mt-2">65% match dengan target</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Profile -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Kelengkapan Profil</h3>
                <span class="text-sm font-medium text-blue-600">70%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-2.5 rounded-full" style="width: 70%"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-gray-600">Data diri terisi</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-gray-600">CV sudah diupload</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-hourglass-half text-yellow-500 mr-2"></i>
                    <span class="text-gray-600">Skill perlu ditambahkan</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content - Left & Center -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Recommended Jobs -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Lowongan Rekomendasi</h3>
                        <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($recommendedJobs as $job)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-briefcase text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $job->title }}</h4>
                                    <p class="text-sm text-gray-500">{{ $job->company->name }} • {{ $job->location ?? 'Remote' }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">Match {{ $job->match_score }}%</span>
                                        <span class="text-xs text-gray-400">{{ $job->type }}</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('jobs.show', $job->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                                Lihat
                            </a>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-4">Belum ada rekomendasi lowongan</p>
                        @endforelse
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Event Mendatang</h3>
                        <a href="{{ route('events.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($upcomingEvents as $event)
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between mb-2">
                                <span class="px-2 py-1 bg-blue-100 text-blue-600 text-xs rounded-full">{{ $event->type }}</span>
                                <span class="text-xs text-gray-400">{{ $event->start_date->format('d M') }}</span>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">{{ $event->title }}</h4>
                            <p class="text-xs text-gray-500 mb-3"><i class="far fa-clock mr-1"></i> {{ $event->start_date->format('H:i') }} WIB</p>
                            <a href="{{ route('events.show', $event->slug) }}" class="text-sm text-blue-600 hover:underline">Detail →</a>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-4 col-span-2">Belum ada event mendatang</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar - Right -->
            <div class="space-y-8">
                <!-- Profile Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 text-center">
                    <div class="relative inline-block mb-4">
                        <img src="{{ auth()->user()->avatar ? (filter_var(auth()->user()->avatar, FILTER_VALIDATE_URL) ? auth()->user()->avatar : asset('uploads/avatars/'.auth()->user()->avatar)) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&size=80&background=0D8F81&color=fff' }}" 
                             class="w-20 h-20 rounded-full mx-auto border-4 border-blue-100">
                        <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ auth()->user()->email }}</p>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mb-4">
                        {{ ucfirst(auth()->user()->getRoleNames()->first()) }}
                    </span>
                    
                    <div class="border-t border-gray-100 pt-4 text-left">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Jurusan</span>
                            <span class="text-sm font-medium text-gray-900">Teknik Informatika</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Semester</span>
                            <span class="text-sm font-medium text-gray-900">5</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">IPK</span>
                            <span class="text-sm font-medium text-gray-900">3.75</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="mt-4 block w-full py-2 bg-gray-50 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-100 transition">
                        <i class="fas fa-edit mr-2"></i> Edit Profile
                    </a>
                </div>

                <!-- Recent Applications -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Lamaran Terbaru</h3>
                    
                    <div class="space-y-3">
                        @forelse($myApplications as $application)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $application->job->title }}</p>
                                <p class="text-xs text-gray-500">{{ $application->job->company->name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($application->status == 'pending') bg-yellow-100 text-yellow-600
                                @elseif($application->status == 'accepted') bg-green-100 text-green-600
                                @elseif($application->status == 'rejected') bg-red-100 text-red-600
                                @else bg-blue-100 text-blue-600
                                @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 py-4">Belum ada lamaran</p>
                        @endforelse
                    </div>
                    
                    <a href="{{ route('my-applications') }}" class="mt-4 block text-center text-sm text-blue-600 hover:underline">
                        Lihat Semua Lamaran
                    </a>
                </div>

                <!-- Skill Progress -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Skill Progress</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-600">Laravel</span>
                                <span class="font-medium text-gray-900">80%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 80%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-600">React</span>
                                <span class="font-medium text-gray-900">60%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between text-sm mb-1">
                                <span class="text-gray-600">JavaScript</span>
                                <span class="font-medium text-gray-900">75%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="mt-4 block text-center text-sm text-blue-600 hover:underline">
                        Tambah Skill
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-hover {
    transition: all 0.3s ease;
}
.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
}
</style>
@endsection