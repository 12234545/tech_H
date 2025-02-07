
@extends('welcome')

@section('title', 'dashboard')

@section('content')

<div class="container5">
    <div class="main-container">

        <aside class="navigation">
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <span class="icon"><ion-icon name="ellipsis-horizontal-outline"></ion-icon></span>
                        <span class="title">ALL Themes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.dashboard', ['nouveautes' => true]) }}">
                        <span class="icon"><ion-icon name="analytics-outline"></ion-icon></span>
                        <span class="title">News</span>
                    </a>
                </li>
                @foreach($themes as $theme)
                <li>
                    <a href="{{ route('admin.dashboard', ['theme_id' => $theme->id]) }}">
                        <span class="icon"><ion-icon name="{{ $theme->icon }}"></ion-icon></span>
                        <span class="title">{{ $theme->name }}</span>
                    </a>
                    @if($theme->responsible !== Auth::guard('admin')->user()->firstname . ' ' . Auth::guard('admin')->user()->lastname)
        <form method="POST" action="{{ route('admin.themes.subscribe', $theme->id) }}" style="display: inline;">
            @csrf
            <button type="submit" class="subscribe-btn {{ Auth::guard('admin')->user()->subscribedThemes->contains($theme->id) ? 'subscribed' : '' }}" onclick="return showNotification('Action réussie')">
                {{ Auth::guard('admin')->user()->subscribedThemes->contains($theme->id) ? '✓' : '+' }}
            </button>
        </form>
          @endif
                </li>
                @endforeach

            </ul>
        </aside>
        {{----}}
        <div class="toggle">
            <ion-icon name="swap-horizontal-outline"></ion-icon>
        </div>

        <div id="articleModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal()">&times;</span>
                <h2 style="color: blanchedalmond;font-size: 30px">Add a new article</h2>
                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" required style="color: rgb(253, 249, 249)">
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea id="content" name="content" rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="theme_id">Theme</label>
                        <select id="theme_id" name="theme_id" required>
                            @foreach($themes as $theme)
                                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Picture</label>
                        <input type="file" id="image" name="image" required accept="image/*">
                    </div>
                    <button type="submit" class="submit-btn">Publish</button>
                </form>
            </div>
        </div>
            <div class="listhhhh">
             @foreach($articles as $article)
                     <div class="post">
                        <div class="post-header">
                            <div class="post-avatar">
                                <div class="modern-notification-avatar">
                                    {{ substr($article->creator->name, 0, 1) }}
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

                          <div class="rating">
                             <span class="stars">
                                   <i class="fas fa-star" data-value="1"></i>
                                   <i class="fas fa-star" data-value="2"></i>
                                   <i class="fas fa-star" data-value="3"></i>
                                   <i class="fas fa-star" data-value="4"></i>
                                   <i class="fas fa-star" data-value="5"></i>
                              </span>
                              <br>
                              <button type="button" onclick="togglepagecomment()" id="comment_page_chacher">Comments<i class='bx bxs-chevron-down' style="scale: 1.8 ;margin-left: 5px"></i></button>
                        <div class="comment_page " id="comment_page" >
                           <div>
                            @forelse($article->comments as $comment)
                              <div class="comment" id="comment_reply-{{$comment->id}}" >
                                @php
                                $admin = \App\Models\Admin::find($comment->user_id);
                                $adminName = $admin ? $admin->firstname . ' ' . $admin->lastname : 'Admin';
                            @endphp
                            {{ $adminName }}
                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                                  <p>{{ $comment->content }}</p>
                                  @if(Auth::id() == $comment->user_id)
                                  <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-comment" onclick="return showNotification('supprimer avec succès')">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                                @endif
                              </div>
                              @foreach ($comment->comments as $reply)
                              <div class="comment_reply" id="comment_reply-{{$reply->id}}">
                                @php
                                $admin = \App\Models\Admin::find($reply->user_id);
                                $adminName = $admin ? $admin->firstname . ' ' . $admin->lastname : 'Admin';
                            @endphp
                            {{ $adminName }}
                                <span>{{ $reply->created_at->diffForHumans() }}</span>
                                <p>{{ $reply->content }}</p>
                                @if(Auth::id() == $reply->user_id)
                                <form action="{{ route('admin.comments.destroy', $reply) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-comment" onclick="return showNotification('supprimer avec succès')">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                                @endif
                              </div>
                              @endforeach
                             <button id="commentReplyId" class="comment-reply" onclick="toggleReplyComment({{ $comment->id }})"><i class="fas fa-reply"></i> </button>
                             <form action="{{ route('admin.comments.storeReply', $comment) }}" method="POST" id="replyComment-{{$comment->id}}" class="hidden">
                                 @csrf
                                 <div class="form-replay">
                                        <input type="text" name="contentreply" id="contentreply" placeholder="Écrivez votre réponse..." style="color: black" @error('contentreply')
                                           is-invalid
                                        @enderror>
                                        <button type="submit" class="submit-comment">
                                            <ion-icon name="checkmark-done-outline"></ion-icon>
                                        </button>
                                 </div>
                             </form>

                            @empty
                                <hr style="color: rgb(188, 185, 185)">
                                <br>
                                <p>Aucun commentaire</p>
                            @endforelse
                           </div>
                        </div>
                           <div class="post-actions" >
                              <div class="comment_partie">
                                    <form action="{{ route('admin.comments.store', $article) }}" method="POST">
                                     @csrf
                                     <div class="comment-section">
                                        <div class="comment-input-area">
                                            <textarea type="text" name="content" class="comment-textarea" placeholder="Écrivez votre commentaire..."  style="color: black"></textarea>
                                            <div class="comment-actions">
                                                <button type="submit" class="submit-comment">
                                                    <ion-icon name="checkmark-done-outline"></ion-icon>
                                                </button>
                                          </div>
                                       </div>
                                     </div>
                                 </form>
                              </div>
                               <div class="save_share_partie">
                                  <button class="partage-button" onclick="sharePost({{ $article->id }})">
                                        <ion-icon name="paper-plane-outline"></ion-icon>
                                  </button>

                                  <form action="{{ route('articles.save') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                    <button type="submit" class="save-button" onclick="return showNotification('Enregistrer avec succès')" >
                                        <i class="fas fa-bookmark"></i>
                                    </button>
                                </form>
                               </div>
                            </div>



             </div>
         </div>

      @endforeach
            {{ $articles->links() }}
