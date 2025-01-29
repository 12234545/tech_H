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
            <div class="subscribers-container">
                <h3>Abonnés du thème</h3>
                <div class="subscribers-list">
                    @forelse($allSubscribers as $subscriber)
    <div class="subscriber-item">
        <div class="subscriber-info">
            <span class="subscriber-name">{{ $subscriber['name'] }}</span>
            <span class="subscriber-type">{{ $subscriber['type'] === 'admin' ? 'Administrateur' : 'Utilisateur' }}</span>
        </div>
        @if($theme->responsible === auth()->guard('admin')->user()->firstname . ' ' . auth()->guard('admin')->user()->lastname)

        <form action="{{ route('admin.themes.unsubscribe', ['theme' => $theme->id, 'subscriberType' => $subscriber['type'], 'subscriberId' => $subscriber['id']]) }}"
            method="POST"
            class="unsubscribe-form"
            onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cet abonné ?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="unsubscribe-btn">
              <ion-icon name="close-circle-outline"></ion-icon>
          </button>
      </form>
        @endif
    </div>
@empty
    <p class="no-subscribers">Aucun abonné pour le moment</p>
@endforelse
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
                    <div class="article-actions">
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">
                                <ion-icon name="trash-outline"></ion-icon> Supprimer
                            </button>
                        </form>
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
    .unsubscribe-form {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}

.unsubscribe-btn {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    margin-left: 20px;
    padding: 5px;
    display: flex;
    align-items: center;
    font-size: 1.2em;
    transition: color 0.3s;
}

.unsubscribe-btn:hover {
    color: #c82333;
}


/**/
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



.article-actions {
    margin-top: 15px;
    display: flex;
    justify-content: flex-end;
}

.delete-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 15px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.delete-btn:hover {
    background-color: #c82333;
}

.delete-form {
    display: inline-block;
}



.subscribers-container {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.subscribers-container h3 {
    font-size: 1.1rem;
    color: #4a5568;
    margin-bottom: 15px;
}

.subscribers-list {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    max-height: 200px;
    overflow-y: auto;
    padding: 10px 0;
}

.subscriber-item {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f7fafc;
    padding: 8px 12px;
    border-radius: 6px;
    min-width: 200px;
    position: relative;
}

.subscriber-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    background: #e2e8f0;
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #4a5568;
    color: white;
    font-weight: bold;
}

.subscriber-info {
    display: flex;
    flex-direction: column;
}

.subscriber-name {
    font-weight: 500;
    color: #2d3748;
    font-size: 0.9rem;
}

.subscriber-type {
    font-size: 0.75rem;
    color: #718096;
}

.no-subscribers {
    width: 100%;
    text-align: center;
    color: #718096;
    font-style: italic;
    padding: 20px 0;
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const unsubscribeForms = document.querySelectorAll('.unsubscribe-form');

        unsubscribeForms.forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (confirm('Êtes-vous sûr de vouloir retirer cet abonné ?')) {
                    const formData = new FormData(this);
                    formData.append('_method', 'DELETE');

                    try {
                        const response = await fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        if (response.ok) {
                            window.location.reload();
                        } else {
                            alert('Erreur lors de la suppression.');
                        }
                    } catch (error) {
                        console.error('Erreur:', error);
                        alert('Erreur lors de la suppression.');
                    }
                }
            });
        });
    });
    </script>
@endsection
