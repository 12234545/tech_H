@extends('welcome')

@section('title', 'choix')

@section('content')

<div class="choix">
      <h1>Welcome</h1>
      <div class="choixList">
        <h2>How are you ?</h2>
          <a href="{{ route('login')}}" class="">I am a user</a>
          <br>
          <a href="{{ route('admin.login') }}" class="">I am an responsible</a>
      </div>


</div>

@endsection
