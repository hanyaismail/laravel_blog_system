@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>Welcome To Laravel!</h1>
        <p>This is the laravel application from the "Laravel From Scratch" Youtube series</p>
        @if(!Auth::guest())
        	<p><a class="btn btn-primary btn-lg" href="/dashboard" role="button">Go To Dashboard &raquo;</a> <a class="btn btn-success btn-lg" href="/posts/create" role="button">Create Post &raquo;</a></p>
        @else
        	<p><a class="btn btn-primary btn-lg" href="/login" role="button">Login &raquo;</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register &raquo;</a></p>
        @endif
    </div>
@endsection
