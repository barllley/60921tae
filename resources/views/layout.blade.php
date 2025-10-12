<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Satura - искусство, которое говорит с тобой')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎫</text></svg>">
</head>
<body>

        <!-- блок отладки
    <div style="position: fixed; top: 10px; right: 10px; background: #333; color: white; padding: 10px; z-index: 9999; border-radius: 5px; font-size: 12px;">
        <strong>Отладка Auth:</strong><br>
        Auth::check(): {{ Auth::check() ? 'TRUE' : 'FALSE' }}<br>
        User: {{ Auth::user() ? Auth::user()->name : 'NULL' }}<br>
        User ID: {{ Auth::id() ?? 'NULL' }}<br>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #ff6b6b;">Выйти</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div> -->

    @include('partials.messages')

    <main class="container mt-4">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
