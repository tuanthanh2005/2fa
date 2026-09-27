<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\BlogModel;

class BlogController extends Controller {
    /**
     * Display blog listing page
     */
    public function index() {
        $config = require __DIR__ . '/../../config/config.php';
        $articles = BlogModel::getAll();

        $this->render('blog/index', [
            'title' => 'Blog Kiến Thức & Hướng Dẫn Bảo Mật 2FA - ' . $config['site_name'],
            'description' => 'Tổng hợp các bài viết hướng dẫn chuyên sâu về bảo mật 2FA, thủ thuật xác thực hai yếu tố cho Facebook, Google và công cụ lấy mã 2FA trực tuyến.',
            'keywords' => 'blog 2fa, hướng dẫn 2fa, thủ thuật 2fa, lấy mã 2fa online, bảo mật 2 lớp',
            'articles' => $articles
        ]);
    }

    /**
     * Display single blog post detail
     *
     * @param string $slug
     */
    public function detail($slug) {
        $config = require __DIR__ . '/../../config/config.php';
        $article = BlogModel::getBySlug($slug);

        if (!$article) {
            http_response_code(404);
            $this->render('home', [
                'title' => 'Bài viết không tồn tại - ' . $config['site_name'],
                'description' => $config['site_description'],
                'keywords' => $config['site_keywords']
            ]);
            return;
        }

        // Get related articles (exclude current)
        $all = BlogModel::getAll();
        $related = array_filter($all, function($a) use ($slug) {
            return $a['slug'] !== $slug;
        });

        $this->render('blog/detail', [
            'title' => $article['title'] . ' | ' . $config['site_name'],
            'description' => $article['meta_description'],
            'keywords' => $article['keywords'],
            'article' => $article,
            'related' => array_slice($related, 0, 3)
        ]);
    }
}
