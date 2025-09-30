<!DOCTYPE html>
<html>
<head>
    <title>{{ $exhibition->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>{{ $exhibition->title }}</h1>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Описание:</strong> {{ $exhibition->description }}</p>
                <p><strong>Дата начала:</strong> {{ $exhibition->start_date->format('d.m.Y H:i') }}</p>
                <p><strong>Дата окончания:</strong> {{ $exhibition->end_date->format('d.m.Y H:i') }}</p>
            </div>
        </div>

        <h3>Доступные билеты</h3>

        @if($exhibition->tickets->count() > 0)
            <div class="row">
                @foreach($exhibition->tickets as $ticket)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    @if($ticket->type == 'vip')
                                        VIP Билет
                                    @elseif($ticket->type == 'child')
                                        Детский билет
                                    @else
                                        Стандартный билет
                                    @endif
                                </h5>
                                <p class="card-text">
                                    <strong>Цена:</strong> {{ $ticket->price }} руб.
                                </p>
                                <p class="card-text">
                                    <strong>Доступно:</strong> {{ $ticket->available_quantity }} шт.
                                </p>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-outline-primary">
                                    Подробнее о билете
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning">Для этой выставки пока нет билетов</div>
        @endif

        <a href="{{ route('exhibitions.index') }}" class="btn btn-secondary">Назад к списку выставок</a>
    </div>
</body>
</html>
