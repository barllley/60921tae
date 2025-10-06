@extends('layout')

@section('title', 'Ошибка доступа')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <h4 class="mb-0">Ошибка доступа</h4>
                    </div>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-lock fa-5x text-danger mb-3"></i>
                        <h2 class="text-danger">Доступ запрещен</h2>
                    </div>

                    <div class="alert alert-danger mx-auto" style="max-width: 500px;">
                        <h5 class="alert-heading">
                            <i class="fas fa-ban"></i> Ограничение доступа
                        </h5>
                        <p class="mb-0">{{ session('error') ?? 'У вас недостаточно прав для выполнения этого действия.' }}</p>
                    </div>

                    <div class="mt-4">
                        <p class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Для выполнения этого действия требуются права администратора.
                        </p>
                    </div>

                    <div class="btn-group mt-4" role="group">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                        <a href="{{ route('exhibitions.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home"></i> На главную
                        </a>
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-ticket-alt"></i> Билеты
                        </a>

                        @if(Auth::check())
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-sign-out-alt"></i> Выйти
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-success">
                                <i class="fas fa-sign-in-alt"></i> Войти
                            </a>
                        @endif
                    </div>

                    @if(Auth::check() && !Auth::user()->is_admin)
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6><i class="fas fa-user"></i> Информация о пользователе</h6>
                            <p class="mb-1">Вы вошли как: <strong>{{ Auth::user()->name }}</strong></p>
                            <p class="mb-1">Email: <strong>{{ Auth::user()->email }}</strong></p>
                            <p class="mb-0">Роль: <span class="badge bg-secondary">Пользователь</span></p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt"></i>
                        Система безопасности Satura
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
