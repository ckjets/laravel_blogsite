@extends('layouts.app')
@section('content')
        <h2>{{$title}}</h2>
        @if(count($services)>0)
            <ul>
                @foreach ($services as $service)
                    <li>{{$service}}</li>
                @endforeach                
            </ul>
        @endif

@endsection