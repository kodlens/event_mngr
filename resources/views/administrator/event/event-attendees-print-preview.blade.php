@extends('layouts.print-layout')

@section('content')
    <event-attendee-print-preview 
        :prop-data='@json($data)'></event-attendee-print-preview>
@endsection
