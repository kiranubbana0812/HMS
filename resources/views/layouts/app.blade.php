<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Hospital Management</title>
    <!-- Meta and other tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-base-url" content="{{ config('services.api.base_url') ?? url('/') }}">
<<<<<<< HEAD
    <meta name="logout-route" content="{{ url('/logout') }}">
    <meta name="user-role" content="{{ session('role') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" />
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <style>
        #sidebar {
            height: 100vh;
            overflow-y: auto;
            position: fixed;
            scroll-behavior: smooth;
        }

        /* Optional: hide scrollbar for cleaner look */
        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(0,0,0,0.3);
            border-radius: 3px;
        }

    </style>
=======
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="logout-route" content="{{ url('/logout') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" />
    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
>>>>>>> 6b8595dc1c62273c0bff306bbd6788244a439795
    @stack('styles')
</head>
<body>
    {{-- ✅ Conditionally show sidebar if not on login route --}}
    @if (!request()->is('login'))
        @include('header')
    @endif
    <div class="container-fluid">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @if (!request()->is('login'))
    <script src="{{ asset('js/sidebarscript.js') }}"></script>
    <script src="{{ asset('js/logout.js') }}"></script>
    @endif
    <script>
        //const SESSION_ROUTE = "{{ route('session.store') }}";
        //const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
    <!-- Scripts pushed from child views (like login) will show up here -->
    @stack('scripts')
</body>
</html>
