<!DOCTYPE html>
<html>
<head>
    <title>Все билеты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Все билеты</h1>

        @if($tickets->count() > 0)
            <div class="row">
                @foreach($tickets as $ticket)
                    <div class="col-md-6 mb-4">
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
                                    <strong>Выставка:</strong> {{ $ticket->exhibition->title }}
                                </p>
                                <p class="card-text">
                                    <strong>Цена:</strong> {{ $ticket->price }} руб.
                                </p>
                                <p class="card-text">
                                    <strong>Доступно:</strong> {{ $ticket->available_quantity }} шт.
                                </p>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">Билетов пока нет</div>
        @endif
    </div>
</body>
</html>
