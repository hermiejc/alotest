@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Show Post') }}</div>

                <div class="card-body">
                    <div>
                        Title: <strong>{{ $post->title }}</strong>
                    </div>
                    <div>
                        Description: <strong>{{ $post->description }}</strong>
                    </div>
                    <div>
                        Comments:
                    </div>
                    <comments endpoint="{{ route('posts.comments.index', $post)  }}" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
