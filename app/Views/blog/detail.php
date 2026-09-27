<main class="container">
    <div class="blog-detail-layout">
        <article class="card blog-article-card rich-text">
            <!-- Breadcrumb Navigation -->
            <nav class="blog-breadcrumb" aria-label="Breadcrumb">
                <a href="<?= BASE_URL ?>/">Trang chủ</a>
                <span class="breadcrumb-separator">/</span>
                <a href="<?= BASE_URL ?>/blog">Blog</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current"><?= htmlspecialchars($article['category']) ?></span>
            </nav>

            <!-- Article Header -->
            <header class="article-header">
                <div class="article-meta-top">
                    <span class="blog-badge"><?= htmlspecialchars($article['category']) ?></span>
                    <span class="article-date">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="14" height="14" style="vertical-align: -2px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Ngày đăng: <?= date('d/m/Y', strtotime($article['date'])) ?>
                    </span>
                    <span class="article-read-time">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="14" height="14" style="vertical-align: -2px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <?= htmlspecialchars($article['read_time']) ?>
                    </span>
                </div>

                <h1 class="article-title"><?= htmlspecialchars($article['title']) ?></h1>

                <div class="article-author-bar">
                    <div class="author-avatar-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="18" height="18">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <strong><?= htmlspecialchars($article['author']) ?></strong>
                        <span class="verified-badge" title="Tác giả được xác minh">✓ Đã kiểm duyệt nội dung</span>
                    </div>
                </div>
            </header>

            <!-- Article Content -->
            <div class="article-body">
                <?= $article['content'] ?>
            </div>

            <!-- Article Footer Tags & Share -->
            <footer class="article-footer">
                <div class="article-tags">
                    <strong>Từ khóa:</strong>
                    <?php 
                    $tags = array_map('trim', explode(',', $article['keywords']));
                    foreach ($tags as $tag): 
                    ?>
                        <span class="article-tag">#<?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="article-back-bar">
                    <a href="<?= BASE_URL ?>/blog" class="btn btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Quay lại danh sách bài viết
                    </a>
                    <a href="<?= BASE_URL ?>/" class="btn btn-primary">
                        Mở công cụ 2FA Online
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="16" height="16">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </a>
                </div>
            </footer>
        </article>

        <!-- Related Articles Section -->
        <?php if (!empty($related)): ?>
            <div class="related-section">
                <h3 class="related-title">Bài viết liên quan hữu ích</h3>
                <div class="related-grid">
                    <?php foreach ($related as $rel): ?>
                        <div class="card related-card">
                            <span class="blog-badge" style="font-size:0.75rem;"><?= htmlspecialchars($rel['category']) ?></span>
                            <h4>
                                <a href="<?= BASE_URL ?>/blog/<?= htmlspecialchars($rel['slug']) ?>">
                                    <?= htmlspecialchars($rel['title']) ?>
                                </a>
                            </h4>
                            <p class="related-date"><?= date('d/m/Y', strtotime($rel['date'])) ?> · <?= htmlspecialchars($rel['read_time']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- JSON-LD Structured Data for Google Article Indexing -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://2fa.center/blog/<?= htmlspecialchars($article['slug']) ?>"
      },
      "headline": "<?= addslashes($article['title']) ?>",
      "description": "<?= addslashes($article['meta_description']) ?>",
      "image": "https://2fa.center/fav.png",
      "author": {
        "@type": "Organization",
        "name": "2FA Center"
      },
      "publisher": {
        "@type": "Organization",
        "name": "2FA Center",
        "logo": {
          "@type": "ImageObject",
          "url": "https://2fa.center/fav.png"
        }
      },
      "datePublished": "<?= $article['date'] ?>T08:00:00+07:00",
      "dateModified": "<?= $article['date'] ?>T08:00:00+07:00"
    }
    </script>
</main>
