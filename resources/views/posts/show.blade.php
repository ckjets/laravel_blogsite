@extends('layouts.app')
@section('content')

<a href="/posts" class="btn btn-primary">Go Back</a>
  <h1>{{$post->title}}</h1>
  <br><br>
  @if($post->cover_image !== 'noimage.png')
  <img style="width:100% height:50%" src="/storage/cover_image/{{$post->cover_image}}">
  @endif
  <br><br>
  <div>
   {!!$post->body!!}
  </div>
<small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
<hr>

{{-- ログインしないとEditおよびDeleteボタンが表示されない --}}
@if(!Auth::guest())
{{-- user() = table --}}
{{-- 投稿者しかeditとdeleteできないしくみ --}}
@if(Auth::user()->id == $post->user_id)
<a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a>

{!! Form::open(['action' => ['PostsController@destroy',$post->id],'method'=>'POST','class'=>'float-right']) !!}

{{Form::hidden('_method','DELETE')}}

{{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
{!! Form::close() !!}
@endif
@endif

@endsection