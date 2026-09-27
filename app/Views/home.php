<main class="container">
    
    <!-- Combined Single Card Tool -->
    <div class="card main-tool-card">
        <div class="card-title-area">
            <h2>Công cụ lấy mã 2FA hàng loạt</h2>
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
</main>
