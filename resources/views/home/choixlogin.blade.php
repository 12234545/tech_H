@extends('welcome')

@section('title', 'choix')

@section('content')

<div class="choix">
      <h1>Welcome</h1>
      <div class="choixList">
        <h2>How are you ?</h2>
          <a href="{{ route('login')}}" class="">Un utilisateur</a>
          <br>
          <a href="{{ route('login') }}" class="">Un administrateur</a>
      </div>


</div>

@endsection
