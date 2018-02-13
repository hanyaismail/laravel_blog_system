@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/posts/create" class="btn btn-primary">Create Post</a>
                    <h3>Your Blog Posts</h3>
                    <table class="table table-stripe">
                        @if(count($posts)>0)
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($posts as $post)
                                <tr>
                                <th>{{$post->title}}</th>
                                <th><a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a></th>
                                <th>
                                    {!! Form::open(['action'=> ['PostsController@destroy', $post->id], 'method'=>'DELETE', 'class' => 'pull-right']) !!}
                                        {{Form::submit('Delete', ['class' => 'btn btn-primary'])}}
                                    {!! Form::close() !!}
                                </th>
                            </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
