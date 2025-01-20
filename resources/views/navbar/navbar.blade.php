
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
               <li><a href="#" >Themes</a>
                  <div class="mega-box">
                      <div class="contentmaga">
                           <div class="row">
                                 <header><a>AI</a></header>
                                 <img src="{{asset('storage/images/AI.png')}}" alt="">
                           </div>
                           <div class="row">
                                 <header><a> CYBER SECURITY</a></header>
                                 <img src="{{asset('storage/images/CYB.png')}} " alt="">
                           </div>
                           <div class="row">
                                <header><a> WEB DEVELOPMENT </a></header>
                                <img src="{{asset('storage/images/CYB.png')}}" alt="">
                          </div>
                          <div class="row">
                                <header><a> OTHERS </a></header>
                                <i class='bx bx-play'></i>
                          </div>
                      </div>
                   </div>
               </li>
          </ul>
       </section>
       <div>
          @guest
          <a href="{{ route('login')}}" class="login-btn">log in</a>
          <a href="{{ route('register')}}" class="btn">Sign up</a>
          @endguest

          @auth
          <div class="user-bar">

                <a href="{{ route('app_history')}}"><i class='bx bx-history' style="color: white ; font-size: 40px"></i></a>
                <p style="color: white; font-size: 20px; padding: 10px">{{ Auth::user()->name }}</p>
                <i class='bx bxs-user-circle' style="color: white ; font-size: 40px"></i>
                <a href="{{ route('app_logOut')}}" class="logO"><i class='bx bx-log-out' style="color: white"></i>Log Out</a>
          @endauth

       </div>
  </nav>
</div>
