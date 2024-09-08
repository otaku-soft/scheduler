@foreach ($events as $event)
    {{ $event->name }}
@endforeach
@if (count($events) === 0)
    No Events
    <br/><br/>
@endif