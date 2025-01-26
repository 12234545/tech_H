
<div class="navbar">
    <nav>
         <img src=" {{asset('storage/images/logo1.png')}} " class="logo" >
         <div class="find">
             <input type="text" placeholder="Search..." ><a href="#"><i class='bx bx-search-alt'></i></a>
         </div>
         <section class="nav-section">
           <ul>
               <li><a  href="{{ route('app_home') }}" >Home</a></li>
               <li><a  href="{{ route('app_about') }}" >About Us</a></li>
               @auth
               <li><a  href="{{ route('dashboard') }}" >Community</a></li>
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
                                <header><a href="{{ route('login')}}"> OTHERS </a></header>
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
          <a href="{{ route('login')}}" class="login-btn">log in</a>
          <a href="{{ route('register')}}" class="btn">Sign up</a>
          @endguest




            <div class="user-bar">

                @auth
                {{--
                <div class="profile-dropdown" >
                <i class="fas fa-bell  notification-icon"></i>
                <span  class=".notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>

                @unless(auth()->user()->unreadNotifications->isEmpty())


                 <div class="dropdown-content">
                     @foreach(auth()->user()->unreadNotifications as $notification)
                             <a href="{{ route('Article.showFromNotification',['article'=>$notification->data['article_id'] , 'notification'=>$notification->id]) }}">
                             <p>{{ $notification->data['user_name'] }} posté un commentaire sur votre article  <strong> {{ $notification->data['titreArticle'] }}</strong></p>
                             <small class="notification-time">{{ $notification->created_at->diffForHumans() }}</small>
                             </a>
                     @endforeach

                 </div>
               </div>
                @endunless
                --}}
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
                            <button class="modern-notification-clear">Clear All</button>
                        </div>

                        <div class="modern-notification-list">
                            {{--
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <div class="modern-notification-item">
                                    <div class="modern-notification-avatar">
                                        {{ substr($notification->data['user_name'], 0, 1) }}
                                    </div>
                                    <div class="modern-notification-content">
                                        <div class="modern-notification-text">
                                            <a href="{{ route('Article.showFromNotification',['article'=>$notification->data['article_id'] , 'notification'=>$notification->id]) }}">
                                                <p>{{ $notification->data['user_name'] }} posté un commentaire sur votre article  <strong> {{ $notification->data['titreArticle'] }}</strong></p>
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
                            --}}
                            @forelse(auth()->user()->unreadNotifications as $notification)
    <div class="modern-notification-item">
        <div class="modern-notification-avatar">
            {{ substr($notification->data['user_name'], 0, 1) }}
        </div>
        <div class="modern-notification-content">
            <div class="modern-notification-text">
                <a href="{{ route('Article.showFromNotification',['article'=>$notification->data['article_id'] , 'notification'=>$notification->id]) }}">
                    @if(isset($notification->data['notification_type']) && $notification->data['notification_type'] === 'comment')
                        <p>{{ $notification->data['user_name'] }} a posté un commentaire sur votre article <strong>{{ $notification->data['titreArticle'] }}</strong></p>
                    @elseif(isset($notification->data['notification_type']) && $notification->data['notification_type'] === 'reply')
                        <p>{{ $notification->data['user_name'] }} a répondu à votre commentaire sur l'article <strong>{{ $notification->data['titreArticle'] }}</strong></p>
                    @elseif(isset($notification->data['notification_type']) && $notification->data['notification_type'] === 'rating')
                        <p>{{ $notification->data['user_name'] }} a noté votre article <strong>{{ $notification->data['titreArticle'] }}</strong> {{ $notification->data['rating'] }} étoiles</p>
                    @else
                        <p>Nouvelle notification</p>
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
        <p>Pas de nouvelles notifications</p>
    </div>
@endforelse
                        </div>
                    </div>
                </div>



                <p style="color: white; font-size: 20px; padding: 10px">{{ Auth::user()->name }}</p>
                <div class="profile-dropdown" >
                     <div class="profile-img">
                        <i class='bx bxs-user-circle' style="color: rgb(242, 237, 237) ; font-size: 60px"></i>
                     </div>
                     <div class="dropdown-content">
                         <a href="#"><i class='bx bxs-user' style="font-size: 20px"></i> mon profil</a>
                         <a href="{{ route('app_logOut')}}" class="logO"><i class='bx bx-log-out' style="font-size: 20px"></i>Log Out</a>
                         <a href="{{ route('saved.articles')}}" class="logO"><i class='bx bx-bookmark'style="font-size: 20px" ></i>Save</a>
                         <a href="{{ route('app_history')}}"><i class='bx bx-history' style="  font-size: 20px"></i>History</a>
                     </div>
              </div>
           </div>
          @endauth


        </div>
  </nav>
</div>

