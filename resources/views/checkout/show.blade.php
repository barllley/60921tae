@extends('layout')

@section('title', 'Оформление заказа')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Оформление заказа</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Информация о заказе -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Детали заказа</h5>
                </div>
                <div class="card-body">
                    @if(isset($tickets) && count($tickets) > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Билет</th>
                                        <th>Выставка</th>
                                        <th>Цена</th>
                                        <th>Количество</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td>
                                                @if($ticket->type == 'vip')
                                                    <span class="badge bg-warning">VIP</span>
                                                @elseif($ticket->type == 'child')
                                                    <span class="badge bg-info">Детский</span>
                                                @else
                                                    <span class="badge bg-primary">Стандартный</span>
                                                @endif
                                            </td>
                                            <td>{{ $ticket->exhibition->title }}</td>
                                            <td>{{ number_format($ticket->price, 2) }} ₽</td>
                                            <td>{{ $ticket->quantity }}</td>
                                            <td>{{ number_format($ticket->subtotal, 2) }} ₽</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>Итого:</strong></td>
                                        <td><strong>{{ number_format($total, 2) }} ₽</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Корзина пуста</p>
                    @endif
                </div>
            </div>

            <!-- Подтверждение заказа -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Подтверждение заказа</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Подтвердить заказ
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                Вернуться в корзину
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Информация о пользователе -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ваши данные</h5>
                </div>
                <div class="card-body">
                    <p><strong>Имя:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                </div>
            </div>

            <!-- Краткая информация о заказе -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Итоговая сумма</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Товары:</span>
                        <span>{{ number_format($total, 2) }} ₽</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>К оплате:</strong>
                        <strong>{{ number_format($total, 2) }} ₽</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
