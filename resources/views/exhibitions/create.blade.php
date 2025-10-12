@extends('layout')

@section('title', 'Создание выставки')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-plus-circle"></i> Создание новой выставки</h1>
        <a href="{{ route('exhibitions.index') }}" class="btn btn-secondary">
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
            <h5 class="mb-0"><i class="fas fa-palette"></i> Форма создания выставки</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('exhibitions.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">
                        <i class="fas fa-heading"></i> Название выставки *
                    </label>
                    <input type="text"
                           class="form-control @error('title') is-invalid @enderror"
                           id="title"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           placeholder="Введите название выставки">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Укажите уникальное название выставки</div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        <i class="fas fa-align-left"></i> Описание *
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description"
                              name="description"
                              rows="5"
                              required
                              placeholder="Опишите выставку">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Подробно опишите, что посетители увидят на выставке</div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">
                                <i class="fas fa-calendar-plus"></i> Дата начала *
                            </label>
                            <input type="date"
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   id="start_date"
                                   name="start_date"
                                   value="{{ old('start_date') }}"
                                   required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">
                                <i class="fas fa-calendar-check"></i> Дата окончания *
                            </label>
                            <input type="date"
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   id="end_date"
                                   name="end_date"
                                   value="{{ old('end_date') }}"
                                   required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Место проведения *
                    </label>
                    <input type="text"
                           class="form-control @error('location') is-invalid @enderror"
                           id="location"
                           name="location"
                           value="{{ old('location') }}"
                           required
                           placeholder="Введите адрес или название места">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Укажите, где будет проходить выставка</div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success btn-lg me-3">
                        <i class="fas fa-check"></i> Создать выставку
                    </button>
                    <button type="reset" class="btn btn-outline-secondary me-3">
                        <i class="fas fa-undo"></i> Очистить форму
                    </button>
                    <a href="{{ route('exhibitions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Валидация дат
        document.addEventListener('DOMContentLoaded', function() {
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');


            const today = new Date().toISOString().split('T')[0];
            startDate.min = today;

            startDate.addEventListener('change', function() {
                endDate.min = this.value;
            });


            document.querySelector('form').addEventListener('submit', function(e) {
                if (startDate.value && endDate.value) {
                    if (new Date(endDate.value) <= new Date(startDate.value)) {
                        e.preventDefault();
                        alert('Дата окончания должна быть позже даты начала');
                        return false;
                    }
                }
            });
        });
    </script>
    @endpush
@endsection
