@extends('layout')

@section('title', 'Редактирование билета')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit"></i> Редактирование билета</h1>
        <div class="btn-group">
            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-outline-primary">
                <i class="fas fa-eye"></i> Просмотр
            </a>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад к списку
            </a>
        </div>
    </div>

    <!-- Флэш-сообщения -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <h5><i class="fas fa-exclamation-triangle"></i> Обнаружены ошибки:</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit"></i> Форма редактирования
                        @if($ticket->type == 'vip')
                            <span class="badge bg-warning text-dark ms-2"><i class="fas fa-crown"></i> VIP Билет</span>
                        @elseif($ticket->type == 'child')
                            <span class="badge bg-info ms-2"><i class="fas fa-child"></i> Детский билет</span>
                        @else
                            <span class="badge bg-primary ms-2"><i class="fas fa-ticket-alt"></i> Стандартный билет</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exhibition_id" class="form-label">
                                        <i class="fas fa-palette"></i> Выставка *
                                    </label>
                                    <select class="form-select @error('exhibition_id') is-invalid @enderror"
                                            id="exhibition_id" name="exhibition_id" required>
                                        <option value="">Выберите выставку</option>
                                        @foreach($exhibitions as $exhibition)
                                            <option value="{{ $exhibition->id }}"
                                                {{ old('exhibition_id', $ticket->exhibition_id) == $exhibition->id ? 'selected' : '' }}>
                                                {{ $exhibition->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('exhibition_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-muted">
                                        Текущая выставка: <strong>{{ $ticket->exhibition->title ?? 'Не указана' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">
                                        <i class="fas fa-tag"></i> Тип билета *
                                    </label>
                                    <select class="form-select @error('type') is-invalid @enderror"
                                            id="type" name="type" required>
                                        <option value="">Выберите тип</option>
                                        <option value="standard" {{ old('type', $ticket->type) == 'standard' ? 'selected' : '' }}>
                                            Стандартный
                                        </option>
                                        <option value="vip" {{ old('type', $ticket->type) == 'vip' ? 'selected' : '' }}>
                                            VIP
                                        </option>
                                        <option value="child" {{ old('type', $ticket->type) == 'child' ? 'selected' : '' }}>
                                            Детский
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-muted">
                                        Текущий тип:
                                        <strong>
                                            @if($ticket->type == 'vip')
                                                VIP
                                            @elseif($ticket->type == 'child')
                                                Детский
                                            @else
                                                Стандартный
                                            @endif
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">
                                        <i class="fas fa-money-bill-wave"></i> Цена (руб.) *
                                    </label>
                                    <div class="input-group">
                                        <input type="number" step="0.01"
                                               class="form-control @error('price') is-invalid @enderror"
                                               id="price" name="price"
                                               value="{{ old('price', $ticket->price) }}"
                                               required min="0" placeholder="0.00">
                                        <span class="input-group-text">₽</span>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-muted">
                                        Текущая цена: <strong>{{ number_format($ticket->price, 2) }} руб.</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="available_quantity" class="form-label">
                                        <i class="fas fa-boxes"></i> Доступное количество *
                                    </label>
                                    <input type="number"
                                           class="form-control @error('available_quantity') is-invalid @enderror"
                                           id="available_quantity" name="available_quantity"
                                           value="{{ old('available_quantity', $ticket->available_quantity) }}"
                                           required min="0" placeholder="100">
                                    @error('available_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-muted">
                                        Текущее количество:
                                        <strong>{{ $ticket->available_quantity }} шт.</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="submit" class="btn btn-warning btn-lg">
                                        <i class="fas fa-save"></i> Обновить билет
                                    </button>
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Отмена
                                    </a>
                                </div>
                                <div class="text-muted">
                                    <small>ID: {{ $ticket->id }}</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Блок информации о билете -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Информация о билете</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-palette"></i> Выставка:</strong><br>
                        <span class="text-primary">{{ $ticket->exhibition->title ?? 'Не указана' }}</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-tag"></i> Текущий тип:</strong><br>
                        @if($ticket->type == 'vip')
                            <span class="badge bg-warning text-dark"><i class="fas fa-crown"></i> VIP</span>
                        @elseif($ticket->type == 'child')
                            <span class="badge bg-info"><i class="fas fa-child"></i> Детский</span>
                        @else
                            <span class="badge bg-primary"><i class="fas fa-ticket-alt"></i> Стандартный</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-money-bill-wave"></i> Текущая цена:</strong><br>
                        <span class="text-success fs-5">{{ number_format($ticket->price, 2) }} руб.</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-boxes"></i> В наличии:</strong><br>
                        @if($ticket->available_quantity > 0)
                            <span class="badge bg-success fs-6">{{ $ticket->available_quantity }} шт.</span>
                        @else
                            <span class="badge bg-danger fs-6">Нет в наличии</span>
                        @endif
                    </div>

                    <hr>

                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-calendar-plus"></i> Создан:
                            {{ $ticket->created_at->format('d.m.Y H:i') }}
                        </small>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-calendar-check"></i> Обновлен:
                            {{ $ticket->updated_at->format('d.m.Y H:i') }}
                        </small>
                    </div>

                    <div>
                        <small class="text-muted">
                            <i class="fas fa-user-edit"></i> Редактирует:
                            <strong>{{ Auth::user()->name }}</strong>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Блок быстрых действий -->
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-bolt"></i> Быстрые действия</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i> Просмотр билета
                        </a>
                        <a href="{{ route('exhibitions.show', $ticket->exhibition_id) }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-external-link-alt"></i> Перейти к выставке
                        </a>
                        <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list"></i> Все билеты
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