</main>
    </div>
    <div class="float-button" onclick="openModal()">+</div>
    <div class="admin-float-button" onclick= "openThemeModal()">+</div>
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var highlightedElement = document.querySelector('.highlighted');
        if (highlightedElement) {
            highlightedElement.classList.remove('highlighted');
        }

        @if(isset($highlightCommentId))
            var commentElement = document.getElementById('comment_reply-{{ $highlightCommentId }}');
            if (commentElement) {
                commentElement.scrollIntoView({ behavior: 'smooth' });
                commentElement.classList.add('highlighted');
            }
        @endif
    });
</script>

<style>
    .highlighted {
        background-color: rgb(239, 239, 199);
        transition: background-color 1s ease;
    }
</style>

<div id="themeModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeThemeModal()">&times;</span>
        <h2 style="color: blanchedalmond;font-size: 30px">Ajouter un nouveau thème</h2>
        <form action="{{ route('themes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="theme_name">Nom du thème</label>
                <input type="text" id="theme_name" name="name" required style="color: rgb(241, 240, 240)">
            </div>
            <div class="form-group">
                <label for="theme_icon">Nom de l'icône</label>
                <P style="color: rgb(244, 237, 227)">You can find the name of the icon in  <a href="https://ionicons.com/" target="_blank">ionicons.com</a></P>
                <input type="text" id="theme_icon" name="icon" required style="color: rgb(240, 232, 232)">
            </div>
            <button type="submit" class="submit-btn">Ajouter</button>
        </form>
    </div>
</div>
<script>
    function openThemeModal() {
        document.getElementById('themeModal').style.display = 'block';
    }

    function closeThemeModal() {
        document.getElementById('themeModal').style.display = 'none';
    }

    document.querySelector('.admin-float-button').addEventListener('click', openThemeModal);
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.subscribe-btn').forEach(button => {
        button.addEventListener('click', function() {
            const themeId = this.getAttribute('data-theme-id');

            fetch(`/admin/themes/${themeId}/admin-subscribe`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Action réussie !');
                    // Mettre à jour l'interface utilisateur
                    this.classList.toggle('subscribed');
                    this.textContent = this.classList.contains('subscribed') ? '✓' : '+';
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});


    </script>
@endsection
