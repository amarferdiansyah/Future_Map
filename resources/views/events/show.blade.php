@extends('layouts.app')

@section('title', $event->title . ' - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('events.index') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Event
            </a>
        </div>

        <!-- Event Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="h-64 bg-gradient-to-r from-blue-600 to-purple-600 relative">
                @if($event->is_featured)
                <div class="absolute top-6 right-6 bg-yellow-400 text-yellow-900 px-4 py-2 rounded-full text-sm font-medium">
                    <i class="fas fa-star mr-1"></i> Featured Event
                </div>
                @endif
            </div>

            <div class="p-8">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between">
                    <div>
                        <span class="inline-block px-4 py-2 bg-blue-100 text-blue-600 rounded-full text-sm font-medium mb-4">
                            {{ ucfirst($event->type) }}
                        </span>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
                    </div>

                    @auth
                    @if(!$isRegistered && !$event->isFull())
                    <button onclick="document.getElementById('registerModal').classList.remove('hidden')" 
                            class="mt-4 md:mt-0 px-8 py-4 gradient-bg text-white rounded-xl font-medium hover:shadow-lg transition">
                        <i class="fas fa-ticket-alt mr-2"></i>
                        Daftar Event
                    </button>
                    @elseif($isRegistered)
                    <div class="mt-4 md:mt-0 px-8 py-4 bg-green-100 text-green-600 rounded-xl font-medium">
                        <i class="fas fa-check-circle mr-2"></i>
                        Sudah Terdaftar
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Event</h2>
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <!-- Speakers -->
                @if($event->speakers && count($event->speakers) > 0)
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Pembicara</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($event->speakers as $speaker)
                        <div class="flex items-start space-x-4">
                            <img src="{{ $speaker['avatar'] ?? 'https://ui-avatars.com/api/?name='.urlencode($speaker['name']) }}" 
                                 class="w-16 h-16 rounded-full">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $speaker['name'] }}</h3>
                                <p class="text-sm text-gray-500">{{ $speaker['title'] ?? 'Pembicara' }}</p>
                                @if(isset($speaker['company']))
                                <p class="text-xs text-gray-400 mt-1">{{ $speaker['company'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Event</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 text-blue-600">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal & Waktu</p>
                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($event->start_date)->format('l, d F Y') }}</p>
                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }} WIB</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 text-blue-600">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Lokasi</p>
                                <p class="font-medium text-gray-900">{{ $event->location ?? 'Online' }}</p>
                                @if($event->online_url)
                                <a href="{{ $event->online_url }}" target="_blank" class="text-sm text-blue-600 hover:underline">
                                    Link Meeting <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 text-blue-600">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Kapasitas</p>
                                <p class="font-medium text-gray-900">{{ $event->registrations_count ?? 0 }}/{{ $event->max_participants ?? '∞' }} Peserta</p>
                                @if($event->isFull())
                                <span class="inline-block mt-1 px-2 py-1 bg-red-100 text-red-600 text-xs rounded-full">Penuh</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 text-blue-600">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Harga</p>
                                @if($event->is_paid)
                                <p class="font-semibold text-gray-900">Rp {{ number_format($event->price) }}</p>
                                @else
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Gratis</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Organizer Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Diselenggarakan Oleh</h3>
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                            F
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">FutureMap</h4>
                            <p class="text-sm text-gray-500">Platform Akademik & Karir</p>
                        </div>
                    </div>
                </div>

                <!-- Share Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bagikan Event</h3>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-200 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-400 hover:bg-blue-200 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 hover:bg-green-200 transition">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 hover:bg-blue-200 transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl max-w-md w-full mx-4">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Pendaftaran</h3>
                <button onclick="document.getElementById('registerModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <form action="{{ route('events.register', $event->id) }}" method="POST" class="p-6">
            @csrf
            
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">Anda akan mendaftar event:</h4>
                <p class="text-gray-600">{{ $event->title }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y, H:i') }}</p>
            </div>

            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Dengan mendaftar, Anda setuju untuk mengikuti event sesuai jadwal yang ditentukan.
                </p>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('registerModal').classList.add('hidden')"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                    Ya, Daftar Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection