<!DOCTYPE html>
<html>
<head>
    <title>Посетители выставки {{ $exhibition->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Посетители выставки: {{ $exhibition->title }}</h1>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Описание:</strong> {{ $exhibition->description }}</p>
                <p><strong>Период:</strong>
                    {{ $exhibition->start_date->format('d.m.Y H:i') }} -
                    {{ $exhibition->end_date->format('d.m.Y H:i') }}
                </p>
            </div>
        </div>

        <h3>Список посетителей</h3>

        @if($exhibition->users->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Дата посещения</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exhibition->users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->pivot->visited_at)
                                        {{ \Carbon\Carbon::parse($user->pivot->visited_at)->format('d.m.Y H:i') }}
                                    @else
                                        <span class="text-muted">Не указана</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="alert alert-info">
                Всего посетителей: {{ $exhibition->users->count() }}
            </div>
        @else
            <div class="alert alert-warning">У этой выставки пока нет посетителей</div>
        @endif

        <a href="{{ route('exhibitions.show', $exhibition->id) }}" class="btn btn-secondary">Назад к выставке</a>
        <a href="{{ route('exhibitions.index') }}" class="btn btn-outline-primary">Все выставки</a>
    </div>
</body>
</html>
