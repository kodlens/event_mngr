@extends('layouts.admin-layout')

@section('content')
    @auth()
        <event-attendee-index :prop-event-id="{{$eventId}}" :prop-user='{{ Auth::user() }}'></event-attendee-index>
    @endauth
@endsection
