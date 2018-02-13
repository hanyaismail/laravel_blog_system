@extends('layouts.app')

@section('content')
	<h1>Create Post</h1>
	{{-- Kalau mau ada upload file pake attribut 'enctype' => 'multipart/data' --}}
	{!! Form::open(['action'=> 'PostsController@store', 'method'=>'POST', 'enctype' => 'multipart/form-data']) !!}
		<div class="form-group">
			{{Form::label('title', 'Title')}}
			{{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
		</div>
		<div class="form-group">
			{{Form::label('body', 'Body')}}
			{{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
		</div>
		<div class="form-group">
			{{-- Upload file dan diberi nama cover_image --}}
			{{Form::file('cover_image')}}
		</div>
		{{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
	{!! Form::close() !!}
@endsection