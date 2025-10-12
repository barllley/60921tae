<footer class="bg-light text-dark py-5 mt-5 border-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-dark fw-bold mb-3 fs-4">Satura</h5>
                <p class="text-dark opacity-75 mb-0">Пространство современного искусства, где каждый найдет что-то для себя.</p>
            </div>
            <div class="col-lg-2 col-md-3 mb-4 mb-md-0">
                <h6 class="text-dark fw-semibold mb-3">Навигация</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="text-dark text-decoration-none opacity-75 hover-opacity-100 transition">
                            Главная
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('exhibitions.index') }}" class="text-dark text-decoration-none opacity-75 hover-opacity-100 transition">
                            Выставки
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('tickets.index') }}" class="text-dark text-decoration-none opacity-75 hover-opacity-100 transition">
                            Билеты
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}" class="text-dark text-decoration-none opacity-75 hover-opacity-100 transition">
                            Корзина
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-3 mb-4 mb-md-0">
                <h6 class="text-dark fw-semibold mb-3">Контакты</h6>
                <ul class="list-unstyled">
                    <li class="text-dark opacity-75 mb-2 d-flex align-items-start">
                        <i class="fas fa-map-marker-alt mt-1 me-2"></i>
                        <span>Владивосток, ул. Искусств, 1</span>
                    </li>
                    <li class="text-dark opacity-75 mb-2 d-flex align-items-center">
                        <i class="fas fa-phone me-2"></i>
                        <span>+7 (555) 555-55-55</span>
                    </li>
                    <li class="text-dark opacity-75 d-flex align-items-center">
                        <i class="fas fa-envelope me-2"></i>
                        <span>info@satura.ru</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="text-dark fw-semibold mb-3">Мы в соцсетях</h6>
                <div class="social-links mb-4">
                    <a href="#" class="text-dark opacity-75 me-3 transition" title="Telegram">
                        <i class="fab fa-telegram fa-xl"></i>
                    </a>
                    <a href="#" class="text-dark opacity-75 transition" title="VK">
                        <i class="fab fa-vk fa-xl"></i>
                    </a>
                </div>

            </div>
        </div>

        <hr class="my-4 bg-secondary opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-dark opacity-75">
                    &copy; {{ date('Y') }} Satura. Искусство, которое говорит с тобой.
                </p>
            </div>
        </div>
    </div>
</footer>

<style>
.hover-opacity-100:hover {
    opacity: 1 !important;
    text-decoration: underline !important;
}

.transition {
    transition: all 0.3s ease;
}

.social-links a:hover {
    opacity: 1 !important;
    transform: translateY(-2px);
}

.form-control:focus {
    border-color: #000;
    box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
}

.btn-dark:hover {
    background-color: #333;
    border-color: #333;
}


@media (max-width: 768px) {
    .text-md-end {
        text-align: center !important;
    }

    .d-flex.justify-content-md-end {
        justify-content: center !important;
    }

    .social-links {
        text-align: center;
    }

    .social-links a {
        margin: 0 10px;
    }
}
</style>
