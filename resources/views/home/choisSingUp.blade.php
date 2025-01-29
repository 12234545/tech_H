@extends('welcome')

@section('title', 'choix')

@section('content')

<div class="choix">
      <h1>Welcome</h1>
      <div class="choixList">
        <h2>What do you want to become ?</h2>
          <a href="{{ route('register')}}" class="">A User</a>
          <br>
          <a href="{{ route('admin.register') }}" class="">A responsible</a>
      </div>


</div>

@endsection
