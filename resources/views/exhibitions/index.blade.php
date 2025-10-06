@extends('layout')

@section('title', 'Все выставки')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-palette"></i> Все выставки</h1>
    </div>

    <!-- Форма выбора количества элементов на странице -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('exhibitions.index') }}" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="per_page" class="form-label">Элементов на странице:</label>
                </div>
                <div class="col-auto">
                    <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                        <option value="2" {{ request('per_page') == 2 ? 'selected' : '' }}>2</option>
                        <option value="5" {{ request('per_page') == 5 || !request('per_page') ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    </select>
                </div>
                <div class="col-auto">
                    <span class="text-muted">Всего записей: {{ $exhibitions->total() }}</span>
                </div>
            </form>
        </div>
    </div>

    @if($exhibitions->count() > 0)
        <div class="row">
            @foreach($exhibitions as $exhibition)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $exhibition->title }}</h5>
                            <p class="card-text">{{ Str::limit($exhibition->description, 100) }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $exhibition->start_date->format('d.m.Y') }} -
                                    {{ $exhibition->end_date->format('d.m.Y') }}
                                </small>
                            </p>
                            <p class="card-text">
                                <strong><i class="fas fa-ticket-alt"></i> Билетов доступно:</strong>
                                {{ $exhibition->tickets->count() }}
                            </p>
                            <div class="d-grid">
                                <a href="{{ route('exhibitions.show', $exhibition->id) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Элементы управления пагинацией -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <!-- Первая страница -->
                <li class="page-item {{ $exhibitions->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $exhibitions->url(1) }}" aria-label="First">
                        <span aria-hidden="true">&laquo;&laquo;</span>
                    </a>
                </li>

                <!-- Предыдущая страница -->
                <li class="page-item {{ $exhibitions->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $exhibitions->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <!-- Номера страниц -->
                @foreach ($exhibitions->getUrlRange(1, $exhibitions->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $exhibitions->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                <!-- Следующая страница -->
                <li class="page-item {{ $exhibitions->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $exhibitions->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>

                <!-- Последняя страница -->
                <li class="page-item {{ $exhibitions->currentPage() == $exhibitions->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $exhibitions->url($exhibitions->lastPage()) }}" aria-label="Last">
                        <span aria-hidden="true">&raquo;&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Информация о пагинации -->
        <div class="text-center mt-3">
            <p class="text-muted">
                Показано с {{ $exhibitions->firstItem() }} по {{ $exhibitions->lastItem() }} из {{ $exhibitions->total() }} записей
                (Страница {{ $exhibitions->currentPage() }} из {{ $exhibitions->lastPage() }})
            </p>
        </div>

    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Выставок пока нет
        </div>
    @endif
@endsection
