@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Posts') }}</div>
                    <div><a href="{{ route('posts.create') }}" class="btn btn-light">New Post</a></div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></td>
                                <td>
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary float-left mr-3">Update</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure to delete {{ $post->title }} ?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
