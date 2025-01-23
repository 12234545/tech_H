<!--
{{--@extends('welcome')

@section('title', 'dashboard')

@section('content')--}}
<div class="container5">
<div class="main-container">
    <div></div>
     <aside class="navigation">
         <ul>
             <li>
                 <a href="#">
                     <span class="icon"><ion-icon name="ellipsis-horizontal-outline"></ion-icon></span>
                     <span class="title">Thèmes</span>
                 </a>
             </li>

             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="logo-electron"></ion-icon>
                     </span>
                     <span class="title">DEVELOPPMENT DIGITAL</span>
                 </a>
             </li>

             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="logo-octocat"></ion-icon>
                     </span>
                     <span class="title">Ai</span>
                 </a>
             </li>

             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="shield-checkmark-outline"></ion-icon>
                     </span>
                     <span class="title">CYBERSECURITY</span>
                 </a>
             </li>

             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="game-controller-outline"></ion-icon>
                     </span>
                     <span class="title">Jeux Video</span>
                 </a>
             </li>

             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="planet-outline"></ion-icon>
                     </span>
                     <span class="title">science technology</span>
                 </a>
             </li>

             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="server-outline"></ion-icon>
                     </span>
                     <span class="title">Base De Donnees</span>
                 </a>
             </li>
             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="pie-chart-outline"></ion-icon>
                     </span>
                     <span class="title">Oracle</span>
                 </a>
             </li>
             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="laptop-outline"></ion-icon>
                     </span>
                     <span class="title">La Programmation</span>
                 </a>
             </li>
             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="analytics-outline"></ion-icon>
                     </span>
                     <span class="title">Les Nouveautes</span>
                 </a>
             </li>
             <li>
                 <a href="#">
                     <span class="icon">
                         <ion-icon name="heart-half-outline"></ion-icon>
                     </span>
                     <span class="title">Soft Skills</span>
                 </a>
             </li>
         </ul>
     </aside>
             <div class="toggle">
                 <ion-icon name="swap-horizontal-outline"></ion-icon>
             </div>

     <main class="content10">
                 <div class="post" data-post-id="1">
                     <div class="post-header">
                         <div class="post-avatar"></div>
                         <div class="post-meta">
                             <strong>Jean Dupont</strong>
                             <div>Il y a 2 heures</div>
                         </div>
                     </div>
                     <div>
                       {{-- <img src="{{asset('storage/images/img1.jpg')}}" alt="img poste">-}}
                     </div>
                     <p style="color: black">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>


                     <div class="post-options">

                         <div class="rating">
                             <span class="stars">
                                 <i class="fas fa-star" data-value="1"></i>
                                 <i class="fas fa-star" data-value="2"></i>
                                 <i class="fas fa-star" data-value="3"></i>
                                 <i class="fas fa-star" data-value="4"></i>
                                 <i class="fas fa-star" data-value="5"></i>
                             </span>
                         </div>


                       <div class="comment-section">
                         <button class="publish-comment">

                         </button>
                         <div class="comments">
                             <div class="comment-list"></div>
                         </div>
                     </div>



                         <div class="save-post">
                            <button class="partage-button"><ion-icon name="paper-plane-outline"></ion-icon></button>
                             <button class="save-button"><i class="fas fa-bookmark"></i> Enregistrer</button>
                         </div>
                     </div>



                        <div class="popup">

                       <div class="header-partage">
                           <span class="title-share">partager</span>
                           <div class="close"> <ion-icon name="close-outline"></ion-icon></div>
                       </div>




                       <div class="content-share" >
                           <p class="p1">partager le lien:</p>
                           <ul class="icons-share">
                               <a class="a1" href="#"><i  class="fab fa-facebook-f"></i></a>
                               <a class="a1" href="#"><i class="fab fa-twitter"></i></a>
                               <a class="a1" href="#"><i class="fab fa-instagram"></i></a>
                               <a class="a1" href="#"><i class="fab fa-whatsapp"></i></a>
                               <a class="a1" href="#"><i class="fab fa-telegram-plane"></i></a>
                           </ul>
                           <p>copier le lien</p>
                           <div class="field">
                               <ion-icon class="i" name="attach-outline"></ion-icon>
                               <input class="input1" type="text" value="exemple.com/share-links">
                               <button class="copier">copier</button>
                           </div>
                       </div>
                   </div>


                 </div>



     </main>

 </div>

 <a href="#" class="back-to-top">
     <i class="fas fa-arrow-up"></i>
 </a>
</div>

@endsection--}}
-->

@extends('welcome')

@section('title', 'dashboard')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    // Passer les données de l'utilisateur au JavaScript
    window.userName = "{{ Auth::user()->name }}";
