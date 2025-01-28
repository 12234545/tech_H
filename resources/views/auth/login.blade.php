@extends('welcome')

@section('title', 'login')

@section('content')
<div class="container3">
<div class="login">
    <form action="{{ route('login') }}" method="POST" class="form">
        @csrf
      <h1>Login</h1>
      <div class="input-box">
        <input type="text" placeholder="Username" required  name="email" id="email" value="{{ old('email') }}" autocomplete="email" autofocus>
        <i class='bx bxs-user'></i>
      </div>

      <div class="input-box">
        <input type="password" placeholder="Password" required name="password" id="password" autocomplete="current-password" autofocus>
        <i class='bx bxs-lock-alt'></i>
      </div>

      <button type="submit" class="btn">Login</button>

      <div class="register-link">
        <p>Don't have an account? <a href="{{ route('register')}}">Register here</a></p>
      </div>
    </form>

</div>
</div>

@endsection
