<main class="container">
    <div class="card rich-text" style="padding: 2rem; max-width: 600px; margin: 0 auto;">
        <h1 style="text-align: center; margin-bottom: 2rem;">Liên Hệ Với Chúng Tôi</h1>
        
        <div id="contact-form-container">
            <p style="margin-bottom: 1.5rem; text-align: center;">Nếu bạn có bất kỳ câu hỏi, góp ý hoặc cần hỗ trợ, vui lòng điền vào biểu mẫu dưới đây. Đội ngũ của chúng tôi sẽ phản hồi sớm nhất có thể.</p>
            <form id="form-contact" method="POST" action="<?= BASE_URL ?>/api/contact">
                <div class="form-group">
                    <label for="contact-name" class="form-label">Họ và tên:</label>
                    <input type="text" name="name" id="contact-name" class="input-styled" required placeholder="Nhập tên của bạn">
                </div>
                <div class="form-group">
                    <label for="contact-email" class="form-label">Email liên hệ:</label>
                    <input type="email" name="email" id="contact-email" class="input-styled" required placeholder="name@example.com">
                </div>
                <div class="form-group">
                    <label for="contact-subject" class="form-label">Chủ đề:</label>
                    <input type="text" name="subject" id="contact-subject" class="input-styled" required placeholder="Ví dụ: Góp ý tính năng, Hỗ trợ sử dụng">
                </div>
                <div class="form-group">
                    <label for="contact-message" class="form-label">Nội dung chi tiết:</label>
                    <textarea name="message" id="contact-message" class="input-styled" style="min-height: 120px; resize: vertical;" required placeholder="Nhập nội dung cần gửi cho chúng tôi..."></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">Gửi tin nhắn</button>
            </form>
        </div>

        <!-- Contact Success View -->
        <div id="contact-success-state" class="contact-success-state" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3>Đã gửi thành công!</h3>
            <p id="contact-success-message">Cảm ơn bạn đã liên hệ. Đội ngũ hỗ trợ của 2FA Center sẽ phản hồi bạn qua email sớm nhất có thể.</p>
            <div style="margin-top: 1.5rem;">
                <a href="<?= BASE_URL ?>/" class="btn btn-secondary">Quay lại Trang Chủ</a>
            </div>
        </div>
    </div>
</main>
