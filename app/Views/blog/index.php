<main class="container">
    <div class="blog-header-section">
        <h1 class="blog-main-title">Blog Kiến Thức & Hướng Dẫn <span>Bảo Mật 2FA</span></h1>
        <p class="blog-main-subtitle">Tổng hợp kinh nghiệm, thủ thuật xác thực hai yếu tố, xử lý sự cố mã 2FA Facebook, Google và cẩm nang bảo mật cho dân MMO, quảng cáo trực tuyến mới nhất 2026.</p>
    </div>

    <div class="blog-grid">
        <?php foreach ($articles as $art): ?>
            <article class="card blog-card">
                <div class="blog-card-meta">
                    <span class="blog-badge"><?= htmlspecialchars($art['category']) ?></span>
                    <span class="blog-read-time">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="14" height="14" style="vertical-align: -2px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <?= htmlspecialchars($art['read_time']) ?>
                    </span>
                </div>

                <h2 class="blog-card-title">
                    <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($art['slug']) ?>">
                        <?= htmlspecialchars($art['title']) ?>
                    </a>
                </h2>

                <p class="blog-card-excerpt">
                    <?= htmlspecialchars($art['excerpt']) ?>
                </p>

                <div class="blog-card-footer">
                    <div class="blog-author-info">
                        <span class="blog-date"><?= date('d/m/Y', strtotime($art['date'])) ?></span>
                    </div>
                    <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($art['slug']) ?>" class="btn-read-more">
                        Đọc tiếp
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <!-- Bottom Banner CTA -->
    <div class="card blog-cta-banner">
        <div class="cta-banner-text">
            <h3>Cần lấy mã 2FA từ Secret Key ngay bây giờ?</h3>
            <p>Sử dụng công cụ trực tuyến miễn phí của chúng tôi để trích xuất mã 2FA hàng loạt lên đến 500 dòng siêu tốc, an toàn 100% tại trình duyệt.</p>
        </div>
        <a href="<?= BASE_URL ?>/" class="btn btn-primary btn-cta-large">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:1.25rem; height:1.25rem;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Mở công cụ lấy mã 2FA
        </a>
    </div>
</main>
