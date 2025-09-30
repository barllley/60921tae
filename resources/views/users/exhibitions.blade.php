<!DOCTYPE html>
<html>
<head>
    <title>Выставки пользователя {{ $user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Выставки пользователя: {{ $user->name }}</h1>
        <p class="text-muted">Email: {{ $user->email }}</p>

        <h3 class="mt-4">Посещенные выставки</h3>

        @if($user->exhibitions->count() > 0)
            <div class="row">
                @foreach($user->exhibitions as $exhibition)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $exhibition->title }}</h5>
                                <p class="card-text">{{ Str::limit($exhibition->description, 100) }}</p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Период: {{ $exhibition->start_date->format('d.m.Y') }} -
                                        {{ $exhibition->end_date->format('d.m.Y') }}
                                    </small>
                                </p>
                                @if($exhibition->pivot->visited_at)
                                    <p class="card-text">
                                        <small class="text-success">
                                            Посещено: {{ \Carbon\Carbon::parse($exhibition->pivot->visited_at)->format('d.m.Y H:i') }}
                                        </small>
                                    </p>
                                @endif
                                <a href="{{ route('exhibitions.show', $exhibition->id) }}" class="btn btn-outline-primary btn-sm">
                                    Подробнее о выставке
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">Пользователь еще не посещал выставки</div>
        @endif

        <a href="{{ route('exhibitions.index') }}" class="btn btn-secondary mt-3">Все выставки</a>
    </div>
</body>
</html>
