<!DOCTYPE html>
<html>
<head>
    <title>Все выставки</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Все выставки</h1>

        @if($exhibitions->count() > 0)
            <div class="row">
                @foreach($exhibitions as $exhibition)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $exhibition->title }}</h5>
                                <p class="card-text">{{ Str::limit($exhibition->description, 100) }}</p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        {{ $exhibition->start_date->format('d.m.Y') }} -
                                        {{ $exhibition->end_date->format('d.m.Y') }}
                                    </small>
                                </p>
                                <p class="card-text">
                                    <strong>Билетов доступно:</strong> {{ $exhibition->tickets->count() }}
                                </p>
                                <a href="{{ route('exhibitions.show', $exhibition->id) }}" class="btn btn-primary">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">Выставок пока нет</div>
        @endif
    </div>
</body>
</html>
