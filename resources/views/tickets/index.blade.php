<!DOCTYPE html>
<html>
<head>
    <title>Все билеты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Все билеты</h1>
            <a href="{{ route('tickets.create') }}" class="btn btn-success">Создать билет</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

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
                                <div class="btn-group">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-primary btn-sm">
                                        Подробнее
                                    </a>
                                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Вы уверены, что хотите удалить этот билет?')">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
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
