@extends('welcome')

@section('title', 'History')

@section('content')

{{----}}
<div class="history-container">
    <div class="history-header">
        <h1 class="history-title">Historique de recherche</h1>
        <button class="clear-history-btn" >Effacer l'historique</button>
    </div>

    <div class=" search-bar">
        <i class="search-icon">🔍</i>
        <input type="text" class="search-input" placeholder="Rechercher dans l'historique...">

        <div class="search-results">
            <!-- Les résultats de recherche dynamiques apparaîtront ici -->
        </div>
    </div>

    <div class="history-list">
        @forelse($histories as $history)
            <div class="history-item" data-article-id="{{ $history->article->id }}">
                <h3 class="history-item-title">{{ $history->article->title }}</h3>
                <div class="history-itm-meta">
                    <span class="history-tag">{{ $history->article->theme->name }}</span>
                    <span class="history-time">
                        <i class='bx bx-time'></i>
                        {{ $history->created_at->diffForHumans() }}
                    </span>
                    <span class="history-status">
                        Statut : {{ $history->status }}
                    </span>
                </div>
            </div>
        @empty
            <div class="no-results">Aucun historique de recherche</div>
        @endforelse
    </div>
</div>

@endsection
