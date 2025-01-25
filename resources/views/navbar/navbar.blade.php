
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

          @auth

            <div class="user-bar">
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

