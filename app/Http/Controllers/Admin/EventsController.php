<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\Events;
use Illuminate\Http\Request;
use App\Models\GlobalEvents;

class EventsController extends Controller
{
    const MAX_EVENTS = 10;
    public function index() : View
    {
        $events = [];
        $globalEvents = GlobalEvents::paginate(self::MAX_EVENTS);
        foreach ($globalEvents as $globalEvent)
        {
            $events[] = $globalEvent->event;
        }
        return view('admin.events.index',["events" => $events,"scopeEvents" => $globalEvents]);
    }
    public function addEventModal() : View
    {
        return view('admin.events.add-event-modal',["events"]);
    }
    public function addEvent(Request $request): JsonResponse
    {
        $event = new Events();
        $globalEvent = new GlobalEvents();
        $event->name = $request->get("name");
        $event->active = false;
        $json = ["dates" => [],"specificDates" => [],"patterns" => []];
        $dates = $request->get("dates");
        $specificDates = $request->get("specificDates");
        $patterns = $request->get("patterns");
        $event->open = $request->get("open");
        if (!empty($dates))
            foreach ($dates as $date)
            {
                $json["dates"][] = (string) $date;
            }
        if (!empty($specificDates))
            foreach ($specificDates as $date)
            {
                $json["specificDates"][] = (string) $date;
            }

        if (!empty($patterns))
            foreach ($patterns as $pattern)
            {
                $addPattern = [];
                if ($pattern['weekNumber'] >= 1 && $pattern['weekNumber'] <= 5 &&  in_array($pattern['dayOfWeek'],["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]))
                {
                    $addPattern['dayOfWeek'] = (string)$pattern['dayOfWeek'];
                    $addPattern['weekNumber'] = (int)$pattern['weekNumber'];
                    $json['patterns'][] = $addPattern;
                }
            }
        $event->dates = json_encode($json);
        $event->save();
        $globalEvent->event_id = $event->id;
        $globalEvent->save();
        return new JsonResponse(["success" => true]);
    }
}