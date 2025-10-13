@extends('layout')

@section('title', 'Управление пользователями')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-dark">Пользователи</h4>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-primary fs-6">Всего: {{ $users->total() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @if($users->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">ID</th>
                                            <th>Имя</th>
                                            <th>Email</th>
                                            <th>Роль</th>
                                            <th class="text-end pe-3">Дата регистрации</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr class="border-top">
                                            <td class="ps-3 fw-semibold text-muted">#{{ $user->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <span class="text-white fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $user->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $user->email }}</span>
                                                @if($user->email_verified_at)
                                                    <i class="fas fa-check-circle text-success ms-1" title="Email подтверждён"></i>
                                                @endif
                                            </td>
                                            <td>
                                                @if($user->is_admin == 1)
                                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                                        <i class="fas fa-crown me-1"></i>Администратор
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25">
                                                        <i class="fas fa-user me-1"></i>Пользователь
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="text-end pe-3">
                                                <div class="text-muted small">
                                                    <div>{{ $user->created_at->format('d.m.Y') }}</div>
                                                    <div class="text-muted">{{ $user->created_at->format('H:i') }}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($users->hasPages())
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div class="text-muted small">
                                    Показано с {{ $users->firstItem() }} по {{ $users->lastItem() }} из {{ $users->total() }} записей
                                </div>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination mb-0">
                                        @if($users->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">‹</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev">‹</a>
                                            </li>
                                        @endif

                                        @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                            @if($page == $users->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        @if($users->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">›</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">›</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-users fa-4x text-muted opacity-25"></i>
                                </div>
                                <h5 class="text-muted">Пользователи не найдены</h5>
                                <p class="text-muted mb-0">В системе пока нет зарегистрированных пользователей.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        border: 1px solid rgba(0,0,0,.125);
        border-radius: 0.5rem;
    }
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
    }
    .badge {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
    }
    .page-link {
        border: 1px solid #dee2e6;
        color: #495057;
        padding: 0.5rem 0.75rem;
    }
    .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.02);
    }
</style>
@endpush
