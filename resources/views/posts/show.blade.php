@extends('layouts.app')

@section('content')
	<a href="/posts" class="btn btn-default">Go Back</a>
	<h1>{{$post->title}}</h1>
	<div class="well">
		<div style="align-items: center">
		<img style="width:50%" src="/storage/cover_image/{{$post->cover_image}}" alt="Display">
		</div>
		{!!$post->body!!}
		<hr>
		<small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
	</div>
	@if(!Auth::guest())
		@if(Auth::user()->id == $post->user_id)
		    <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>

		    {!! Form::open(['action'=> ['PostsController@destroy', $post->id], 'method'=>'DELETE', 'class' => 'pull-right']) !!}
				{{Form::submit('Delete', ['class' => 'btn btn-primary'])}}
			{!! Form::close() !!}
		@endif
	@endif
@endsection