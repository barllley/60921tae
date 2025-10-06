@extends('layout')

@section('title', 'Список билетов')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-ticket-alt"></i> Все билеты</h1>

        @if(Auth::user() && Auth::user()->is_admin)
            <a href="{{ route('tickets.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Создать билет
            </a>
        @endif
    </div>

    <!-- Флэш-сообщения -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Поле выбора количества элементов -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('tickets.index') }}" class="d-flex align-items-center">
                <label for="per_page" class="form-label mb-0 me-2">Показывать по:</label>
                <select name="per_page" id="per_page" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page', 5) == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page', 5) == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ request('per_page', 5) == 20 ? 'selected' : '' }}>20</option>
                    <option value="25" {{ request('per_page', 5) == 25 ? 'selected' : '' }}>25</option>
                </select>
                <!-- Сохраняем другие GET-параметры -->
                @foreach(request()->except('per_page', 'page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
            </form>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="text-muted">
                Найдено билетов: <strong>{{ $tickets->total() }}</strong>
            </div>
        </div>
    </div>

    @if($tickets->count() > 0)
        <div class="row">
            @foreach($tickets as $ticket)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong>#{{ $ticket->id }}</strong>
                            @if($ticket->type == 'vip')
                                <span class="badge bg-warning fs-6"><i class="fas fa-crown"></i> VIP</span>
                            @elseif($ticket->type == 'child')
                                <span class="badge bg-info fs-6"><i class="fas fa-child"></i> Детский</span>
                            @else
                                <span class="badge bg-primary fs-6"><i class="fas fa-ticket-alt"></i> Стандартный</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="card-title text-primary mb-2">
                                @if($ticket->exhibition)
                                    {{ $ticket->exhibition->title }}
                                @else
                                    <span class="text-muted">Выставка не указана</span>
                                @endif
                            </h6>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold fs-5 text-success">{{ number_format($ticket->price, 0, ',', ' ') }} руб.</span>
                                @if($ticket->available_quantity > 0)
                                    <span class="badge bg-success">{{ $ticket->available_quantity }} шт.</span>
                                @else
                                    <span class="badge bg-danger">Нет в наличии</span>
                                @endif
                            </div>
                        </div>

                        @if($ticket->exhibition)
                        <div class="exhibition-info border-top pt-2">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $ticket->exhibition->start_date->format('d.m.Y') }} -
                                {{ $ticket->exhibition->end_date->format('d.m.Y') }}
                            </small>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="btn-group w-100">
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i> Подробнее
                            </a>
                            @if(Auth::user() && Auth::user()->is_admin)
                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm flex-fill" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100"
                                            onclick="return confirm('Вы уверены, что хотите удалить билет #{{ $ticket->id }}?')"
                                            title="Удалить">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Кнопка "В корзину" -->
                        @if($ticket->available_quantity > 0)
                            <form action="{{ route('cart.add', $ticket->id) }}" method="POST" class="w-100">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="fas fa-cart-plus me-1"></i> В корзину
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm w-100" disabled>
                                <i class="fas fa-cart-plus me-1"></i> Нет в наличии
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Упрощенная пагинация -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Показано с <strong>{{ $tickets->firstItem() }}</strong> по <strong>{{ $tickets->lastItem() }}</strong>
                из <strong>{{ $tickets->total() }}</strong> записей
            </div>

            <!-- Стандартная пагинация Laravel -->
            {{ $tickets->appends(request()->except('page'))->links() }}
        </div>
    @else
        <div class="alert alert-info text-center py-4">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <h4>Билеты не найдены</h4>
            <p class="mb-0">На данный момент нет доступных билетов.</p>
            @if(Auth::user() && Auth::user()->is_admin)
                <a href="{{ route('tickets.create') }}" class="btn btn-success mt-3">
                    <i class="fas fa-plus"></i> Создать первый билет
                </a>
            @endif
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('exhibitions.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-palette"></i> Перейти к выставкам
        </a>

        @if(Auth::user() && Auth::user()->is_admin)
            <a href="{{ route('tickets.create') }}" class="btn btn-outline-success ms-2">
                <i class="fas fa-plus"></i> Добавить билет
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
