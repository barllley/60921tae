<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3 text-dark" href="{{ route('home') }}">
            SATURA
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link text-dark fw-medium position-relative py-3" href="{{ route('home') }}">
                        Главная
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-dark fw-medium position-relative py-3" href="{{ route('exhibitions.index') }}">
                        Выставки
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link text-dark fw-medium position-relative py-3" href="{{ route('tickets.index') }}">
                        Билеты
                    </a>
                </li>

                @auth
                    @if(Auth::user()->is_admin)
                        <li class="nav-item mx-2">
                            <a class="nav-link text-dark fw-medium position-relative py-3" href="{{ route('admin.users') }}">
                                Пользователи
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>

            <ul class="navbar-nav">
                @php
                    $cartCount = count(Session::get('cart', []));
                @endphp

                <li class="nav-item me-3">
                    <a class="nav-link text-dark fw-medium position-relative py-3" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i>
                        Корзина
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-medium d-flex align-items-center py-3" href="#"
                           id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-md-inline me-2">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2" aria-labelledby="userDropdown">

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2 text-dark">
                                        <i class="fas fa-sign-out-alt me-3 text-muted"></i>
                                        Выйти
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-dark fw-medium py-3 px-0 px-lg-3" href="{{ route('login') }}">
                            Войти
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div style="height: 76px;"></div>

@push('styles')
<style>
.navbar {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(10px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
}

.navbar-brand {
    letter-spacing: -0.5px;
    transition: opacity 0.3s ease;
}

.navbar-brand:hover {
    opacity: 0.7;
}

.nav-link {
    color: #1a1a1a !important;
    font-weight: 400;
    font-size: 0.95rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 1px;
    background: #1a1a1a;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transform: translateX(-50%);
}

.nav-link:hover::after,
.nav-link.active::after {
    width: 100%;
}

.nav-link:hover {
    color: #1a1a1a !important;
}

.navbar-nav .nav-item.active .nav-link {
    font-weight: 500;
}

/* Dropdown стили */
.dropdown-menu {
    min-width: 200px;
    border-radius: 0;
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.dropdown-item {
    font-size: 0.9rem;
    transition: all 0.2s ease;
    color: #1a1a1a !important;
}

.dropdown-item:hover {
    background: #f8f9fa !important;
    color: #1a1a1a !important;
}

.navbar-nav .nav-link[href*="login"] {
    font-weight: 500;
    padding-right: 0 !important;
}

@media (max-width: 991.98px) {
    .navbar-collapse {
        background: white;
        margin-top: 1rem;
        padding: 1rem;
        border-radius: 0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .nav-link::after {
        display: none;
    }

    .nav-link {
        padding: 0.75rem 0 !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .navbar-nav .nav-item:last-child .nav-link {
        border-bottom: none;
    }

    .navbar-nav .nav-link[href*="login"] {
        padding-right: 0.5rem !important;
        text-align: center;
        font-weight: 600;
        margin-top: 0.5rem;
    }
}

.navbar-collapse.collapsing {
    transition: height 0.3s ease;
}

.navbar-scrolled {
    background: rgba(255, 255, 255, 0.98) !important;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentUrl = window.location.href;
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.href === currentUrl) {
            link.classList.add('active');
            link.parentElement.classList.add('active');
        }
    });
});

window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('navbar-scrolled');
    } else {
        navbar.classList.remove('navbar-scrolled');
    }
});
</script>
@endpush
