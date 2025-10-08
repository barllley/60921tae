<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Админ Панель</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Привет, {{ Auth::user()->name }}
                </span>
                <a href="{{ route('admin.users') }}" class="btn btn-outline-light btn-sm me-2">👥 Пользователи</a>
                <a href="{{ route('admin.exhibitions') }}" class="btn btn-outline-light btn-sm me-2">🖼️ Выставки</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Выйти</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Дашборд администратора</h4>
            </div>
            <div class="card-body">
                <p>Добро пожаловать в панель администратора!</p>
                <p>Вы успешно вошли как администратор системы.</p>

                <div class="mt-4">
                    <h5>Доступные действия:</h5>
                    <div class="d-flex gap-2 mt-2">
                        <a href="{{ route('admin.users') }}" class="btn btn-primary">Управление пользователями</a>
                        <a href="/exhibitions" class="btn btn-secondary">Перейти к выставкам</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
