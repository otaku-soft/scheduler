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
        return view('admin.events.add-edit-event-modal',["saveRoute" => 'events_addEvent']);
    }
    public function addEvent(Request $request): JsonResponse
    {
        $event = new Events();
        $globalEvent = new GlobalEvents();
        $this->saveEvent($event,$request->get("name"),$request->get("dates"),$request->get("specificDates"),$request->get("patterns"),$request->get("open"));
        $globalEvent->event_id = $event->id;
        $globalEvent->save();
        return new JsonResponse(["success" => true]);
    }
    public function editEventModal(Request $request) : View
    {
        $event = Events::find($request->get("id"));
        return view('admin.events.add-edit-event-modal',["eventDataRoute" => "events_eventData","saveRoute" => 'events_editEvent',"event" => $event]);
    }
    public function eventData(Request $request): JsonResponse
    {
        $event = Events::find($request->get("id"));
        return new JsonResponse($event->toArray());
    }
    public function editEvent(Request $request) : JsonResponse
    {
        $event = Events::find($request->get("id"));
        $this->saveEvent($event,$request->get("name"),$request->get("dates"),$request->get("specificDates"),$request->get("patterns"),$request->get("open"));
        return new JsonResponse(["success" => true]);
    }
    private function saveEvent($event,string $name, ?array $dates,?array $specificDates,?array $patterns, bool $open)
    {
        $event->name = $name;
        $event->active = false;
        $json = ["dates" => [],"specificDates" => [],"patterns" => []];
        $event->open = $open;
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
            foreach ($patterns as $key => $pattern)
            {
                $addPattern = [];
                if ($pattern['weekNumber'] >= 1 && $pattern['weekNumber'] <= 5 &&  in_array($pattern['dayOfWeek'],["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"]))
                {
                    $addPattern['dayOfWeek'] = (string)$pattern['dayOfWeek'];
                    $addPattern['weekNumber'] = (int)$pattern['weekNumber'];
                    $json['patterns'][$key] = $addPattern;
                }
            }
        $event->dates = json_encode($json);
        $event->save();
    }
}