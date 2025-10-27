@extends('layout')

@section('title', 'Заказ успешно оформлен')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>

                    <h1 class="mb-3">Заказ успешно оформлен!</h1>

                    <p class="lead mb-4">
                        Спасибо за ваш заказ. Номер вашего заказа: <strong>#{{ $order->id }}</strong>
                    </p>

                    <div class="row mb-4">
                        <div class="col-md-6 mx-auto">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5>Детали заказа</h5>
                                    <p class="mb-1"><strong>Сумма:</strong> {{ number_format($order->total_amount, 2) }} ₽</p>
                                    <p class="mb-1"><strong>Статус:</strong> {{ $order->status }}</p>
                                    <p class="mb-0"><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <p class="mb-0">
                            Электронные билеты будут отправлены на вашу почту в течение 10 минут.
                            Также вы можете найти их в своем личном кабинете.
                        </p>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            На главную
                        </a>
                        <a href="{{ route('users.exhibitions', Auth::id()) }}" class="btn btn-outline-secondary">
                            Мои билеты
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
