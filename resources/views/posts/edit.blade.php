@extends('layouts.app')

@section('content')
	<h1>Create Post</h1>
	{!! Form::open(['action'=> ['PostsController@update', $post->id], 'method'=>'PUT', 'enctype' => 'multipart/form-data']) !!}
		<div class="form-group">
			{{Form::label('title', 'Title')}}
			{{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
		</div>
		<div class="form-group">
			{{Form::label('body', 'Body')}}
			{{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
		</div>
		<div class="form-group">
			{{-- Upload file dan diberi nama cover_image --}}
			{{Form::file('cover_image')}}
		</div>
		{{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
	{!! Form::close() !!}
@endsection