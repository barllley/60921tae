<!DOCTYPE html>
<html>
<head>
    <title>Аутентификация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Вход в систему</h4>
                    </div>
                    <div class="card-body">

                        @if(Auth::check())
                            <!-- Если пользователь аутентифицирован -->
                            <div class="alert alert-success text-center">
                                <h5>Добро пожаловать, {{ Auth::user()->name }}!</h5>
                                <p>Вы успешно вошли в систему.</p>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Выйти</button>
                                </form>
                                <a href="{{ route('exhibitions.index') }}" class="btn btn-primary">Перейти к выставкам</a>
                            </div>
                        @else
                            <!-- Форма аутентификации -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('authenticate') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email') }}" required autofocus>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Пароль</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Войти</button>
                                </div>
                            </form>

                            <!-- Тестовые данные -->
                            <div class="mt-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Тестовые учетные записи:</h6>
                                        <p class="mb-1"><strong>Email:</strong> ivan@example.com</p>
                                        <p class="mb-1"><strong>Пароль:</strong> password</p>
                                        <hr>
                                        <p class="mb-1"><strong>Email:</strong> maria@example.com</p>
                                        <p class="mb-1"><strong>Пароль:</strong> password</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
