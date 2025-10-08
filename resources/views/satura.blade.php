@extends('layout')

@section('title', 'Главная')

@section('content')
<div class="hero-section">
    <div class="satura-container">
        <h1 class="satura-text">
            <span>S</span><span>A</span><span>T</span><span>U</span><span>R</span><span>A</span>
        </h1>
        <p class="satura-subtitle">Галерея современного искусства</p>
    </div>
</div>

<style>
.hero-section {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
    margin: 0;
    background: #ffffff;
    color: #000000;
    font-family: 'Arial', sans-serif;
}

.satura-container {
    text-align: center;
}

.satura-text span {
    display: inline-block;
    font-size: 6rem;
    font-weight: 900;
    color: #000000;
    text-transform: uppercase;
    letter-spacing: 2px;
    animation: satura-wave 2s ease-in-out infinite;
}

.satura-text span:nth-child(1) { animation-delay: 0s; }
.satura-text span:nth-child(2) { animation-delay: 0.1s; }
.satura-text span:nth-child(3) { animation-delay: 0.2s; }
.satura-text span:nth-child(4) { animation-delay: 0.3s; }
.satura-text span:nth-child(5) { animation-delay: 0.4s; }
.satura-text span:nth-child(6) { animation-delay: 0.5s; }

.satura-subtitle {
    margin-top: 20px;
    font-size: 1.5rem;
    color: #666;
    font-weight: 300;
    letter-spacing: 3px;
    text-transform: uppercase;
    opacity: 0;
    animation: fadeInUp 1s ease-out 1s forwards;
}

@keyframes satura-wave {
    0%, 100% {
        transform: translateY(0);
        text-shadow: 0 0 0 rgba(0,0,0,0);
    }
    25% {
        transform: translateY(-25px);
        text-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }
    50% {
        transform: translateY(-15px);
        text-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    75% {
        transform: translateY(-5px);
        text-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Адаптивность для мобильных устройств */
@media (max-width: 768px) {
    .satura-text span {
        font-size: 4rem;
    }

    .satura-subtitle {
        font-size: 1.2rem;
    }
}

@media (max-width: 480px) {
    .satura-text span {
        font-size: 3rem;
    }

    .satura-subtitle {
        font-size: 1rem;
    }
}
</style>
@endsection
