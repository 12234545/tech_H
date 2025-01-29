
<div class="navbar">
    <nav>
         <img src=" {{asset('storage/images/logo1.png')}} " class="logo" >
         <div class="find">
            <i class='bx bx-search-alt'></i>
            <input type="text" placeholder="Rechercher..." autocomplete="off" id="search-input2" style="color: black">
        </div>
         <section class="nav-section">
           <ul>
            <li>
                @if(Auth::guard('admin')->check())
                    <a href="{{ route('admin.home') }}">Home</a>
                @else
                    <a href="{{ route('app_home') }}">Home</a>
                @endif
            </li>

            <li>
                @if(Auth::guard('admin')->check())
                    <a href="{{ route('admin.about') }}">About Us</a>
                @else
                    <a href="{{ route('app_about') }}">About Us</a>
                @endif
            </li>
               @auth
               @if(Auth::guard('admin')->check())
                   <li><a href="{{ route('admin.dashboard') }}" >Community</a></li>
                   <li><a href="{{ route('admin.mesthemes') }}" >Mythemes</a></li>
               @elseif(Auth::guard('web')->check())
                   <li><a href="{{ route('dashboard') }}" >Community</a></li>
               @endif
               @endauth
               @guest
               <li><a href="#" >Themes</a>
                  <div class="mega-box">
                      <div class="contentmaga">
                           <div class="row">
                                 <header><a href="{{ route('login')}}">AI</a></header>
                                 <img src="{{asset('storage/images/AI.png')}}" alt="">
                           </div>
                           <div class="row">
                                 <header><a href="{{ route('login')}}"> CYBER SECURITY</a></header>
                                 <img src="{{asset('storage/images/CYB.png')}} " alt="">
                           </div>
                           <div class="row">
                                <header><a href="{{ route('login')}}"> WEB DEVELOPMENT </a></header>
                                <img src="{{asset('storage/images/DEV.png')}}" alt="">
                          </div>
                          <div class="row">
                                <header><a href="{{ route('login')}}"> Outher </a></header>
                                <i class='bx bx-play'></i>
                          </div>
                      </div>
                   </div>
               </li>
               @endguest
          </ul>
       </section>
       <div>
          @guest
          <a href="{{ route('app_choix')}}" class="login-btn">Login</a>
          <a href="{{ route('app_choixSingUp')}}" class="btn">Sing Up</a>
          @endguest




            <div class="user-bar">

                @auth
                <div class="modern-notification-container">
                    <div class="modern-notification-trigger">
                        <i class="fas fa-bell" style="color: white"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="modern-notification-count">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </div>

                    <div class="modern-notification-panel">
                        <div class="modern-notification-header">
                            <span class="modern-notification-header-title">Notifications</span>
                            <button class="modern-notification-clear">Clear all</button>
                        </div>

                        <div class="modern-notification-list">
                            @forelse(auth()->user()->unreadNotifications as $notification)
    <div class="modern-notification-item">
        <div class="modern-notification-avatar">
            {{ substr($notification->data['user_name'], 0, 1) }}
        </div>
        <div class="modern-notification-content">
            <div class="modern-notification-text">
                <a href="{{ route('Article.showFromNotification',['article'=>$notification->data['article_id'] , 'notification'=>$notification->id]) }}">
                    {{--
                    @if(isset($notification->data['notification_type']) && $notification->data['notification_type'] === 'comment')
                        <p>{{ $notification->data['user_name'] }} posted a comment on your article <strong>{{ $notification->data['titreArticle'] }}</strong></p>
                    @elseif(isset($notification->data['notification_type']) && $notification->data['notification_type'] === 'reply')
                        <p>{{ $notification->data['user_name'] }} replied to your comment on the  article <strong>{{ $notification->data['titreArticle'] }}</strong></p>
                    @elseif(isset($notification->data['notification_type']) && $notification->data['notification_type'] === 'rating')
                        <p>{{ $notification->data['user_name'] }} rated your article <strong>{{ $notification->data['titreArticle'] }}</strong> {{ $notification->data['rating'] }} étoiles</p>
                    @elseif(isset($notification->data['notification_type']) && $notification->data['notification_type'] === 'recommendation')
                        <p>Recommended article for you  : <strong>{{ $notification->data['titreArticle'] }}</strong></p>
                    @else
                        <p>New notification</p>
                    @endif
                   --}}
                   @if(isset($notification->data['notification_type']))
                        @switch($notification->data['notification_type'])
                            @case('comment')
                                <p>{{ $notification->data['user_name'] }} posted a comment on your article <strong>{{ $notification->data['titreArticle'] }}</strong></p>
                                @break
                            @case('reply')
                                <p>{{ $notification->data['user_name'] }} replied to your comment on the article <strong>{{ $notification->data['titreArticle'] }}</strong></p>
                                @break
                            @case('rating')
                                <p>{{ $notification->data['user_name'] }} rated your article <strong>{{ $notification->data['titreArticle'] }}</strong> {{ $notification->data['rating'] }} étoiles</p>
                                @break
                            @case('theme_subscription')
                                <p>{{ $notification->data['user_name'] }} s'est abonné à votre thème <strong>{{ $notification->data['theme_name'] }}</strong></p>
                                @break
                            @case('new_theme_article')
                                <p>{{ $notification->data['user_name'] }} a publié un article dans votre thème <strong>{{ $notification->data['theme_name'] }}</strong> : {{ $notification->data['article_title'] }}</p>
                                @break
                            @default
                                <p>New notification</p>
                        @endswitch
                    @else
                        <p>New notification</p>
                    @endif
                </a>
            </div>
            <div class="modern-notification-time">
                {{ $notification->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
@empty
    <div class="modern-notification-empty">
        <p>No new notifications</p>
    </div>
@endforelse
                        </div>
                    </div>
                </div>




                @if (Auth::guard('admin')->check())
                   <p style="color: white; font-size: 15px; padding: 10px">
                {{ Auth::guard('admin')->user()->firstname }} {{ Auth::guard('admin')->user()->lastname }}</p>

              @else
                   <p style="color: white; font-size: 15px; padding: 10px">{{ Auth::user()->name }}</p>
              @endif
                <div class="profile-dropdown" >
                     <div class="profile-img">
                        <i class='bx bxs-user-circle' style="color: rgb(242, 237, 237) ; font-size: 60px"></i>
                     </div>
                     <div class="dropdown-content">
                        <a href="{{ route('profile.show') }}"><i class='bx bxs-user' style="font-size: 20px"></i> My profil</a>
                         @if(Auth::guard('admin')->check())
                         <a href="{{ route('admin.logout')}}" class="logO"><i class='bx bx-log-out' style="font-size: 20px"></i>Log Out</a>
                         @else
                         <a href="{{ route('app_logOut')}}" class="logO"><i class='bx bx-log-out' style="font-size: 20px"></i>Log Out</a>
                         @endif
                         <a href="{{ route('saved.articles')}}" class="logO"><i class='bx bx-bookmark'style="font-size: 20px" ></i>Save</a>
                         <a href="{{ route('article.history')}}"><i class='bx bx-history' style="  font-size: 20px"></i>History</a>
                     </div>
              </div>
           </div>
          @endauth

        </div>
  </nav>
</div>

