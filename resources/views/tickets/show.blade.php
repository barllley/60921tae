<!DOCTYPE html>
<html>
<head>
    <title>Информация о билете</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Информация о билете</h1>

        <div class="card mb-4">
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

                <p><strong>Цена:</strong> {{ $ticket->price }} руб.</p>
                <p><strong>Доступно:</strong> {{ $ticket->available_quantity }} шт.</p>

                <h5 class="mt-4">Информация о выставке</h5>
                <div class="card">
                    <div class="card-body">
                        <h6>{{ $ticket->exhibition->title }}</h6>
                        <p class="mb-1"><strong>Описание:</strong> {{ $ticket->exhibition->description }}</p>
                        <p class="mb-1">
                            <strong>Период:</strong>
                            {{ $ticket->exhibition->start_date->format('d.m.Y') }} -
                            {{ $ticket->exhibition->end_date->format('d.m.Y') }}
                        </p>
                        <a href="{{ route('exhibitions.show', $ticket->exhibition->id) }}" class="btn btn-outline-primary btn-sm mt-2">
                            Подробнее о выставке
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Назад к списку билетов</a>
        <a href="{{ route('exhibitions.index') }}" class="btn btn-outline-primary">Все выставки</a>
    </div>
</body>
</html>
