<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями</title>
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
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm me-2">📊 Дашборд</a>
                <a href="/exhibitions" class="btn btn-outline-light btn-sm me-2">🖼️ Выставки</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Выйти</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Управление пользователями</h4>
                <span class="badge bg-primary">Всего: {{ $users->count() }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Роль</th>
                                <th>Дата регистрации</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->is_admin == 1)
                                        <span class="badge bg-success">Администратор</span>
                                    @else
                                        <span class="badge bg-secondary">Пользователь</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
