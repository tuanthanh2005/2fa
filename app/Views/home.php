<main class="container">
    
    <!-- Combined Single Card Tool -->
    <div class="card main-tool-card">
        <div class="card-title-area">
            <h2>Công cụ lấy mã 2FA hàng loạt</h2>
            <span class="badge" style="background-color: var(--success-light); color: var(--success);">100% Miễn Phí</span>
        </div>

        <!-- Input area -->
        <div class="form-group">
            <label for="2fa-input" class="form-label">Nhập khóa bảo mật 2FA của bạn (Mỗi dòng một khóa):</label>
            <textarea id="2fa-input" class="textarea-2fa" placeholder="Ví dụ: JBSWY3DPEHPK3PXP"></textarea>
            
            <div class="textarea-footer">
                <span id="limit-indicator">Hỗ trợ nhập tối đa <?= htmlspecialchars($config['line_limit'] ?? 500) ?> dòng</span>
                <span>Số dòng: <strong id="line-counter">0</strong></span>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="tool-actions">
            <button id="btn-generate" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:1.2rem; height:1.2rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Lấy mã 2FA
            </button>
            <button id="btn-clear" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:1.2rem; height:1.2rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Xóa hết
            </button>
        </div>

        <!-- Divider -->
        <div id="results-divider" class="results-divider" style="display:none; margin: 2rem 0; border-top: 1px solid var(--border-color);"></div>

        <!-- Results area inside the same card -->
        <div id="results-wrapper" style="display:none;">
            <div class="results-header-container">
                <h2 id="results-section-header">Mã 2FA của bạn</h2>
                
                <div class="results-timer">
                    <span>Làm mới sau: </span>
                    <strong id="results-timer-text">30s</strong>
                    <svg width="22" height="22" class="timer-circle-svg">
                        <circle cx="11" cy="11" r="9" class="timer-bg-circle"></circle>
                        <circle cx="11" cy="11" r="9" class="timer-progress-circle" id="timer-circle" style="stroke-dasharray: 56.54; stroke-dashoffset: 0;"></circle>
                    </svg>
                </div>
            </div>

            <div id="results-container">
                <!-- Results populated dynamically via JavaScript -->
            </div>
        </div>
    </div>

    <!-- SEO Content Section (Crucial for AdSense Approval) -->
    <div class="seo-section">
        <h2 class="seo-title">Công Cụ Trích Xuất Mã 2FA Live <span>Bảo Mật Hàng Đầu</span></h2>
        
        <div class="seo-grid">
            <div class="seo-card">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 1.5rem; height: 1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Mã 2FA là gì và tại sao lại cần thiết?
                </h3>
                <p><strong>Mã 2FA (Two-Factor Authentication)</strong> hay còn gọi là xác thực hai yếu tố, là phương pháp bảo mật bổ sung cho tài khoản trực tuyến của bạn ngoài mật khẩu thông thường. Để truy cập vào tài khoản, người dùng cần có mật khẩu và một mã bảo mật OTP gồm 6 chữ số được tạo ngẫu nhiên theo thời gian thực tế.</p>
                <p>Công cụ 2FA Live giúp bạn lấy mã bảo mật này từ các mã bí mật (Secret Key/Seed Key) được cung cấp bởi các nền tảng như Google, Facebook, Binance, Tiktok, hay các sàn giao dịch một cách nhanh chóng mà không cần mang theo thiết bị điện thoại hay ứng dụng chuyên biệt.</p>
            </div>

            <div class="seo-card">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 1.5rem; height: 1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Tại sao công cụ của chúng tôi an toàn 100%?
                </h3>
                <p>Mối quan ngại lớn nhất của người dùng khi sử dụng các công cụ lấy mã trực tuyến là nguy cơ rò rỉ mã khóa bí mật (Secret Key). Với công nghệ bảo mật độc quyền chạy tại client-side:</p>
                <ul>
                    <li><strong>Không gửi dữ liệu đi:</strong> Toàn bộ quá trình giải mã Base32 và sinh mã TOTP (Time-Based One-Time Password) được xử lý hoàn toàn trong trình duyệt web của bạn thông qua <strong>Web Crypto API</strong> của hệ điều hành.</li>
                    <li><strong>Không lưu trữ:</strong> Không có bất kỳ dữ liệu nào được chuyển lên máy chủ của chúng tôi hoặc bên thứ ba.</li>
                    <li><strong>Chạy ngoại tuyến (Offline):</strong> Bạn hoàn toàn có thể tắt kết nối Internet (Wifi/4G) sau khi tải trang web và công cụ vẫn hoạt động tạo mã bình thường.</li>
                </ul>
            </div>

            <div class="seo-card">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 1.5rem; height: 1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Định dạng đầu vào được hỗ trợ
                </h3>
                <p>Trình phân tích cú pháp thông minh của chúng tôi tự động phát hiện định dạng khóa của bạn trên mỗi dòng để lấy mã nhanh nhất:</p>
                <ul>
                    <li><strong>Chỉ chứa mã khóa:</strong> Ví dụ: <code>JBSWY3DPEHPK3PXP</code></li>
                    <li><strong>Mã khóa có chứa nhãn (Label):</strong> Hỗ trợ các ký tự phân cách như hai chấm <code>:</code>, gạch dọc <code>|</code>, dấu bằng <code>=</code> hoặc dấu cách. Ví dụ: <code>Facebook: JBSWY3DPEHPK3PXP</code></li>
                    <li><strong>Đường dẫn QR Code (otpauth link):</strong> Định dạng xuất từ các ứng dụng Authenticator khác. Ví dụ: <code>otpauth://totp/Google:admin?secret=JBSWY3DPEHP...</code></li>
                </ul>
            </div>

            <div class="seo-card">
                <h3>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 1.5rem; height: 1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Xử lý hàng loạt lên đến 500 dòng miễn phí
                </h3>
                <p>Nếu bạn là một nhà tiếp thị số, nhà quản trị hệ thống hoặc người dùng có số lượng lớn tài khoản quảng cáo (Facebook Ads, Google Ads, TikTok Ads):</p>
                <ul>
                    <li><strong>Hiệu suất vượt trội:</strong> Không giống như các trang web khác giới hạn 1 hoặc vài dòng, chúng tôi cung cấp khả năng giải mã lên đến 500 dòng đồng thời.</li>
                    <li><strong>Miễn phí 100%:</strong> Không yêu cầu đăng ký, không có phí ẩn, không quảng cáo che khuất tầm nhìn, giúp bạn tối ưu hóa quy trình làm việc hàng ngày hiệu quả nhất.</li>
                </ul>
            </div>
        </div>

        <!-- FAQ Accordion Section (For AdSense Rich Snippets & Approval) -->
        <div class="faq-section">
            <h3 class="faq-title">Câu hỏi thường gặp (FAQ)</h3>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <button class="faq-question">
                        <span>Thời gian hiệu lực của mã 2FA là bao lâu?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Mã 2FA (TOTP) có hiệu lực trong vòng 30 giây. Sau mỗi 30 giây, một mã bảo mật mới gồm 6 chữ số sẽ được tạo ra để thay thế mã cũ. Vòng tròn đếm ngược trên bảng kết quả của chúng tôi giúp bạn nhận biết thời gian còn lại trước khi mã được tự động cập nhật.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Tại sao tôi nhập khóa bí mật nhưng mã tạo ra bị lỗi hoặc không đăng nhập được?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Lỗi này thường xảy ra do 3 nguyên nhân:
                            <ol>
                                <li>Mã bí mật của bạn bị gõ sai hoặc thiếu ký tự (Mã Base32 hợp lệ chỉ chứa các chữ cái từ A đến Z và chữ số từ 2 đến 7).</li>
                                <li>Thời gian trên hệ điều hành máy tính/điện thoại của bạn đang bị lệch so với múi giờ chuẩn quốc tế. TOTP phụ thuộc hoàn toàn vào thời gian thực tế, do đó hãy đảm bảo thời gian máy tính của bạn đã được cài đặt tự động cập nhật (Sync Time).</li>
                                <li>Mã bí mật đã bị hủy hoặc bị thay thế bằng một khóa mới trên cài đặt tài khoản của bạn.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Tôi có cần phải đăng ký tài khoản để sử dụng 2FA Live không?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Không. Công cụ này hoàn toàn miễn phí và không cần đăng ký tài khoản. Bạn chỉ cần truy cập trang web, dán khóa bí mật và nhận mã ngay lập tức. Toàn bộ tính năng nhập lên tới 500 dòng khóa đều được mở hoàn toàn miễn phí.
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question">
                        <span>Làm cách nào để chuyển đổi từ Google Authenticator sang công cụ này?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            Khi bạn kích hoạt tính năng xác minh 2 bước trên Google, Facebook hay các dịch vụ khác, họ sẽ hiển thị một mã QR kèm theo một chuỗi ký tự chữ và số (Secret Key). Hãy lưu trữ lại chuỗi ký tự này. Bạn chỉ cần dán chuỗi ký tự đó vào ô nhập của chúng tôi để tạo ra mã 2FA tương tự như trên ứng dụng di động.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
