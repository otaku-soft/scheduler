<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\GlobalEvents;

class EventsController extends Controller
{
    public function index() : View
    {
        return view('admin.events.index');
    }
    public function addEventModal() : View
    {
        return view('admin.events.add-event-modal');
    }
    public function eventList() : View
    {
        $events = [];
        $globalEvents = GlobalEvents::all();
        foreach ($globalEvents as $globalEvent)
        {
            $events[] = $globalEvent->event();
        }
        return view('admin.events.event-list',["events" => $events]);
    }
}