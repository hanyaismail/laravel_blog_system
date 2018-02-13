@extends('layouts.app')

@section('content')
	<h1>Posts</h1>
	@if(count($postsx) > 0)
		@foreach($postsx as $post)
			<div class="well">
				<div class="row">
					<div class="col-md-4 col-sm-4">
						<img style="width:100%" src="/storage/cover_image/{{$post->cover_image}}" alt="Display">
					</div>
					<div class="col-md-4 col-sm-4">
						<h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
						<small>Written on {{$post->created_at}} by {{$post->user->name}}</small>	
					</div>
				</div>
			</div>
		@endforeach
		{{$postsx->links()}}
	@else
		<p>No posts found</p>
	@endif
@endsection