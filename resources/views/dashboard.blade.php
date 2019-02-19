@extends('layouts.app')

@section('content')
<div class="container">
    {{-- search function --}}
    <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <form action="/search" method="GET">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control">
                        <span class="input-group-prepend">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </span>
                    </div>
                </form>
            </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <a href="/posts/create" class="btn btn-primary">Create Post</a>
                        <h3>Your Blog Posts</h3>
                        @if(count($posts)>0)
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th>Body</th>
                                <th></th>
                                <th></th>
                            </tr>
                            
                            @foreach ($posts as $post)
                            <tr>
                                    <th>{{$post->title}}</th>
                                    <th>{!!$post->body!!}</th>
                                    <th><a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit</a></th>
                                    <th>
                                        {!! Form::open(['action' => ['PostsController@destroy',$post->id],'method'=>'POST','class'=>'float-right']) !!}
                                        {{Form::hidden('_method','DELETE')}}
                                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!! Form::close() !!}
                                    </th>
                              </tr>
                            @endforeach

                        </table>
                        @else
                        <p>You have no posts</p>
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
