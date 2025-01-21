@extends('welcome')

@section('title', 'Save')

@section('content')

<div class="container8">
    <h1 class="mb-4">My Saved Posts</h1>

    <div class="saved-posts">
        @forelse ($savedPosts as $savedPost)
            <div class="post">
                <div class="post-header">
                    <div class="post-meta">
                        <strong>{{ $savedPost->post->user->name }}</strong>
                        <div>Sauvegardé le {{ $savedPost->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
                @if($savedPost->post->image)
                    <div>
                        <img src="{{ asset('storage/images/' . $savedPost->post->image) }}" alt="Image du post">
                    </div>
                @endif
                <p>{{ $savedPost->post->content }}</p>

                <div class="post-options">
                    <button class="unsave-button" data-post-id="{{ $savedPost->post->id }}">
                        <i class="fas fa-bookmark"></i> Retirer des sauvegardes
                    </button>
                </div>
            </div>
        @empty
            <p>You haven't saved any articles yet.</p>
        @endforelse
    </div>
</div>
@endsection
