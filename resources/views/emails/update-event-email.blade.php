@component('mail::message')
<strong>Northwesthern Mindanao State College</strong><br>
Labuyo, Tangub City, Misamis Occidental<br>

<br>


# EVENT UPDATED
An update of the event was made. Please check below the update.
<br>
<br>
<strong>OLD EVENT INFORMATION</strong>
<ul>
    <li>{{ $oldEvent->event }}</li>
    <li>{{ $oldEvent->venue->event_venue }}</li>
    <li>{{ date('Y-M-d', strtotime($oldEvent->event_date)) }}</li>
    <li>{{ date('H:i A', strtotime($oldEvent->event_time_from)) }}
        -
        {{ date('H:i A', strtotime($oldEvent->event_time_to)) }}
    </li>

</ul>

<br>
<strong>NEW UPDATED INFORMATION</strong>
<ul>
    <li>{{ $updatedEvent->event }}</li>
    <li>{{ $newEventVenue->event_venue }}</li>
    <li>{{ date('Y-M-d', strtotime($newEventDate)) }}</li>
    <li>
        {{ date('H:i A', strtotime($newEventFrom)) }} 
        - 
        {{ date('H:i A', strtotime($newEventTo)) }}
    </li>
   
</ul>

<br>

Thanks,<br>
Northwesthern Mindanao State College
@endcomponent
