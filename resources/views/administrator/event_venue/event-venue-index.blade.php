@extends('layouts.admin-layout')

@section('content')
    @auth()
        <event-venue-index></event-venue-index>
    @endauth
@endsection
