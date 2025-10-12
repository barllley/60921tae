@extends('layout')

@section('title', 'Satura - Галерея современного искусства')

@section('content')
    <!-- мэин -->
    <section class="hero-section bg-white text-dark py-5 mb-5">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">SATURA</h1>
                    <p class="lead mb-4">
                        Галерея современного искусства, где каждая выставка - это диалог
                        между художником и зрителем. Откройте для себя смелые идеи,
                        инновационные техники и актуальные темы через призму современного творчества.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- на этой неделе -->
    <section class="weekly-exhibitions mb-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h1">
                    <i class="fas fa-calendar-week text-primary me-3"></i>
                    Выставки этой недели
                </h2>
                <a href="{{ route('exhibitions.index') }}" class="btn btn-outline-primary">
                    Все выставки <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>

            @if($weeklyExhibitions->count() > 0)
                <div class="row g-4">
                    @foreach($weeklyExhibitions as $exhibition)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm exhibition-card">
                            <div class="card-header bg-transparent border-bottom-0 pt-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="card-title mb-0 text-primary">{{ Str::limit($exhibition->title, 40) }}</h5>
                                    <span class="badge bg-success">
                                        <i class="fas fa-clock me-1"></i>
                                        Сейчас
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-muted mb-3">
                                    {{ Str::limit($exhibition->description, 120) }}
                                </p>

                                <div class="exhibition-dates mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $exhibition->start_date->format('d.m.Y') }} -
                                        {{ $exhibition->end_date->format('d.m.Y') }}
                                    </small>
                                </div>

                                <div class="exhibition-time mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $exhibition->start_date->format('H:i') }} -
                                        {{ $exhibition->end_date->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('exhibitions.show', $exhibition->id) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i> Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times display-1 text-muted mb-3"></i>
                    <h3 class="text-muted">На этой неделе нет выставок</h3>
                    <p class="text-muted mb-4">Следите за обновлениями в нашем расписании</p>
                    <a href="{{ route('exhibitions.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-palette me-2"></i>Все выставки
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- о галерее -->
    <section class="about-section bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="h1 mb-4">О галерее Satura</h2>
                    <p class="lead mb-4">
                        Satura - это пространство, где современное искусство находит свой голос.
                        Мы представляем художников, которые смело экспериментируют с формами,
                        материалами и идеями, создавая искусство, актуальное здесь и сейчас.
                    </p>
                    <div class="row">
                        <div class="col-6">
                            <h4 class="text-warning">2018</h4>
                            <p class="text-muted">Год основания</p>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning">50+</h4>
                            <p class="text-muted">Художников</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="art-elements">
                        <i class="fas fa-palette display-1 text-primary mb-3"></i>
                        <i class="fas fa-cube display-1 text-success mx-4 mb-3"></i>
                        <i class="fas fa-photo-video display-1 text-warning mb-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- преимущества -->
    <section class="features-section py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="h1 mb-3">Почему выбирают Satura?</h2>
                    <p class="lead text-muted">Уникальный опыт погружения в современное искусство</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="feature-icon bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-star fa-2x text-white"></i>
                        </div>
                        <h4>Эксклюзивные выставки</h4>
                        <p class="text-muted">Работы современных художников, которые вы не увидите больше нигде</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="feature-icon bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-users fa-2x text-white"></i>
                        </div>
                        <h4>Встречи с художниками</h4>
                        <p class="text-muted">Личное общение с творцами и авторами произведений</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <div class="feature-icon bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-compass fa-2x text-white"></i>
                        </div>
                        <h4>Экскурсии и туры</h4>
                        <p class="text-muted">Профессиональные гиды помогут понять искусство глубже</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #2c3e50 0%, #8e44ad 100%);
    border-radius: 0 0 2rem 2rem;
}

.min-vh-50 {
    min-height: 60vh;
}

.exhibition-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}

.exhibition-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.feature-icon {
    transition: transform 0.3s ease;
}

.feature-icon:hover {
    transform: scale(1.1);
}

.art-elements i {
    opacity: 0.7;
    transition: all 0.3s ease;
}

.art-elements i:hover {
    opacity: 1;
    transform: scale(1.2);
}
</style>
@endpush
