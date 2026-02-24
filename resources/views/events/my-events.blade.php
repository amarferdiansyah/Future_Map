@extends('layouts.app')

@section('title', 'Event Saya - FutureMap')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Event Saya</h1>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($registrations as $registration)
                <li>
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-blue-600 truncate">
                                    {{ $registration->event->title }}
                                </h3>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-calendar mr-1.5"></i>
                                            {{ $registration->event->start_date->format('d M Y, H:i') }}
                                        </p>
                                        <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                            <i class="fas fa-map-marker-alt mr-1.5"></i>
                                            {{ $registration->event->location ?? 'Online' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-2 flex-shrink-0">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($registration->status == 'registered') bg-yellow-100 text-yellow-800
                                    @elseif($registration->status == 'attended') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            </div>
                        </div>
                        @if($registration->qrcode)
                            <div class="mt-4">
                                <details>
                                    <summary class="text-sm text-blue-600 cursor-pointer">Tampilkan QR Code</summary>
                                    <div class="mt-2">
                                        <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(150)->generate($registration->qrcode)) }}" 
                                             class="border p-2 rounded">
                                    </div>
                                </details>
                            </div>
                        @endif
                    </div>
                </li>
            @empty
                <li class="px-4 py-8 text-center">
                    <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">Anda belum mendaftar event apapun.</p>
                    <a href="{{ route('events.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">
                        Lihat Events Tersedia
                    </a>
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $registrations->links() }}
    </div>
</div>
@endsection