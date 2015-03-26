@extends('layouts.main')

@section('content')
    @foreach($events as $event)
        <p>{{$event->title}}</p>
    @endforeach
@endsection