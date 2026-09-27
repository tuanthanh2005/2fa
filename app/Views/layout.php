<!DOCTYPE html>
<html lang="vi" data-theme="<?= htmlspecialchars($config['default_theme'] ?? 'light') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    
    <!-- Primary Meta Tags -->
    <title><?= htmlspecialchars($title ?? $config['site_title']) ?></title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/fav.png">
    <meta name="title" content="<?= htmlspecialchars($title ?? $config['site_title']) ?>">
    <meta name="description" content="<?= htmlspecialchars($description ?? $config['site_description']) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($keywords ?? $config['site_keywords']) ?>">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Vietnamese">
    <meta name="author" content="2FA Center">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://2fa.center/">
    <meta property="og:title" content="<?= htmlspecialchars($title ?? $config['site_title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($description ?? $config['site_description']) ?>">
    <meta property="og:image" content="https://2fa.center/fav.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://2fa.center/">
    <meta property="twitter:title" content="<?= htmlspecialchars($title ?? $config['site_title']) ?>">
    <meta property="twitter:description" content="<?= htmlspecialchars($description ?? $config['site_description']) ?>">
    <meta property="twitter:image" content="https://2fa.center/fav.png">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://2fa.center/">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/style.css?v=<?= @filemtime(ROOT_PATH . '/style.css') ?: time() ?>">

    <!-- JSON-LD Structured Data for WebApplication -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebApplication",
      "name": "Công cụ lấy mã 2FA Trực Tuyến Hàng Loạt",
      "url": "https://2fa.center",
      "genre": "Security Application",
      "about": {
        "@type": "Thing",
        "name": "Two-Factor Authentication (2FA) Code Extraction"
      },
      "operatingSystem": "All",
      "applicationCategory": "Security",
      "browserRequirements": "Requires JavaScript and Web Crypto API support.",
      "offers": {
        "@type": "Offer",
        "price": "0",
        "priceCurrency": "VND"
      },
      "features": [
        "Trích xuất mã 2FA từ mã bí mật Secret Key",
        "Nhập nhiều dòng 2FA cùng lúc (Lên tới 500 dòng hoàn toàn miễn phí)",
        "Xử lý trực tiếp tại Client 100% không thông qua máy chủ bên thứ ba",
        "Đồng hồ đếm ngược 30 giây trực quan tự động làm mới mã"
      ]
    }
    </script>
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="container">
            <a href="<?= BASE_URL ?>/" class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>2FA Center</span>
            </a>
            
            <div class="header-actions">
                <!-- Hamburger for mobile -->
                <button id="menu-toggle" class="menu-toggle" aria-label="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:1.4rem;height:1.4rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Nav links -->
                <nav id="nav-menu" class="nav-menu">
                    <a href="<?= BASE_URL ?>/" class="nav-link">Trang chủ</a>
                    <a href="<?= BASE_URL ?>/about" class="nav-link">Giới thiệu</a>
                    <a href="<?= BASE_URL ?>/privacy" class="nav-link">Bảo mật</a>
                    <a href="<?= BASE_URL ?>/terms" class="nav-link">Điều khoản</a>
                    <a href="<?= BASE_URL ?>/contact" class="nav-link">Liên hệ</a>
                </nav>

                <button id="theme-switch" class="theme-switch" aria-label="Chuyển đổi giao diện">
                    <!-- Moon Icon -->
                    <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <!-- Sun Icon -->
                    <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m2.828 0l-.707-.707m12.728-12.728l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main View Content Injection -->
    <?= $content ?>

    <!-- Footer Area -->
    <footer>
        <div class="container">
            <div class="footer-compact">
                <p>&copy; 2026 2FA Center. Bảo lưu mọi quyền.</p>
                <div class="footer-links-row">
                    <a href="<?= BASE_URL ?>/about">Giới thiệu</a>
                    <a href="<?= BASE_URL ?>/privacy">Bảo mật</a>
                    <a href="<?= BASE_URL ?>/terms">Điều khoản</a>
                    <a href="<?= BASE_URL ?>/contact">Liên hệ</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Core Logic JavaScript -->
    <script src="<?= BASE_URL ?>/app.js?v=<?= @filemtime(ROOT_PATH . '/app.js') ?: time() ?>"></script>
</body>
</html>
