<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of events with filters.
     */
    public function index(Request $request)
    {
        $query = Event::withCount('registrations')
            ->where('end_date', '>', now());

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'LIKE', "%{$request->search}%")
                  ->orWhere('description', 'LIKE', "%{$request->search}%");
            });
        }

        // Type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Date range filter
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->where('start_date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->where('end_date', '<=', $request->end_date);
        }

        // Featured filter
        if ($request->has('featured') && $request->featured) {
            $query->where('is_featured', true);
        }

        // Price filter
        if ($request->has('is_paid')) {
            $query->where('is_paid', $request->boolean('is_paid'));
        }

        // Sorting
        $sort = $request->get('sort', 'upcoming');
        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'upcoming':
                $query->orderBy('start_date', 'asc');
                break;
            case 'popular':
                $query->orderBy('registrations_count', 'desc');
                break;
            default:
                $query->orderBy('start_date', 'asc');
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $events = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => EventResource::collection($events),
            'meta' => [
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage(),
                'per_page' => $events->perPage(),
                'total' => $events->total(),
                'filters' => [
                    'types' => Event::distinct('type')->pluck('type'),
                ],
            ],
        ]);
    }

    /**
     * Display the specified event.
     */
    public function show($id)
    {
        $event = Event::withCount('registrations')->findOrFail($id);
        
        // Check if user is registered
        $isRegistered = false;
        $registration = null;
        
        if (request()->user()) {
            $registration = $event->registrations()
                ->where('user_id', request()->user()->id)
                ->first();
            $isRegistered = !is_null($registration);
        }

        // Get related events
        $relatedEvents = Event::where('type', $event->type)
            ->where('id', '!=', $event->id)
            ->where('end_date', '>', now())
            ->withCount('registrations')
            ->limit(3)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'event' => new EventResource($event),
                'is_registered' => $isRegistered,
                'registration' => $registration,
                'related_events' => EventResource::collection($relatedEvents),
            ],
        ]);
    }

    /**
     * Register for an event.
     */
    public function register(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Check if event is full
        if ($event->isFull()) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, this event is already full.',
            ], 400);
        }

        // Check if already registered
        $existingRegistration = $event->registrations()
            ->where('user_id', $request->user()->id)
            ->first();

        if ($existingRegistration) {
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event.',
            ], 400);
        }

        // Create registration
        $registration = $event->registrations()->create([
            'user_id' => $request->user()->id,
            'status' => 'registered',
            'registered_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully registered for the event.',
            'data' => [
                'registration_id' => $registration->id,
                'qrcode' => $registration->qrcode,
                'qrcode_url' => route('api.events.qrcode', $registration->id),
            ],
        ], 201);
    }

    /**
     * Check-in to an event (for organizers).
     */
    public function checkIn(Request $request, $token)
    {
        $registration = \App\Models\EventRegistration::where('qrcode', $token)->firstOrFail();
        
        if ($registration->checked_in_at) {
            return response()->json([
                'success' => false,
                'message' => 'Already checked in at ' . $registration->checked_in_at->format('d M Y H:i'),
            ], 400);
        }

        $registration->update([
            'status' => 'attended',
            'checked_in_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in successful!',
            'data' => new EventResource($registration->event),
        ]);
    }

    /**
     * Get user's registered events.
     */
    public function myEvents(Request $request)
    {
        $registrations = $request->user()->eventRegistrations()
            ->with('event')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $registrations,
        ]);
    }
}