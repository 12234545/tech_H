@extends('welcome')

@section('title', 'choix')

@section('content')

<div class="choix">
      <h1>Welcome</h1>
      <div class="choixList">
        <h2>What do you want to become ?</h2>
          <a href="{{ route('register')}}" class="">Un utilisateur</a>
          <br>
          <a href="{{ route('admin.register') }}" class="">Un administrateur</a>
      </div>


</div>

@endsection