</script>
<div class="container5">
    <div class="main-container">
        <aside class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon"><ion-icon name="ellipsis-horizontal-outline"></ion-icon></span>
                        <span class="title">Thèmes</span>
                    </a>
                </li>
                @foreach($themes as $theme)
                <li>
                    <a href="#" data-theme-id="{{ $theme->id }}">
                        <span class="icon"><ion-icon name="{{ $theme->icon }}"></ion-icon></span>
                        <span class="title">{{ $theme->name }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </aside>
        <div class="toggle">
            <ion-icon name="swap-horizontal-outline"></ion-icon>
        </div>

        <div id="articleModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal()">&times;</span>
                <h2 style="color: blanchedalmond;font-size: 30px">Ajouter un nouvel article</h2>
                <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group ">
                        <label for="title">Titre</label>
                        <input type="text" id="title" name="title" required style="color: blacks">
                    </div>
                    <div class="form-group">
                        <label for="content">Contenu</label>
                        <textarea id="content" name="content" rows="6" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="theme_id">Thème</label>
                        <select id="theme_id" name="theme_id" required>
                            @foreach($themes as $theme)
                                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" id="image" name="image" required accept="image/*">
                    </div>
                    <button type="submit" class="submit-btn ">Publier</button>
                </form>
            </div>
        </div>

            <!-- Liste des articles -->
            {{--
            @foreach($articles as $article)
            <div class="post" data-post-id="{{ $article->id }}">
                <div class="post-header">
                    <div class="post-avatar">
                        <img src="{{$article->creator->profile_photo }}" alt="">
                    </div>
                    <div class="post-meta">
                        <strong>{{ $article->creator->name }}</strong>
                        <div>{{ $article->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <div>
                    <img src="{{ $article->image }}" alt="{{ $article->title }}">
                </div>
                <h3>{{ $article->title }}</h3>
                <p style="color: black">{{ $article->content }}</p>

                <div class="post-options">
                    <div class="rating">
                        <span class="stars" data-article-id="{{ $article->id }}">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $article->stars_count ? 'active' : '' }}" data-value="{{ $i }}"></i>
                            @endfor
                        </span>
                    </div>
                    <div class="save-post">
                        <button class="partage-button" data-share-link="{{ $article->share_link }}">
                            <ion-icon name="paper-plane-outline"></ion-icon>
                        </button>
                        <button class="save-button">
                            <i class="fas fa-bookmark"></i> Enregistrer
                        </button>
                        <div class="comment-section">
                            <button class="publish-comment">

                            </button>
                            <div class="comments">
                                <div class="comment-list"></div>
                            </div>
                        </div>
                        <div class="popup">

                            <div class="header-partage">
                                <span class="title-share">partager</span>
                                <div class="close"> <ion-icon name="close-outline"></ion-icon></div>
                            </div>
                    </div>

                  <!-- #region partage -->

                </div>

            </div>

            @endforeach
            --}}
            <div class="listhhhh">
            @foreach($articles as $article)
                     <div class="post">
                         <div class="post-header">
                             <div class="post-avatar">
                                <img src="{{ $article->creator->profile_photo_url ?? asset('default-avatar.png') }}" alt="Profile">
                             </div>
                              <div class="post-meta">
                                    <strong>{{ $article->creator->name }}</strong>
                                    <div>{{ $article->created_at->diffForHumans() }}</div>
                               </div>
                         </div>

                          <img src="{{ $article->image }}" alt="{{ $article->title }}">
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


                           <div class="post-actions" >
                                 <button class="comment-button" onclick="toggleCommentSection({{ $article->id }})">
                                       <ion-icon class="icon-comments" name="chatbox-ellipses-outline"></ion-icon>
                                  </button>

                                  <button class="partage-button" onclick="sharePost({{ $article->id }})">
                                        <ion-icon name="paper-plane-outline"></ion-icon>
                                  </button>

                                  <button class="save-button" onclick="savePost({{ $article->id }})">
                                       <i class="fas fa-bookmark"></i>
                                  </button>
                            </div>
                     </div>
                     <div class="comment-section" id="comment-section-{{ $article->id }}" style="display: none;">
                     <div class="comment-input-area">
                          <textarea class="comment-textarea" placeholder="Écrivez votre commentaire..."></textarea>
                          <div class="comment-actions">
                          <button class="submit-comment" onclick="submitComment({{ $article->id }})">
                               <ion-icon name="checkmark-done-outline"></ion-icon>
                          </button>
                          <button class="cancel-comment" onclick="cancelComment({{ $article->id }})">
                                <ion-icon name="close-circle-outline"></ion-icon>
                          </button>
                      </div>
                 </div>
                  <div class="comment-list" id="comment-list-{{ $article->id }}"></div>
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

@endsection
