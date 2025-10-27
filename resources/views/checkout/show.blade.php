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
                                            <td>{{ $ticket->type }}</td>
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

            <!-- Форма оформления заказа -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Контактная информация</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">ФИО *</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                       id="customer_name" name="customer_name"
                                       value="{{ old('customer_name', Auth::user()->name ?? '') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="customer_email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                       id="customer_email" name="customer_email"
                                       value="{{ old('customer_email', Auth::user()->email ?? '') }}" required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Телефон *</label>
                            <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror"
                                   id="customer_phone" name="customer_phone"
                                   value="{{ old('customer_phone') }}" required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
                    @auth
                        <p><strong>Имя:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    @else
                        <p class="text-muted">Не авторизован</p>
                    @endauth
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
                    <div class="d-flex justify-content-between mb-2">
                        <span>Доставка:</span>
                        <span>0 ₽</span>
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
