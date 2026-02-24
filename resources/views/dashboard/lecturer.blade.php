@extends('layouts.app')

@section('title', 'Dashboard Dosen - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Dosen</h1>
                    <p class="mt-2 text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}! Kelola mentoring dan bimbingan mahasiswa.</p>
                </div>
                <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                    <i class="fas fa-chalkboard-teacher mr-2"></i> Dosen Pembimbing
                </span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Mentee</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">24</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-green-600 mt-2"><i class="fas fa-arrow-up mr-1"></i> +3 minggu ini</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sesi Mentoring</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">12</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-blue-600 mt-2">Bulan ini</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Review CV</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">8</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-file-alt text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-orange-600 mt-2">3 menunggu review</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Permintaan Pending</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">5</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-red-600 mt-2">Perlu segera direspon</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Mentoring Requests -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Permintaan Mentoring</h3>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-4">
                                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&size=48" class="w-12 h-12 rounded-full">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Budi Santoso</h4>
                                    <p class="text-sm text-gray-500">Teknik Informatika - Semester 6</p>
                                    <p class="text-xs text-gray-400 mt-1">Meminta bimbingan tentang karir di bidang data science</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-600 text-xs rounded-full">Pending</span>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                                    Terima
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-4">
                                <img src="https://ui-avatars.com/api/?name=Ani+Wijaya&size=48" class="w-12 h-12 rounded-full">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Ani Wijaya</h4>
                                    <p class="text-sm text-gray-500">Sistem Informasi - Semester 8</p>
                                    <p class="text-xs text-gray-400 mt-1">Konsultasi persiapan karir setelah lulus</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-600 text-xs rounded-full">Pending</span>
                                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                                    Terima
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Sessions -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Jadwal Mentoring Mendatang</h3>

                    <div class="space-y-4">
                        <div class="flex items-center p-4 border border-gray-200 rounded-xl">
                            <div class="w-16 text-center">
                                <span class="text-2xl font-bold text-blue-600">25</span>
                                <p class="text-xs text-gray-500">Mar 2024</p>
                            </div>
                            <div class="flex-1 ml-4">
                                <h4 class="font-semibold text-gray-900">Review CV & Portofolio</h4>
                                <p class="text-sm text-gray-500">dengan <span class="font-medium">Budi Santoso</span></p>
                                <div class="flex items-center text-xs text-gray-400 mt-1">
                                    <i class="far fa-clock mr-1"></i> 14:00 - 15:00 WIB
                                    <i class="fas fa-video ml-3 mr-1"></i> Online
                                </div>
                            </div>
                            <button class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg text-sm hover:bg-blue-50 transition">
                                Masuk Meeting
                            </button>
                        </div>

                        <div class="flex items-center p-4 border border-gray-200 rounded-xl">
                            <div class="w-16 text-center">
                                <span class="text-2xl font-bold text-blue-600">27</span>
                                <p class="text-xs text-gray-500">Mar 2024</p>
                            </div>
                            <div class="flex-1 ml-4">
                                <h4 class="font-semibold text-gray-900">Konsultasi Karir</h4>
                                <p class="text-sm text-gray-500">dengan <span class="font-medium">Ani Wijaya</span></p>
                                <div class="flex items-center text-xs text-gray-400 mt-1">
                                    <i class="far fa-clock mr-1"></i> 10:00 - 11:00 WIB
                                    <i class="fas fa-map-marker-alt ml-3 mr-1"></i> Ruang Bimbingan
                                </div>
                            </div>
                            <button class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg text-sm hover:bg-blue-50 transition">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Profile Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 text-center">
                    <img src="{{ auth()->user()->avatar ? asset('uploads/avatars/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&size=80' }}" 
                         class="w-20 h-20 rounded-full mx-auto border-4 border-blue-100">
                    <h3 class="text-lg font-semibold text-gray-900 mt-4">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mt-3">
                        Dosen Pembimbing
                    </span>
                    
                    <div class="border-t border-gray-100 mt-4 pt-4 text-left">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">NIDN</span>
                            <span class="text-sm font-medium text-gray-900">123456789</span>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Fakultas</span>
                            <span class="text-sm font-medium text-gray-900">Ilmu Komputer</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Program Studi</span>
                            <span class="text-sm font-medium text-gray-900">Teknik Informatika</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Mentee Aktif</span>
                            <span class="font-medium text-gray-900">21 Mahasiswa</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Sesi Selesai</span>
                            <span class="font-medium text-gray-900">45 Sesi</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Review CV</span>
                            <span class="font-medium text-gray-900">32 CV</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Rating</span>
                            <span class="font-medium text-gray-900">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                                4.8
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection