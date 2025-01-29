@extends('welcome')
@section('title','Profile')
@push('styles')
<style>
    :root {
 --primary-color: #2563eb;
 --primary-dark: #1d4ed8;
 --secondary-color: #64748b;
 --background-dark: #0f172a;
 --background-light: #1e293b;
 --text-light: #e2e8f0;
 --text-muted: #94a3b8;
 --success-color: #22c55e;
 --danger-color: #ef4444;
 --card-background: rgba(30, 41, 59, 0.8);
 --transition-speed: 0.3s;
}
.hidden {
 display: none;
}

body {
 margin: 0;
 padding-top: 100px;
 background: linear-gradient(135deg, var(--background-dark), #1a237e);
 font-family: 'Inter', sans-serif;
 color: var(--text-light);
 line-height: 1.6;
 min-height: 100vh;

}

main {
/* Container principal */
.profile-container {
 max-width: 95%; /* Augmenté à 95% de la largeur de la fenêtre */
 width: 95%;
 margin: 0 auto;
 padding: 2rem;
 display: grid;
 grid-template-columns: 300px 1fr; /* Colonne gauche plus étroite */
 gap: 3rem;
 background: var(--background-dark);
 min-height: calc(100vh - 80px);
}
.profile-container, nav {
 max-width: 1200px; /* ou une valeur plus petite comme 1000px */
 margin: 0 auto;
 padding: 2rem;
}

/* Colonne gauche */
.left-column {
 position: sticky;
 top: 100px;
 height: fit-content;
 background: var(--background-light);
 border-radius: 20px;
 padding: 2rem;
 box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
}
.right-column {
 max-width: 800px;
}

.profile-image {
 width: 150px;
 height: 150px;
 border-radius: 20px;
 border: 3px solid var(--primary-color);
 box-shadow: 0 0 20px rgba(37, 99, 235, 0.2);
}

.profile-image:hover {
 transform: scale(1.05);
 border-color: var(--success-color);
}

.personal-info {
 margin-top: 2rem;
 background: transparent;
 padding: 0;
}

.info-title {
 font-size: 1.5rem;
 color: var(--text-light);
 margin-bottom: 1.5rem;
 border-bottom: none;
 position: relative;
 padding-left: 1rem;
}
.info-title::before {
 content: '';
 position: absolute;
 left: 0;
 top: 50%;
 transform: translateY(-50%);
 width: 4px;
 height: 20px;
 background: var(--primary-color);
 border-radius: 2px;
}


.info-item {
 background: rgba(255, 255, 255, 0.05);
 padding: 1rem;
 border-radius: 12px;
 margin-bottom: 1rem;
 transition: transform 0.3s ease;
}

.info-item:hover {
 transform: translateX(5px);
 background: rgba(255, 255, 255, 0.08);
}
@keyframes slideIn {
 from {
     opacity: 0;
     transform: translateX(-20px);
 }
 to {
     opacity: 1;
     transform: translateX(0);
 }
}


.info-label {
 color: var(--text-muted);
 font-size: 0.9rem;
 margin-bottom: 0.3rem;
}

.info-value {
 color: var(--text-light);
 font-size: 1rem;
 font-weight: 500;
}

/* Stats */
.profile-stats {
 display: flex;
 gap: 1.5rem;
 margin-bottom: 3rem;
}

.stat-box {
 flex: 1;
 background: var(--background-light);
 border-radius: 20px;
 padding: 1.5rem;
 transition: transform 0.3s ease;
}

.stat-box::after {
 content: '';
 position: absolute;
 top: 0;
 left: 0;
 width: 100%;
 height: 100%;
 background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
 transform: translateX(-100%);
 transition: transform 0.6s ease;
}

.stat-number {
 font-size: 2.5rem;
 font-weight: bold;
 color: white;
 margin-bottom: 0.5rem;
 text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.stat-label {
 color: var(--text-light);
 font-size: 0.9rem;
 text-transform: uppercase;
 letter-spacing: 1px;
}

/* Thèmes */
.themes-container {
 display: grid;
 grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
 gap: 1.5rem;
 margin-bottom: 2rem;
}

.theme-card {
 position: relative;
 height: 200px;
 border-radius: 15px;
 overflow: hidden;
 cursor: pointer;
 transition: var(--transition-speed);
}

.theme-card::before {
 content: '';
 position: absolute;
 top: 0;
 left: 0;
 width: 100%;
 height: 100%;
 background: linear-gradient(
     to bottom,
     rgba(0, 0, 0, 0.2),
     rgba(0, 0, 0, 0.8)
 );
 z-index: 1;
 transition: var(--transition-speed);
}

.theme-image {
 width: 100%;
 height: 100%;
 object-fit: cover;
 transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.theme-card:hover .theme-image {
 transform: scale(1.1);
}

.theme-content {
 position: absolute;
 bottom: 0;
 left: 0;
 right: 0;
 z-index: 2;
 padding: 1.5rem;
 color: white;
 transform: translateY(30px);
 transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.theme-card:hover .theme-content {
 transform: translateY(0);
}

/* Articles */
.articles-list {
 display: grid;
 gap: 1.5rem;
}

.article-card {
 max-width: 800px;
 margin: 0 auto;
 background: var(--card-background);
 border-radius: 15px;
 padding: 1.5rem;
 position: relative;
 transition: var(--transition-speed);
 border-left: 4px solid var(--primary-color);
}
.article-card:not(.expanded) .article-excerpt {
 max-height: 4.8em; /* Hauteur pour environ 3 lignes */
 overflow: hidden;
}

.article-card:hover {
 transform: translateY(-5px);
 box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.article-header {
 display: flex;
 justify-content: space-between;
 align-items: center;
 margin-bottom: 1rem;
}

.article-title {
 font-size: 1.4rem;
 margin-bottom: 1rem;
}

.article-date {
 color: var(--text-muted);
 font-size: 0.9rem;
}

.article-excerpt {
 color: var(--text-muted);
 font-size: 0.95rem;
 line-height: 1.6;
 overflow: hidden;
 display: -webkit-box;
 position: relative;
 transition: all 0.3s ease;
 -webkit-box-orient: vertical;
}

.read-more {
 display: inline-block;
 margin-top: 1rem;
 color: var(--primary-color);
 font-weight: 500;
 cursor: pointer;
 transition: var(--transition-speed);
 padding: 0.5rem 1rem;
 border-radius: 0.375rem;
 background: rgba(37, 99, 235, 0.1);
}

.read-more:hover {
 color: var(--primary-dark);
 transform: translateX(5px);
 background: rgba(37, 99, 235, 0.2);
}

/* Ajoutez ces styles dans votre section CSS */

.article-card:not(.expanded) .article-excerpt::after {
 content: '';
 position: absolute;
 bottom: 0;
 left: 0;
 width: 100%;
 height: 2.4em;
 background: linear-gradient(transparent, var(--card-background));
}



.form-group {
 margin-bottom: 1.5rem;
}

.form-input {
 width: 100%;
 padding: 0.8rem;
 background: rgba(255, 255, 255, 0.1);
 border: 2px solid rgba(255, 255, 255, 0.1);
 border-radius: 8px;
 color: var(--text-light);
 transition: all 0.3s ease;
}

.form-input:focus {
 border-color: var(--primary-color);
 outline: none;
}


/* Responsive Design */
@media (max-width: 1200px) {
 .profile-container {
     padding: 1rem;
     grid-template-columns: 1fr;
 }

 .left-column {
     position: relative;
     top: 0;
     max-width: 100%;
 }

 .profile-stats {
     flex-direction: row;
     flex-wrap: wrap;
 }

 .stat-box {
     min-width: calc(50% - 1rem);
 }
}

@media (max-width: 768px) {
 .profile-stats {
     flex-direction: column;
 }

 .stat-box {
     min-width: 100%;
 }
}

@media (max-width: 480px) {
 .profile-stats {
     grid-template-columns: 1fr;
 }

 .nav-section {
     display: none;
 }
}
.themes-wrapper {
 position: relative;
 padding: 0 40px;
}

.themes-container {
 display: flex;
 overflow-x: hidden;
 scroll-behavior: smooth;
 gap: 1.5rem;
 padding: 1rem 0;
}

.theme-card {
 min-width: 280px; /* Fixe la largeur minimale */
 flex-shrink: 0; /* Empêche le rétrécissement */
}

.nav-button {
 position: absolute;
 top: 50%;
 transform: translateY(-50%);
 width: 40px;
 height: 40px;
 background: var(--primary-color);
 border: none;
 border-radius: 50%;
 color: white;
 cursor: pointer;
 display: flex;
 align-items: center;
 justify-content: center;
 z-index: 10;
 transition: var(--transition-speed);
}

.nav-button:hover {
 background: var(--primary-dark);
}

.nav-button.prev {
 left: 0;
}

.nav-button.next {
 right: 0;
}

/* Styles pour les options des articles */
.article-options {
 position: relative;
}

.options-menu {
 position: absolute;
 right: 0;
 top: 100%;
 background: var(--background-light);
 border-radius: 8px;
 box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
 display: none;
 z-index: 100;
 min-width: 150px;
}

.options-menu.active {
 display: block;
}

.option-item {
 padding: 10px 15px;
 cursor: pointer;
 transition: var(--transition-speed);
}

.option-item:hover {
 background: rgba(255, 255, 255, 0.1);
}

/* Style pour l'expansion des articles */
.article-excerpt {
 max-height: 4.8em; /* 3 lignes */
 overflow: hidden;
 transition: max-height 0.3s ease-out;
}

.article-card.expanded .article-excerpt {
 max-height: none;
}

/* Styles pour les conditions */
.condition-item {
 display: flex;
 align-items: center;
 padding: 0.8rem;
 margin-bottom: 0.5rem;
 background: rgba(255, 255, 255, 0.05);
 border-radius: 8px;
 color: var(--text-light);
}

.condition-icon {
 margin-right: 1rem;
 font-size: 1.2rem;
}

/* Style pour les conditions remplies/non remplies */
.condition-met {
 background: rgba(34, 197, 94, 0.1);
}

.condition-not-met {
 background: rgba(239, 68, 68, 0.1);
}
.modal {
 display: none;
 position: fixed;
 top: 0;
 left: 0;
 width: 100%;
 height: 100%;
 background-color: rgba(0, 0, 0, 0.5);
 z-index: 1000;
}

.modal-content {
 position: relative;
 background-color: #fff;
 margin: 5% auto;
 padding: 2rem;
 width: 90%;
 max-width: 600px;
 border-radius: 8px;
 box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.close-modal {
 position: absolute;
 right: 1.5rem;
 top: 1rem;
 font-size: 1.5rem;
 cursor: pointer;
 color: #666;
}

.close-modal:hover {
 color: #333;
}

.modal h2 {
 margin-bottom: 1.5rem;
 color: #333;
 font-size: 1.5rem;
 font-weight: 600;
}

.modal form > div {
 margin-bottom: 1.5rem;
}

.modal label {
 display: block;
 margin-bottom: 0.5rem;
 color: #555;
}

.modal input[type="text"],
.modal textarea {
 width: 100%;
 padding: 0.75rem;
 border: 1px solid #ddd;
 border-radius: 4px;
 font-size: 1rem;
}

.modal input[type="text"]:focus,
.modal textarea:focus {
 outline: none;
 border-color: rgba(30, 41, 59, 0.8);
}

.modal textarea {
 min-height: 150px;
 resize: vertical;
}

.modal button[type="submit"] {
 background-color: rgba(30, 41, 59, 0.8);
 color: white;
 padding: 0.75rem 1.5rem;
 border: none;
 border-radius: 4px;
 font-size: 1rem;
 cursor: pointer;
}

.modal button[type="submit"]:hover {
 background-color: rgba(30, 41, 59, 0.8);
}
.delete-article, .edit-article {
 display: inline-block;
 margin-top: 1rem;
 color: var(--primary-color);
 font-weight: 500;
 cursor: pointer;
 transition: var(--transition-speed);
 padding: 0.5rem 1rem;
 border-radius: 0.375rem;
 background: rgba(37, 99, 235, 0.1);
}
.delete-article:hover {
 color: var(--primary-dark);
 transform: translateX(5px);
 background: rgba(37, 99, 235, 0.2);
}
.edit-article:hover{
 color: var(--primary-dark);
 transform: translateX(5px);
 background: rgba(37, 99, 235, 0.2);
}
/* Styles des boutons du profil */
.profile-actions {
 display: flex;
 flex-direction: column;
 gap: 1rem;
 margin-top: 2rem;
 padding: 0 1rem;
 width: 100%;
}

.profile-actions .btn,
.profile-actions form,
.profile-actions form button {
 width: 100%;
 box-sizing: border-box;
}

.profile-actions .btn,
.profile-actions form button {
 display: block;
 padding: 0.8rem 1rem;
 border-radius: 8px;
 font-weight: 500;
 text-align: center;
 text-decoration: none;
 transition: all 0.3s ease;
 font-size: 0.95rem;
 cursor: pointer;
 margin: 0;
}

.profile-actions .btn-primary {
 background-color: #2563eb;
 color: white;
 box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
 border: none;
}

.profile-actions .btn-danger {
 background-color: transparent;
 border: 1.5px solid #ef4444;
 color: #ef4444;
}

.profile-actions .btn-primary:hover {
 background-color: #1d4ed8;
 transform: translateY(-1px);
 box-shadow: 0 4px 6px rgba(37, 99, 235, 0.3);
}

.profile-actions .btn-danger:hover {
 background-color: rgba(239, 68, 68, 0.1);
 transform: translateY(-1px);
 box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
}

/* Reset des styles de formulaire */
.profile-actions form {
 margin: 0;
 padding: 0;
}
 </style>
 @endpush

 @section('content')
 <main>
    <div class="container">
        <div class="profile-container">
            <!-- Colonne gauche -->
            <div class="left-column">
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Photo de profil" class="profile-image">

                <div class="personal-info">
                    <h3 class="info-title">Informations Personnelles</h3>

                    <div class="info-item">
                        <div class="info-label">Nom</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date d'inscription</div>
                        <div class="info-value">{{ $user->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>

                <div class="profile-actions">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier le profil</a>
                    <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer votre compte ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer le compte</button>
                    </form>
                </div>
            </div>

            <!-- Colonne droite -->
            <div class="right-column">
                <div class="profile-stats">
                    <div class="stat-box">
                        <div class="stat-number">{{ $followers }}</div>
                        <div class="stat-label">Followers</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ $following }}</div>
                        <div class="stat-label">Following</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ $articles->count() }}</div>
                        <div class="stat-label">Articles publiés</div>
                    </div>
                </div>

                <div class="activity-section">
                    <h3 class="info-title">Thèmes suivis</h3>
                    <div class="themes-wrapper">
                    <button class="nav-button prev">←</button>
                    <button class="nav-button next">→</button>
                    <div class="themes-container">
                        @foreach($themes as $theme)
                        <div class="theme-card">
                            <img src="{{ asset('images/' . $theme->image) }}" alt="{{ $theme->name }}" class="theme-image">
                            <div class="theme-content">
                                <div class="theme-title">{{ $theme->name }}</div>
                                <div class="theme-description">{{ $theme->description }}</div>
                                <div class="theme-stats">
                                    <div class="theme-stat">
                                        <span>📚 {{ $theme->articles_count }} articles</span>
                                    </div>
                                    <div class="theme-stat">
                                        <span>👥 {{ $theme->followers_count }} abonnés</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <h3 class="info-title">Mes Articles</h3>
                <div class="articles-list">
                    @foreach($articles as $article)
                        <div class="article-card">
                            <h4 class="article-title">{{ $article->title }}</h4>
                            <span class="article-date">{{ $article->created_at->format('d/m/Y') }}</span>
                            <p class="article-excerpt">{{ Str::limit($article->content, 100) }}</p>
                            <div class="article-full-content hidden">
                                {{ $article->content }}
                            </div>
                            <button class="read-more">Lire la suite</button>
                            <!-- Boutons Supprimer et Modifier -->
                            <button class="delete-article" data-article-id="{{ $article->id }}">Supprimer</button>
                            <button class="edit-article" data-article-id="{{ $article->id }}">Modifier</button>
                        </div>
                    @endforeach
                </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Pied de page -->

<div id="editArticleModal" class="modal">
<div class="modal-content">
    <span class="close-modal">&times;</span>
    <h2>Modifier l'article</h2>
    <form id="editArticleForm">
        <input type="hidden" id="editArticleId" name="id">
        <div>
            <label for="editArticleTitle">Titre :</label>
            <input type="text" id="editArticleTitle" name="title" required>
        </div>
        <div>
            <label for="editArticleContent">Contenu :</label>
            <textarea id="editArticleContent" name="content" required></textarea>
        </div>
        <button type="submit">Enregistrer</button>
    </form>
</div>
</div>
@endsection
@push('scripts')
<script>


    document.addEventListener('DOMContentLoaded', function() {
            console.log("Le DOM est chargé."); // Vérifiez que le script est exécuté

            // Sélectionnez tous les boutons "Lire la suite"
            const readMoreButtons = document.querySelectorAll('.read-more');
            console.log(`Nombre de boutons trouvés : ${readMoreButtons.length}`); // Vérifiez le nombre de boutons

            readMoreButtons.forEach(button => {
                button.addEventListener('click', function() {
                    console.log("Bouton cliqué !"); // Vérifiez que l'événement est déclenché

                    // Trouvez le contenu complet associé à ce bouton
                    const articleCard = button.closest('.article-card');
                    const fullContent = articleCard.querySelector('.article-full-content');

                    if (!fullContent) {
                        console.error("Contenu complet non trouvé !"); // Vérifiez que le contenu complet existe
                        return;
                    }

                    // Basculer l'affichage du contenu complet
                    if (fullContent.classList.contains('hidden')) {
                        fullContent.classList.remove('hidden');
                        button.textContent = 'Réduire'; // Changer le texte du bouton
                        console.log("Contenu affiché."); // Vérifiez que le contenu est affiché
                    } else {
                        fullContent.classList.add('hidden');
                        button.textContent = 'Lire la suite'; // Revenir au texte initial
                        console.log("Contenu masqué."); // Vérifiez que le contenu est masqué
                    }
                });
            });
        });
        const themesContainer = document.querySelector('.themes-container');
                const prevButton = document.querySelector('.nav-button.prev');
                const nextButton = document.querySelector('.nav-button.next');
                const scrollAmount = 300; // Ajustez selon vos besoins

                nextButton.addEventListener('click', () => {
                    themesContainer.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                });

                prevButton.addEventListener('click', () => {
                    themesContainer.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                });
                document.addEventListener('DOMContentLoaded', function() {
        // Supprimer un article
        document.querySelectorAll('.delete-article').forEach(button => {
            button.addEventListener('click', function() {
                const articleId = button.getAttribute('data-article-id');
                if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
                    fetch(`/articles/${articleId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Protection CSRF
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message);
                            // Supprimer l'article de l'interface
                            button.closest('.article-card').remove();
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                }
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('editArticleModal');
        const closeModalButton = modal.querySelector('.close-modal');
        const editArticleForm = document.getElementById('editArticleForm');

        // Ouvrir le modal lors du clic sur "Modifier"
        document.querySelectorAll('.edit-article').forEach(button => {
            button.addEventListener('click', function() {
                const articleId = button.getAttribute('data-article-id');
                const articleCard = button.closest('.article-card');
                const articleTitle = articleCard.querySelector('.article-title').textContent;
                const articleContent = articleCard.querySelector('.article-full-content').textContent;

                // Remplir le formulaire avec les données de l'article
                document.getElementById('editArticleId').value = articleId;
                document.getElementById('editArticleTitle').value = articleTitle;
                document.getElementById('editArticleContent').value = articleContent;

                // Afficher le modal
                modal.style.display = 'block';
            });
        });

        // Fermer le modal lors du clic sur la croix
        closeModalButton.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Fermer le modal lors du clic en dehors du modal
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Gérer la soumission du formulaire
        editArticleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const articleId = document.getElementById('editArticleId').value;
            const formData = new FormData(this);

            fetch(`/articles/${articleId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Protection CSRF
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    title: formData.get('title'),
                    content: formData.get('content'),
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    modal.style.display = 'none';
                    location.reload(); // Recharger la page pour afficher les modifications
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });

            </script>
@endpush
