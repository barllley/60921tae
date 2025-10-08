@extends('layout')

@section('title', 'Корзина - Satura')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- Заголовок -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="h2 fw-bold">Корзина</h1>
                @if(count($tickets) > 0)
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Очистить всю корзину?')">
                            <i class="fas fa-trash me-1"></i> Очистить корзину
                        </button>
                    </form>
                @endif
            </div>

            <!-- Уведомление для неавторизованных пользователей -->
            @if(!auth()->check() && count($tickets) > 0)
                <div class="alert alert-warning mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                        <div>
                            <h6 class="mb-1">Для оформления заказа необходимо авторизоваться</h6>
                            <p class="mb-0">Вы можете добавить билеты в корзину, но для завершения покупки потребуется войти в систему.</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(count($tickets) > 0)
                <div class="row">
                    <!-- Список билетов -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white border-0 py-4">
                                <h5 class="mb-0 fw-bold">Выбранные билеты</h5>
                            </div>
                            <div class="card-body p-0">
                                @foreach($tickets as $ticket)
                                <div class="border-bottom p-4">
                                    <div class="row align-items-center">
                                        <!-- Информация о билете -->
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                @if($ticket->exhibition)
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-light rounded p-2">
                                                            <i class="fas fa-palette text-primary fa-lg"></i>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="fw-bold mb-1">{{ $ticket->exhibition->title ?? 'Билет' }}</h6>
                                                    <p class="text-muted small mb-1">
                                                        @if($ticket->type == 'vip')
                                                            <span class="badge bg-warning">VIP</span>
                                                        @elseif($ticket->type == 'child')
                                                            <span class="badge bg-info">Детский</span>
                                                        @else
                                                            <span class="badge bg-primary">Стандартный</span>
                                                        @endif
                                                    </p>
                                                    @if($ticket->exhibition)
                                                        <p class="text-muted small mb-0">
                                                            <i class="fas fa-calendar-alt me-1"></i>
                                                            {{ $ticket->exhibition->start_date->format('d.m.Y') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Количество -->
                                        <div class="col-md-3">
                                            <div class="d-flex align-items-center">
                                                <form action="{{ route('cart.update', $ticket) }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    <button type="button" class="btn btn-outline-secondary btn-sm quantity-btn" data-action="decrease">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" name="quantity" value="{{ $ticket->quantity }}"
                                                           min="1" max="{{ $ticket->available_quantity }}"
                                                           class="form-control form-control-sm mx-2 text-center"
                                                           style="width: 60px;" readonly>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm quantity-btn" data-action="increase">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <small class="text-muted d-block mt-1 text-center">
                                                Доступно: {{ $ticket->available_quantity }}
                                            </small>
                                        </div>

                                        <!-- Стоимость и удаление -->
                                        <div class="col-md-3 text-end">
                                            <div class="h6 fw-bold mb-2">
                                                {{ number_format($ticket->subtotal, 0, ',', ' ') }} ₽
                                            </div>
                                            <form action="{{ route('cart.remove', $ticket) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0">
                                                    <small><i class="fas fa-trash me-1"></i> Удалить</small>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Итоги и оформление -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                            <div class="card-header bg-white border-0 py-4">
                                <h5 class="mb-0 fw-bold">Итоги заказа</h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Товары ({{ count($tickets) }}):</span>
                                    <span class="fw-medium">{{ number_format($total, 0, ',', ' ') }} ₽</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Комиссия:</span>
                                    <span class="fw-medium">0 ₽</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="fw-bold fs-5">Итого:</span>
                                    <span class="h4 mb-0 fw-bold text-dark">{{ number_format($total, 0, ',', ' ') }} ₽</span>
                                </div>

                                <div class="d-grid">
                                    @if(auth()->check())
                                        <!-- Кнопка для авторизованных пользователей -->
                                        <a href="{{ route('checkout.show') }}" class="btn btn-dark btn-lg py-3 fw-medium">
                                            <i class="fas fa-lock me-2"></i>
                                            Перейти к оформлению
                                        </a>
                                    @else
                                        <!-- Кнопки для неавторизованных пользователей -->
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('login') }}" class="btn btn-warning btn-lg py-3 fw-medium">
                                                <i class="fas fa-sign-in-alt me-2"></i>
                                                Войти для оформления
                                            </a>
                                            <a href="{{ route('register') }}" class="btn btn-outline-dark btn-lg py-3 fw-medium">
                                                <i class="fas fa-user-plus me-2"></i>
                                                Зарегистрироваться
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ route('tickets.index') }}" class="text-muted text-decoration-none">
                                        <i class="fas fa-arrow-left me-1"></i> Продолжить покупки
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Пустая корзина -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-cart display-1 text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">Корзина пуста</h3>
                    <p class="text-muted mb-4">Добавьте билеты, чтобы продолжить</p>
                    <a href="{{ route('tickets.index') }}" class="btn btn-dark btn-lg">
                        <i class="fas fa-ticket-alt me-2"></i> К билетам
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Обработка изменения количества
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('form');
            const input = form.querySelector('input[name="quantity"]');
            let quantity = parseInt(input.value);
            const max = parseInt(input.max);

            if (this.dataset.action === 'increase' && quantity < max) {
                quantity++;
            } else if (this.dataset.action === 'decrease' && quantity > 1) {
                quantity--;
            }

            input.value = quantity;
            form.submit();
        });
    });
});
</script>
@endpush
