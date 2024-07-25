<x-mail::message>
# Yesterday's Active Posts
<ul>
    @foreach($posts as $post)
        <li>
            <strong>Title:</strong> {{ $post->title }}<br>
            <strong>Author:</strong> {{ $post->created_user_id }}<br>
            <strong>Created At:</strong> {{ $post->created_at->format('Y-m-d') }}<br>
            <hr>
        </li>
    @endforeach
</ul>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
