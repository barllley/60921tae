@extends('layout')

@section('title', 'Информация о билете')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-ticket-alt"></i> Информация о билете #{{ $ticket->id }}</h1>

        @if(Auth::user() && Auth::user()->is_admin)
            <div class="btn-group">
                <a href="{{ route('tickets.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Создать билет
                </a>
                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Редактировать
                </a>
                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Вы уверены, что хотите удалить билет #{{ $ticket->id }}?')">
                        <i class="fas fa-trash"></i> Удалить
                    </button>
                </form>
            </div>
        @endif
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">
                @if($ticket->type == 'vip')
                    <span class="badge bg-warning fs-6"><i class="fas fa-crown"></i> VIP Билет</span>
                @elseif($ticket->type == 'child')
                    <span class="badge bg-info fs-6"><i class="fas fa-child"></i> Детский билет</span>
                @else
                    <span class="badge bg-light text-dark fs-6"><i class="fas fa-ticket-alt"></i> Стандартный билет</span>
                @endif
            </h5>
        </div>
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-1"><strong><i class="fas fa-tag text-success"></i> Цена:</strong></p>
                        <h4 class="text-success">{{ number_format($ticket->price, 0, ',', ' ') }} руб.</h4>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1"><strong><i class="fas fa-box-open text-primary"></i> Доступное количество:</strong></p>
                        @if($ticket->available_quantity > 0)
                            <span class="badge bg-success fs-6">{{ $ticket->available_quantity }} шт.</span>
                        @else
                            <span class="badge bg-danger fs-6">Нет в наличии</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="mb-1"><strong><i class="fas fa-calendar-alt text-info"></i> Дата создания:</strong></p>
                        <p class="text-muted">{{ $ticket->created_at->format('d.m.Y H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <p class="mb-1"><strong><i class="fas fa-sync-alt text-warning"></i> Последнее обновление:</strong></p>
                        <p class="text-muted">{{ $ticket->updated_at->format('d.m.Y H:i') }}</p>
                    </div>
                </div>
            </div>
            <!-- Кнопка "В корзину" -->
            @if($ticket->available_quantity > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-grid">
                            <form action="{{ route('cart.add', $ticket->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success btn-lg py-3">
                                    <i class="fas fa-cart-plus me-2"></i> Добавить в корзину
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-grid">
                            <button class="btn btn-secondary btn-lg py-3" disabled>
                                <i class="fas fa-cart-plus me-2"></i> Нет в наличии
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <hr>

            <h5 class="mt-4"><i class="fas fa-palette text-primary"></i> Информация о выставке</h5>
            @if($ticket->exhibition)
                <div class="card bg-light mt-3">
                    <div class="card-body">
                        <h6 class="card-title text-primary">{{ $ticket->exhibition->title }}</h6>

                        @if($ticket->exhibition->description)
                            <div class="mb-3">
                                <p class="mb-1"><strong>Описание:</strong></p>
                                <p class="mb-0">{{ $ticket->exhibition->description }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="fas fa-calendar-day text-info"></i> Период проведения:</strong><br>
                                    {{ $ticket->exhibition->start_date->format('d.m.Y') }} - {{ $ticket->exhibition->end_date->format('d.m.Y') }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="fas fa-clock text-warning"></i> Время работы:</strong><br>
                                    {{ $ticket->exhibition->start_date->format('H:i') }} - {{ $ticket->exhibition->end_date->format('H:i') }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="{{ route('exhibitions.show', $ticket->exhibition->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-external-link-alt"></i> Подробнее о выставке
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle"></i> Выставка не привязана к этому билету.
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад к списку билетов
        </a>
        <a href="{{ route('exhibitions.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-palette"></i> Все выставки
        </a>
        @if($ticket->exhibition)
            <a href="{{ route('exhibitions.show', $ticket->exhibition->id) }}" class="btn btn-outline-info">
                <i class="fas fa-eye"></i> Просмотр выставки
            </a>
        @endif
        @if(Auth::user() && Auth::user()->is_admin)
            <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Редактировать билет
            </a>
        @endif
    </div>

    <!-- Скрипт для автоматического скрытия alert через 5 секунд -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Автоматическое скрытие alert через 5 секунд
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endsection
