@extends('layout')

@section('title', 'Главная страница')

@section('content')
    <div class="jumbotron bg-light p-5 rounded">
        <div class="container">
            <h1 class="display-4"><i class="fas fa-ticket-alt text-primary"></i> Добро пожаловать в Satura!</h1>
            <p class="lead">Система бронирования билетов на выставки и культурные мероприятия</p>
            <hr class="my-4">
            <p>Просматривайте текущие выставки, выбирайте билеты и бронируйте их онлайн.</p>
            <div class="mt-4">
                <a class="btn btn-primary btn-lg" href="{{ route('exhibitions.index') }}">
                    <i class="fas fa-palette"></i> Смотреть выставки
                </a>
                <a class="btn btn-outline-secondary btn-lg" href="{{ route('tickets.index') }}">
                    <i class="fas fa-ticket-alt"></i> Все билеты
                </a>

                @guest
                    <a class="btn btn-success btn-lg" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Войти в систему
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-palette fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Выставки</h5>
                    <p class="card-text">Ознакомьтесь с текущими и предстоящими выставками современного искусства, историческими экспозициями и научными выставками.</p>
                    <a href="{{ route('exhibitions.index') }}" class="btn btn-outline-primary">Перейти к выставкам</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-ticket-alt fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Билеты</h5>
                    <p class="card-text">Выберите подходящий тип билета - стандартный, VIP или детский. Узнайте актуальные цены и доступность.</p>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-success">Смотреть билеты</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fas fa-mobile-alt fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Онлайн бронирование</h5>
                    <p class="card-text">Удобное бронирование билетов без необходимости посещения касс. Быстро, просто и безопасно.</p>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-info">Забронировать</a>
                </div>
            </div>
        </div>
    </div>

    @auth
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-user-circle"></i> Добро пожаловать, {{ Auth::user()->name }}!</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Ваш профиль:</h5>
                                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                <p><strong>Роль:</strong>
                                    @if(Auth::user()->is_admin)
                                        <span class="badge bg-warning">Администратор</span>
                                    @else
                                        <span class="badge bg-secondary">Пользователь</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5>Быстрые действия:</h5>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('exhibitions.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-palette"></i> Управление выставками
                                    </a>
                                    @if(Auth::user()->is_admin)
                                        <a href="{{ route('tickets.create') }}" class="btn btn-outline-success">
                                            <i class="fas fa-plus"></i> Создать билет
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-dark text-white">
                <div class="card-body text-center">
                    <h3><i class="fas fa-info-circle"></i> О системе Satura</h3>
                    <p class="mb-0">Satura - современная система управления выставками и продажи билетов, разработанная для удобства посетителей и администраторов.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
