{{-- resources/views/partials/footer.blade.php --}}
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <h5 class="text-warning mb-3">
                    <i class="fas fa-palette me-2"></i>Satura Gallery
                </h5>
                <p class="text-light mb-0">
                    Пространство современного искусства
                </p>
            </div>

            <div class="col-md-6 text-center text-md-end">
                <div class="social-links mb-3">
                    <a href="#" class="text-light me-3">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <a href="#" class="text-light">
                        <i class="fab fa-telegram fa-lg"></i>
                    </a>
                </div>
                <p class="text-light mb-0 small">
                    &copy; {{ date('Y') }} Satura. Искусство, которое говорит с тобой.
                </p>
            </div>
        </div>
    </div>
</footer>
