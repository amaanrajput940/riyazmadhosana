<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

<div class="card shadow border-0" style="width:380px; border-radius:20px;">
<div class="card-body p-4">

<div class="text-center mb-4">
<img src="{{ asset('assets/img/mntglam.png') }}" width="120">
<p class="mt-3">Signin to start your online shooping</hp>
</div>

<x-auth-session-status class="mb-3" :status="session('status')" />

<form method="POST" action="{{ route('login') }}">
@csrf

<div class="mb-3">
<label>Email</label>
<input type="email" name="email"
class="form-control rounded-pill"
value="{{ old('email') }}" required autofocus>
<x-input-error :messages="$errors->get('email')" class="mt-1" />
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password"
class="form-control rounded-pill" required>
<x-input-error :messages="$errors->get('password')" class="mt-1" />
</div>

<div class="d-flex justify-content-between small mb-3">

<div>
<input type="checkbox" name="remember">
Remember me
</div>

@if(Route::has('password.request'))
<a href="{{ route('password.request') }}" class="text-decoration-none">
Forgot password?
</a>
@endif

</div>

<button class="btn btn-dark w-100 rounded-pill">
Login
</button>

</form>

</div>
</div>

</div>

</body>
</html>
