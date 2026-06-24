<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\TOTPModel;

class HomeController extends Controller {
    /**
     * Display the main home page
     */
    public function index() {
        // Load default config settings
        $config = require __DIR__ . '/../../config/config.php';
        
        $this->render('home', [
            'title' => $config['site_title'],
            'description' => $config['site_description'],
            'keywords' => $config['site_keywords']
        ]);
    }

    public function about() {
        $config = require __DIR__ . '/../../config/config.php';
        $this->render('about', [
            'title' => 'Giới thiệu - ' . $config['site_name'],
            'description' => 'Trang giới thiệu về công cụ lấy mã 2FA trực tuyến.',
            'keywords' => $config['site_keywords']
        ]);
    }

    public function privacy() {
        $config = require __DIR__ . '/../../config/config.php';
        $this->render('privacy', [
            'title' => 'Chính sách bảo mật - ' . $config['site_name'],
            'description' => 'Chính sách bảo mật thông tin người dùng khi sử dụng công cụ lấy mã 2FA.',
            'keywords' => $config['site_keywords']
        ]);
    }

    public function terms() {
        $config = require __DIR__ . '/../../config/config.php';
        $this->render('terms', [
            'title' => 'Điều khoản sử dụng - ' . $config['site_name'],
            'description' => 'Các điều khoản sử dụng khi truy cập công cụ 2FA Live Extractor.',
            'keywords' => $config['site_keywords']
        ]);
    }

    public function contact() {
        $config = require __DIR__ . '/../../config/config.php';
        $this->render('contact', [
            'title' => 'Liên hệ hỗ trợ - ' . $config['site_name'],
            'description' => 'Trang thông tin liên hệ và gửi phản hồi cho đội ngũ hỗ trợ.',
            'keywords' => $config['site_keywords']
        ]);
    }

    /**
     * API: Generate TOTP codes from secrets list (Server-side)
     */
    public function generateApi() {
        // Get raw POST input
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);
        
        $secretsText = isset($input['secrets']) ? $input['secrets'] : '';
        if (empty($secretsText)) {
            $this->json(['error' => 'Input Empty', 'message' => 'Vui lòng cung cấp khóa bí mật.'], 400);
        }

        $lines = explode("\n", $secretsText);
        $results = [];
        $limit = 500;
        $count = 0;

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed)) continue;

            $count++;
            if ($count > $limit) {
                break;
            }

            // Extract Label and Key (same logic as JS parser)
            $label = "Dòng #" . $count;
            $secret = $trimmed;
            
            // Delimiter separation check
            $delimiters = [':', '|', '='];
            foreach ($delimiters as $delim) {
                $idx = strpos($trimmed, $delim);
                if ($idx !== false) {
                    $part1 = trim(substr($trimmed, 0, $idx));
                    $part2 = trim(substr($trimmed, $idx + 1));
                    if (strlen($part2) >= 8) {
                        $label = $part1;
                        $secret = $part2;
                        break;
                    }
                }
            }

            // Remove spaces from secret key
            $secretClean = str_replace(' ', '', $secret);
            
            // Generate code
            $code = TOTPModel::generateCode($secretClean);

            if ($code !== false) {
                $results[] = [
                    'label' => $label,
                    'secret' => $secretClean,
                    'code' => $code,
                    'success' => true
                ];
            } else {
                $results[] = [
                    'label' => $label,
                    'secret' => $secretClean,
                    'code' => 'Lỗi mã khóa',
                    'success' => false
                ];
            }
        }

        $this->json([
            'success' => true,
            'count' => count($results),
            'results' => $results
        ]);
    }

    /**
     * API: Handle Contact form submission
     */
    public function contactApi() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid Method', 'message' => 'Phương thức yêu cầu không hợp lệ.'], 405);
        }

        // Get inputs (either url-encoded or json)
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
        $message = isset($_POST['message']) ? trim($_POST['message']) : '';

        // Handle JSON raw input fallback
        if (empty($name) && empty($email)) {
            $inputJSON = file_get_contents('php://input');
            $input = json_decode($inputJSON, true);
            $name = isset($input['name']) ? trim($input['name']) : '';
            $email = isset($input['email']) ? trim($input['email']) : '';
            $subject = isset($input['subject']) ? trim($input['subject']) : '';
            $message = isset($input['message']) ? trim($input['message']) : '';
        }

        // Simple validation
        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $this->json(['success' => false, 'message' => 'Vui lòng nhập đầy đủ các trường thông tin.'], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['success' => false, 'message' => 'Địa chỉ email không hợp lệ.'], 400);
        }

        // In a production server, here we would send an email or save to database
        // e.g. mail($to, $subject, $message, $headers);
        
        $this->json([
            'success' => true,
            'message' => 'Cảm ơn ' . htmlspecialchars($name) . '! Tin nhắn của bạn đã được tiếp nhận thành công. Đội ngũ hỗ trợ sẽ gửi email liên hệ sớm nhất.'
        ]);
    }
}
