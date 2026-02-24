<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('end_date', '>', now());

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->withCount('registrations')
                       ->orderBy('start_date')
                       ->paginate(9);
        
        $types = Event::distinct('type')->pluck('type');

        return view('events.index', compact('events', 'types'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)
                      ->withCount('registrations')
                      ->firstOrFail();
        
        $isRegistered = false;
        $registration = null;
        
        if (auth()->check()) {
            $registration = EventRegistration::where('event_id', $event->id)
                ->where('user_id', auth()->id())
                ->first();
            $isRegistered = !is_null($registration);
        }

        return view('events.show', compact('event', 'isRegistered', 'registration'));
    }

    public function register($id)
    {
        $event = Event::findOrFail($id);

        // Check if event is full
        if ($event->max_participants && $event->registrations()->count() >= $event->max_participants) {
            return back()->with('error', 'Maaf, acara sudah penuh.');
        }

        // Check if already registered
        $existingRegistration = EventRegistration::where('event_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'Anda sudah terdaftar di acara ini.');
        }

        // Create registration
        $registration = EventRegistration::create([
            'event_id' => $id,
            'user_id' => auth()->id(),
            'status' => 'registered',
        ]);

        return redirect()->route('events.show', $event->slug)
                        ->with('success', 'Pendaftaran event berhasil!');
    }
}