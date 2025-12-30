<footer class="bg-dark text-white pt-5 pb-4 mt-auto">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold">DernekWeb</h5>
                <p class="text-white-50">Toplumsal dayanışmayı güçlendiren, ölçülebilir etki yaratan projeler yürütüyoruz.</p>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold">Hızlı Bağlantılar</h6>
                <ul class="list-unstyled text-white-50">
                    <li><a class="text-white-50 text-decoration-none" href="about.php">Hakkımızda</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="events.php">Etkinlikler</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="donate.php">Bağış</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="contact.php">İletişim</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6 class="fw-bold">Bülten</h6>
                <p class="text-white-50">E-posta bültenine katılın, projelerden haberdar olun.</p>
                <form class="d-flex gap-2" action="#" method="post">
                    <input type="email" class="form-control" placeholder="E-posta adresiniz" required>
                    <button class="btn btn-primary" type="submit">Gönder</button>
                </form>
            </div>
        </div>
        <hr class="border-light border-opacity-10 my-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-white-50 small">
            <span>© <?= date('Y'); ?> DernekWeb. Tüm hakları saklıdır.</span>
            <div class="d-flex gap-3">
                <a class="text-white-50" href="#"><i class="fab fa-instagram"></i></a>
                <a class="text-white-50" href="#"><i class="fab fa-linkedin"></i></a>
                <a class="text-white-50" href="#"><i class="fab fa-facebook"></i></a>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
