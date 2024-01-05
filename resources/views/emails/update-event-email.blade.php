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
    <li>{{ date('Y-M-d', strtotime($oldEvent->event_date_from)) }} - {{ date('Y-M-d', strtotime($oldEvent->event_date_to)) }}</li>
    <li>{{ date('h:i A', strtotime($oldEvent->event_time_from)) }} - {{ date('h:i A', strtotime($oldEvent->event_time_to)) }}</li>
</ul>

<br>
<strong>NEW UPDATED INFORMATION</strong>
<ul>
    <li>{{ $updatedEvent }}</li>
    <li>{{ $newEventVenue->event_venue }}</li>
    <li>{{ date('Y-M-d', strtotime($newEventDateFrom)) }} - {{ date('Y-M-d', strtotime($newEventDateTo)) }}</li>
    <li>{{ date('h:i A', strtotime($newEventTimeFrom)) }} - {{ date('h:i A', strtotime($newEventTimeTo)) }}</li>
</ul>

<br>

Thanks,<br>
Northwestern Mindanao State College
@endcomponent
