@extends('layout')

@section('title', 'Редактирование выставки')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit"></i> Редактирование выставки</h1>
        <div class="btn-group">
            <a href="{{ route('exhibitions.show', $exhibition->id) }}" class="btn btn-outline-primary">
                <i class="fas fa-eye"></i> Просмотр
            </a>
            <a href="{{ route('exhibitions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Назад к списку
            </a>
        </div>
    </div>

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
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Форма редактирования</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('exhibitions.update', $exhibition->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Название выставки</label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title', $exhibition->title) }}"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">
                                Текущее название: <strong>{{ $exhibition->title }}</strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="5"
                                      required>{{ old('description', $exhibition->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">
                                        <i class="fas fa-calendar-plus"></i> Дата начала
                                    </label>
                                    <input type="date"
                                           class="form-control @error('start_date') is-invalid @enderror"
                                           id="start_date"
                                           name="start_date"
                                           value="{{ old('start_date', $exhibition->start_date->format('Y-m-d')) }}"
                                           required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">
                                        <i class="fas fa-calendar-check"></i> Дата окончания
                                    </label>
                                    <input type="date"
                                           class="form-control @error('end_date') is-invalid @enderror"
                                           id="end_date"
                                           name="end_date"
                                           value="{{ old('end_date', $exhibition->end_date->format('Y-m-d')) }}"
                                           required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button type="submit" class="btn btn-warning btn-lg">
                                        <i class="fas fa-save"></i> Обновить выставку
                                    </button>
                                    <a href="{{ route('exhibitions.show', $exhibition->id) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Отмена
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Информация о выставке</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Название:</strong><br>
                        <span class="text-primary">{{ $exhibition->title }}</span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-calendar"></i> Период проведения:</strong><br>
                        <span class="text-success">
                            {{ $exhibition->start_date->format('d.m.Y') }} - {{ $exhibition->end_date->format('d.m.Y') }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-ticket-alt"></i> Билеты:</strong><br>
                        @if($exhibition->tickets->count() > 0)
                            <span class="badge bg-success">{{ $exhibition->tickets->count() }} видов билетов</span>
                        @else
                            <span class="badge bg-warning">Билеты не созданы</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

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
