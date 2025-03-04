@foreach ($comments as $comment)
    <div>
        <p>{{ $comment->content }}</p>
        <small>By: {{ $comment->user->name }}</small>

        <!-- like button all comments-->
        <form action="{{ route('like.toggle') }}" method="POST">
            @csrf
            <input type="hidden" name="likeable_id" value="{{ $comment->id }}">
            <input type="hidden" name="likeable_type" value="comment">
            <button type="submit">👍 Like</button>
        </form>
    </div>
@endforeach
