<div class="form-group">
    <label for="">Title</label>
    <input type="text" name="title" class="form-control" value="{{ $post->title }}">
</div>
<div class="form-group">
    <label for="">Description</label>
    <textarea name="description" id="" rows="3" class="form-control">{{ $post->description }}</textarea>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Save Post</button>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
</div>