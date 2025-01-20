@extends('welcome')

@section('title', 'dashboard')

@section('content')
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
                         <img src="{{asset('storage/images/img1.jpg')}}" alt="img poste">
                     </div>
                     <p style="color: black">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                     <!-- Options sous le post -->
                     <div class="post-options">
                         <!-- Noter le post -->
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
                     <!-- Section des commentaires -->

                 </div>



     </main>

 </div>

 <a href="#" class="back-to-top">
     <i class="fas fa-arrow-up"></i>
 </a>
</div>

@endsection
