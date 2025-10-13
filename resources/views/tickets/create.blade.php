@extends('layout')

@section('title', 'Создание билета')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle"></i> Создание нового билета</h1>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад к списку
        </a>
    </div>

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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-ticket-alt"></i> Форма создания билета</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('tickets.store') }}" method="POST">
                @csrf

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
                                        {{ old('exhibition_id') == $exhibition->id ? 'selected' : '' }}>
                                        {{ $exhibition->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exhibition_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Выберите выставку для которой создается билет</div>
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
                                <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>
                                    Стандартный
                                </option>
                                <option value="vip" {{ old('type') == 'vip' ? 'selected' : '' }}>
                                    VIP
                                </option>
                                <option value="child" {{ old('type') == 'child' ? 'selected' : '' }}>
                                    Детский
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Выберите категорию билета</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">
                                <i class="fas fa-money-bill-wave"></i> Цена *
                            </label>
                            <div class="input-group">
                                <input type="number" step="0.01"
                                       class="form-control @error('price') is-invalid @enderror"
                                       id="price" name="price"
                                       value="{{ old('price') }}"
                                       required min="0"
                                       placeholder="0.00">
                                <span class="input-group-text">руб.</span>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Укажите стоимость билета в рублях</div>
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
                                   value="{{ old('available_quantity') }}"
                                   required min="1"
                                   placeholder="100">
                            @error('available_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Количество билетов доступных для продажи</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success btn-lg me-3">
                        <i class="fas fa-check"></i> Создать билет
                    </button>
                    <button type="reset" class="btn btn-outline-secondary me-3">
                        <i class="fas fa-undo"></i> Очистить форму
                    </button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Информация о типах билетов</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-primary me-2"><i class="fas fa-ticket-alt"></i></span>
                        <h6 class="mb-0">Стандартный</h6>
                    </div>
                    <p class="small text-muted mb-0">Обычный билет для взрослых посетителей с базовым доступом ко всем экспонатам</p>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-warning me-2"><i class="fas fa-crown"></i></span>
                        <h6 class="mb-0">VIP</h6>
                    </div>
                    <p class="small text-muted mb-0">Премиальный билет с дополнительными привилегиями: быстрый вход, экскурсионное обслуживание</p>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-info me-2"><i class="fas fa-child"></i></span>
                        <h6 class="mb-0">Детский</h6>
                    </div>
                    <p class="small text-muted mb-0">Билет для детей до 12 лет со скидкой, требует сопровождения взрослых</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('type').addEventListener('change', function() {
            const priceInput = document.getElementById('price');
            const type = this.value;

            switch(type) {
                case 'standard':
                    priceInput.placeholder = '500.00';
                    break;
                case 'vip':
                    priceInput.placeholder = '1500.00';
                    break;
                case 'child':
                    priceInput.placeholder = '250.00';
                    break;
                default:
                    priceInput.placeholder = '0.00';
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const price = document.getElementById('price').value;
            const quantity = document.getElementById('available_quantity').value;

            if (price <= 0) {
                e.preventDefault();
                alert('Цена должна быть больше 0');
                return false;
            }

            if (quantity < 1) {
                e.preventDefault();
                alert('Количество должно быть не менее 1');
                return false;
            }
        });
    </script>
    @endpush
@endsection
