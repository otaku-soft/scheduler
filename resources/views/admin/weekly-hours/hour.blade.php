@if ($hour === 0)
    12AM
@elseif ($hour === 12)
    12PM
@elseif ($hour < 12)
    {{ $hour   }}AM
@else
    {{ $hour-12 }}PM
@endif