
@extends('welcome')

@section('title', 'dashboard')

@section('content')

<div class="container5">
    <div class="main-container">
        <aside class="navigation">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <span class="icon"><ion-icon name="ellipsis-horizontal-outline"></ion-icon></span>
                        <span class="title">All Themes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard', ['abonnes' => true]) }}">
                        <span class="icon"><ion-icon name="analytics-outline"></ion-icon></span>
                        <span class="title">News </span>
                    </a>
                </li>
                @foreach($themes as $theme)
                <li>
                    <a href="{{ route('dashboard', ['theme_id' => $theme->id]) }}">
                        <span class="icon"><ion-icon name="{{ $theme->icon }}"></ion-icon></span>
                        <span class="title">{{ $theme->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('themes.subscribe', $theme->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit"  class="subscribe-btn {{ Auth::user()->subscribedThemes->contains($theme->id) ? 'subscribed' : '' }}" onclick="return showNotification('Subscription successfully')">
                            {{ Auth::user()->subscribedThemes->contains($theme->id) ? '✓' : '+' }}
                        </button>
                    </form>
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
                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group ">
                        <label for="title">Title </label>
                        <input type="text" id="title" name="title" required style="color: blacks">
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
                    <button type="submit" class="submit-btn " onclick="return showNotification('Article added successfully')">Publish</button>
                </form>
            </div>
        </div>
            <div class="listhhhh">
             @foreach($articles as $article)
                     <div class="post"  data-article-id="{{ $article->id }}">
                         <div class="post-header">
                             <div class="post-avatar" data-initial="{{ substr(Auth::user()->name, 0, 1) }}">
                                <div class="modern-notification-avatar">
                                    {{ substr($article->creator->name, 0, 1) }}
                                </div>
                            </div>
                              <div class="post-meta">
                                    <strong>{{ $article->creator->name }}</strong>
                                    <div>{{ $article->created_at->diffForHumans() }}</div>
                               </div>
                         </div>

                          <img id="imageARTICLE" src="{{ $article->image }}" alt="{{ $article->title }}">
                          <h3>{{ $article->title }}</h3>
                          <p>{{ $article->content }}</p>

                          <div class="rating">
                            <form action="{{ route('articles.rate', $article) }}" method="POST" class="rating-form">
                                @csrf
                                <span class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button type="submit" name="rating" value="{{ $i }}" class="star-btn">
                                            <i class="fas fa-star" data-value="{{ $i }}"></i>
                                        </button>
                                    @endfor
                                </span>
                            </form>
                              <br>
                              <button type="button" onclick="togglepagecomment()" id="comment_page_chacher">Comments<i class='bx bxs-chevron-down' style="scale: 1.8 ;margin-left: 5px"></i></button>
                        <div class="comment_page " id="comment_page" >
                           <div>
                            @forelse($article->comments as $comment)
                              <div class="comment" id="comment_reply-{{$comment->id}}" >
                                  <strong>{{ $comment->user->name }}</strong> <span>   {{ $comment->created_at->diffForHumans() }}</span>
                                  <p>{{ $comment->content }}</p>
                                  @if(Auth::id() == $comment->user_id)
                                  <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-comment" onclick="return showNotification('Delete successfully')">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                                @endif
                              </div>
                              @foreach ($comment->comments as $reply)
                              <div class="comment_reply" id="comment_reply-{{$reply->id}}">
                                <strong>{{ $reply->user->name }}</strong><span>{{ $reply->created_at->diffForHumans() }}</span>
                                <p>{{ $reply->content }}</p>
                                @if(Auth::id() == $reply->user_id)
                                <form action="{{ route('comments.destroy', $reply) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-comment" onclick="return showNotification('Delete successfully')">
                                        <ion-icon name="trash-outline"></ion-icon>
                                    </button>
                                </form>
                                @endif
                              </div>
                              @endforeach
                             <button id="commentReplyId" class="comment-reply" onclick="toggleReplyComment({{ $comment->id }})"><i class="fas fa-reply"></i> </button>
                             <form   action="{{ route('comments.storeReply',$comment)}}" method="POST" id="replyComment-{{$comment->id}}" class="hidden">
                                 @csrf
                                 <div class="form-replay">
                                        <input type="text" name="contentreply" id="contentreply" placeholder="Write a reply..." style="color: black" @error('contentreply')
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
                                <p>No comments yet</p>
                            @endforelse
                           </div>
                        </div>
                           <div class="post-actions" >
                              <div class="comment_partie">
                                 <form action="{{ route('comments.store',$article)}}" method="POST">
                                     @csrf
                                     <div class="comment-section">
                                        <div class="comment-input-area">
                                            <textarea type="text" name="content" class="comment-textarea" placeholder="Write a comment..."  style="color: black"></textarea>
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
                                  <button class="partage-button" onclick="handleShare({{ $article->id }})">
                                        <ion-icon name="paper-plane-outline"></ion-icon>
                                  </button>
                                  <form action="{{ route('articles.save') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                    <button type="submit" class="save-button" onclick="return showNotification('Save successfully')" >
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.subscribe-btn').forEach(button => {
            button.addEventListener('click', function() {
                const themeId = this.getAttribute('data-theme-id');

                fetch(`/themes/${themeId}/subscribe`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Subscription successfully!');
                        // Vous pouvez également mettre à jour l'interface utilisateur ici si nécessaire
                    } else {
                        showNotification('Subscription failed!');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            });
        });
    });
</script>


@endsection
