<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Http\Request;

class EventRegistrationController extends Controller
{
    public function myEvents()
    {
        $registrations = EventRegistration::where('user_id', auth()->id())
            ->with('event')
            ->latest()
            ->paginate(10);

        return view('events.my-events', compact('registrations'));
    }
}