@extends('welcome')

@section('title', $theme->name)

@section('content')
<div class="container5">
    <div class="main-container">
        <div class="theme-header">
            <a href="{{ route('admin.mesthemes') }}" class="back-button">
                <ion-icon name="arrow-back-outline"></ion-icon> Retour à mes thèmes
            </a>
            <div class="theme-info">
                <div class="theme-icon-header">
                    <ion-icon name="{{ $theme->icon }}"></ion-icon>
                </div>
                <h2>{{ $theme->name }}</h2>
                <div class="theme-stats">
                    <span><ion-icon name="document-text-outline"></ion-icon> {{ $articles->total() }} articles</span>
                    <span><ion-icon name="people-outline"></ion-icon> {{ $theme->subscribers_count ?? 0 }} abonnés</span>
                </div>
            </div>
        </div>

        <!-- Liste des articles -->
        <div class="listhhhh">
            @if($articles->isEmpty())
                <div class="no-articles">
                    <p>Aucun article n'a été publié dans ce thème.</p>
                    <button onclick="openModal()" class="add-article-btn">
                        <ion-icon name="add-outline"></ion-icon> Ajouter un article
                    </button>
                </div>
            @endif

            @foreach($articles as $article)
                <div class="post">
                    <div class="post-header">
                        <div class="post-avatar">
                            <div class="modern-notification-avatar">

                                {{ substr($article->creator->name ?? 'A', 0, 1) }}

                            </div>
                        </div>
                        <div class="post-meta">
                            <strong>{{ $article->creator->name ?? 'Admin' }}</strong>
                            <div>{{ $article->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <img id="imageARTICLE" src="{{ $article->image }}" alt="{{ $article->title }}">
                    <h3>{{ $article->title }}</h3>
                    <p>{{ $article->content }}</p>

                    <div class="article-stats">
                        <span><i class="far fa-comment"></i> {{ $article->comments->count() }}</span>
                        <span><i class="far fa-star"></i> {{ $article->ratings()->avg('rating') ?? 0 }}/5</span>
                    </div>
                </div>
            @endforeach

            {{ $articles->links() }}
        </div>
    </div>
    <!-- Bouton flottant pour ajouter un article -->
    <div class="float-button" onclick="openModal()">+</div>
</div>

<!-- Modal pour ajouter un article (réutilisé du dashboard) -->
<div id="articleModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <h2 style="color: blanchedalmond;font-size: 30px">Ajouter un nouvel article</h2>
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" required style="color: rgb(237, 234, 234)">
            </div>
            <div class="form-group">
                <label for="content">Contenu</label>
                <textarea id="content" name="content" rows="6" required></textarea>
            </div>
            <input type="hidden" name="theme_id" value="{{ $theme->id }}">
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" required accept="image/*">
            </div>
            <button type="submit" class="submit-btn">Publier</button>
        </form>
    </div>
</div>

<style>
.theme-header {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.back-button {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #4a5568;
    text-decoration: none;
    margin-bottom: 15px;
    font-size: 0.9em;
}

.back-button:hover {
    color: #2d3748;
}

.theme-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.theme-icon-header {
    font-size: 2.5em;
    color: #4a5568;
    background: #f7fafc;
    padding: 10px;
    border-radius: 50%;
}

.theme-stats {
    display: flex;
    gap: 20px;
    margin-left: auto;
}

.theme-stats span {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #718096;
}

.no-articles {
    text-align: center;
    padding: 40px;
    background: #fff;
    border-radius: 8px;
    margin: 20px 0;
}

.add-article-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    margin: 20px auto 0;
    padding: 10px 20px;
    background: #4a5568;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.add-article-btn:hover {
    background: #2d3748;
}

.article-stats {
    display: flex;
    gap: 20px;
    margin-top: 15px;
    color: #718096;
}

.article-stats span {
    display: flex;
    align-items: center;
    gap: 5px;
}
</style>

<script>
    function openModal() {
        document.getElementById('articleModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('articleModal').style.display = 'none';
    }
</script>
@endsection
