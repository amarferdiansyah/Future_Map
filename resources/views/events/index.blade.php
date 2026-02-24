@extends('layouts.app')

@section('title', 'Event & Webinar - FutureMap')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Event & Webinar</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Ikuti berbagai event, workshop, dan seminar untuk mengembangkan skill dan jaringanmu</p>
        </div>

        <!-- Featured Event -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl shadow-xl overflow-hidden mb-12">
            <div class="grid md:grid-cols-2">
                <div class="p-8 md:p-12 text-white">
                    <span class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-medium mb-4">Featured Event</span>
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">Career Preparation Workshop 2024</h2>
                    <p class="text-blue-100 mb-6">Pelajari tips & trik lolos interview kerja, cara membuat CV yang menarik, dan networking dengan HRD perusahaan top.</p>
                    
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center">
                            <i class="fas fa-calendar w-6"></i>
                            <span>25 Maret 2024, 14:00 - 17:00 WIB</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt w-6"></i>
                            <span>Online via Zoom</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-users w-6"></i>
                            <span>250+ Peserta sudah mendaftar</span>
                        </div>
                    </div>

                    <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-xl font-medium hover:shadow-lg transition">
                        Daftar Sekarang <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="hidden md:block bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3')"></div>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-8">
            <form method="GET" action="{{ route('events.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari event..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <div class="w-48">
                    <select name="type" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="">Semua Tipe</option>
                        @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </form>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden card-hover group">
                <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 relative">
                    @if($event->is_featured)
                    <div class="absolute top-4 right-4 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-medium">
                        <i class="fas fa-star mr-1"></i> Featured
                    </div>
                    @endif
                    <div class="absolute top-4 left-4 bg-white px-3 py-1 rounded-full text-xs font-medium text-blue-600">
                        {{ ucfirst($event->type) }}
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="fas fa-calendar mr-2"></i>
                        {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y, H:i') }}
                    </div>
                    
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition">
                        <a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a>
                    </h3>
                    
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $event->description }}</p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-users mr-2"></i>
                            <span>{{ $event->registrations_count ?? 0 }} peserta</span>
                        </div>
                        
                        @if($event->is_paid)
                        <span class="font-semibold text-gray-900">Rp {{ number_format($event->price) }}</span>
                        @else
                        <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Gratis</span>
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('events.show', $event->slug) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Event</h3>
                <p class="text-gray-500">Belum ada event yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $events->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection