@extends('layouts.app')
@push('styles')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endpush
@section('content')
    
    {{-- <form method="POST" action="{{ route('frontdesk.login.submit') }}">
        @csrf
        <label>Email:</label><br>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form> --}}
    <div class="wrapper">
        <div class="heading">
            <img src="images/1.png">
            <h1>Login Details</h1>
        </div>
        @if($errors->any())
            <div style="color:red;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form id="login-form">
            @csrf
            <div class="form-group">
                <label for="username" class="form-label">Email</label>
                <i class="fas fa-user set-icon"></i>
                <input type="text" id="username" name="email" placeholder="Enter your email" autocomplete="off" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <i class="fas fa-lock set-icon-password"></i>
                <input type="password" autocomplete="off" name="password" id="password" placeholder="Enter your password" required>
            </div>
            
            <div class="login-options">
                <div class="checkbox-group">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember me</label>
                </div>
            </div>
            <a href="#" class="forgot-password">Forgot Password?</a>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/login.js') }}"></script>
    <script>
        const API_BASE_URL = "{{ config('services.api.base_url') }}";
        const SESSION_ROUTE = "{{ route('session.store') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
    </script>
@endpush
