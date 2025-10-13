@extends('layout')

@section('title', $exhibition->title)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-palette"></i> {{ $exhibition->title }}</h1>

        @if(Auth::user() and Auth::user()->is_admin)
            <a href="{{ route('tickets.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Добавить билет
            </a>
        @endif
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="fas fa-info-circle"></i> Информация о выставке</h5>
            <p class="card-text"><strong>Описание:</strong> {{ $exhibition->description }}</p>
            <p class="card-text">
                <strong><i class="fas fa-calendar-day"></i> Дата начала:</strong>
                {{ $exhibition->start_date->format('d.m.Y') }}
            </p>
            <p class="card-text">
                <strong><i class="fas fa-calendar-times"></i> Дата окончания:</strong>
                {{ $exhibition->end_date->format('d.m.Y') }}
            </p>
        </div>
    </div>

    <h3><i class="fas fa-ticket-alt"></i> Доступные билеты</h3>

    @if($exhibition->tickets->count() > 0)
        <div class="row">
            @foreach($exhibition->tickets as $ticket)
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                @if($ticket->type == 'vip')
                                    <span class="badge bg-warning"><i class="fas fa-crown"></i> VIP Билет</span>
                                @elseif($ticket->type == 'child')
                                    <span class="badge bg-info"><i class="fas fa-child"></i> Детский билет</span>
                                @else
                                    <span class="badge bg-primary"><i class="fas fa-ticket-alt"></i> Стандартный билет</span>
                                @endif
                            </h5>
                            <p class="card-text">
                                <strong><i class="fas fa-tag"></i> Цена:</strong> {{ $ticket->price }} руб.
                            </p>
                            <p class="card-text">
                                <strong><i class="fas fa-box-open"></i> Доступно:</strong> {{ $ticket->available_quantity }} шт.
                            </p>
                            <div class="btn-group">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i> Подробнее
                                </a>

                                @if(Auth::user() and Auth::user()->is_admin)
                                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Редактировать
                                    </a>
                                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Вы уверены, что хотите удалить этот билет?')">
                                            <i class="fas fa-trash"></i> Удалить
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> Для этой выставки пока нет билетов
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('exhibitions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Назад к списку выставок
        </a>

        @if(Auth::user() and Auth::user()->is_admin)
            <a href="{{ route('tickets.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Создать новый билет
            </a>
        @endif
    </div>
@endsection
