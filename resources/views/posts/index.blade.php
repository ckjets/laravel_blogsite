@extends('layouts.app')
@section('content')

<h1>Posts</h1>
@if(count($posts)>0)
@foreach ($posts as $post)
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-4">
         <img style="width:100%" src="/storage/cover_image/{{$post->cover_image}}">
        </div>
        <div class="col-md-8 col-sm-8">
          <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
          {{-- !! = HTMLから変換される (太字などそのまま反映される) --}}
          <p>{!!$post->body!!}</p>
          <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
          
        </div>
    </div>
    <hr>
</div>
@endforeach
{{$posts->links()}}
 @else
    <p>No post found.</p>
 @endif

@endsection
