@extends('welcome')

@section('title', 'Home')

@section('content')
<div class="hero">
<div class="content">
    <h1 class="anim">Dive Into   The World Of Technology</h1>


 </div>
 <img src="{{asset('storage/images/a1 (1).png')}}" class="feature-img anim">
 <div class="video-container">
    <video autoplay muted loop id="background-video">
          <source src="{{asset('storage/images/a4.mov')}}" type="video/mp4">
    </video>
  </div>
  <a  class="btn anim" style="padding: 20px 80px 20px 80px ; font-size: 20px;" href="{{ route('register')}}">Join Now</a>
</div>

<div class="container1" >
  <div class="text">
      <h2 >Explore Our Items </h2>

   </div>
<div class="container2 swiper">
 <div class="card-wrapper">
     <ul class="card-list swiper-wrapper">
         <li class="card-item swiper-slide">
            <a href="#" class="card-link">
                  <img src="{{asset('storage/images/ai2.jpg')}}" class="card-image" alt="card image">
                  <p class="badge ai">AI</p>
                  <h2 class="card-title">Révolutionner le quotidien et l’avenir</h2>
                  <button class="card-btn">Read More</button>
            </a>
         </li>
         <li class="card-item swiper-slide">
          <a href="#" class="card-link">
                <img src="{{asset('storage/images/cy2.jpg')}}" class="card-image" alt="card image">
                <p class="badge cyb">Cyber Security</p>
                <h2 class="card-title">Protéger nos données dans un monde connecté</h2>
                <button class="card-btn">Read More </button>
          </a>
        </li>
         <li class="card-item swiper-slide">
          <a href="#" class="card-link">
                <img src="{{asset('storage/images/dev2.jpeg')}}" class="card-image" alt="card image">
                <p class="badge dev">Web Development</p>
                <h2 class="card-title">Toward a Faster and More Interactive Web</h2>

                <button class="card-btn" >Read More</button>
          </a>
         </li>
         <li class="card-item swiper-slide">
          <a href="#" class="card-link">
                <img src="{{asset('storage/images/game.jpg')}}" class="card-image" alt="card image">
                <p class="badge game">Game</p>
                <h2 class="card-title">The World of Video Games: Innovation and Total Immersion</h2>
                <button class="card-btn" >Read More</button>
          </a>
         </li>
    </ul>

    <div class="swiper-pagination"></div>
    <div class="swiper-slide-button swiper-button-prev"></div>
    <div class="swiper-slide-button swiper-button-next"></div>
 </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    new Swiper('.card-wrapper', {
    loop: true,
    spaceBetween: 30,
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true
    },

    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    // And if we need scrollbar
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        }
    }
  });
</script>


@endsection
