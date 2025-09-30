<!DOCTYPE html>
<html>
<head>
    <title>Редактирование билета</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Редактирование билета</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="exhibition_id" class="form-label">Выставка *</label>
                <select class="form-select" id="exhibition_id" name="exhibition_id" required>
                    <option value="">Выберите выставку</option>
                    @foreach($exhibitions as $exhibition)
                        <option value="{{ $exhibition->id }}" {{ $ticket->exhibition_id == $exhibition->id ? 'selected' : '' }}>
                            {{ $exhibition->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Тип билета *</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="">Выберите тип</option>
                    <option value="standard" {{ $ticket->type == 'standard' ? 'selected' : '' }}>Стандартный</option>
                    <option value="vip" {{ $ticket->type == 'vip' ? 'selected' : '' }}>VIP</option>
                    <option value="child" {{ $ticket->type == 'child' ? 'selected' : '' }}>Детский</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Цена *</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price"
                       value="{{ old('price', $ticket->price) }}" required min="0">
            </div>

            <div class="mb-3">
                <label for="available_quantity" class="form-label">Доступное количество *</label>
                <input type="number" class="form-control" id="available_quantity" name="available_quantity"
                       value="{{ old('available_quantity', $ticket->available_quantity) }}" required min="0">
            </div>

            <button type="submit" class="btn btn-primary">Обновить билет</button>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Отмена</a>
        </form>
    </div>
</body>
</html>
