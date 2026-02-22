<footer class="footer">
    <div class="footer-container">
        <!-- Footer Grid -->
        <div class="footer-grid">
            <!-- About Section -->
            <div class="footer-section">
                <h3>Dinas Kesehatan Kabupaten Semarang</h3>
                <p>
                    Dinas Kesehatan melindungi Kesehatan anda dan keluarga.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h3>Tautan Cepat</h3>
                <div class="footer-links">
                    <a href="{{ route('home') }}" class="footer-link">
                        <i class="fas fa-angle-right"></i> Beranda
                    </a>
                    <a href="{{ route('fasyankes.public') }}" class="footer-link">
                        <i class="fas fa-angle-right"></i> Fasyankes
                    </a>
                    <a href="{{ route('articles.public') }}" class="footer-link">
                        <i class="fas fa-angle-right"></i> Berita
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fas fa-angle-right"></i> Profil
                    </a>
                </div>
            </div>

            <!-- Layanan -->
            <div class="footer-section">
                <h3>Layanan</h3>
                <div class="footer-links">
                    <a href="#" class="footer-link">
                        <i class="fas fa-angle-right"></i> Informasi Publik
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fas fa-angle-right"></i> Pengaduan
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fas fa-angle-right"></i> Permohonan Info
                    </a>
                    <a href="#" class="footer-link">
                        <i class="fas fa-angle-right"></i> Download
                    </a>
                </div>
            </div>

            <!-- Contact -->
            <div class="footer-section">
                <h3>Kontak Kami</h3>
                <div class="footer-links">
                    <div class="footer-link" style="cursor: default;">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Jl. MT. Haryono No. 29 Ungaran</span>
                    </div>
                    <a href="tel:(024) 6923955" class="footer-link">
                        <i class="fas fa-phone"></i> (024) 6923955
                    </a>
                    <a href="mailto:dinkeskabsemarang@gmail.com"><i class="fas fa-envelope"></i> <span class="__cf_email__" data-cfemail="2a4e4344414f596a5a4f4741455e04594f474b584b444d044d4504434e">dinkeskabsemarang@gmail.com</span></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <!-- Social Media -->
            <div class="footer-social">
                <a href="#" class="social-link" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-link" aria-label="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
            
            <!-- Copyright -->
            <p class="footer-text">
                &copy; {{ date('Y') }} Dinas Kesehatan Kabupaten Semarang. V.01.26.
            </p>
        </div>
    </div>
</footer>