/**
 * Online 2FA Extractor - JavaScript Logic
 * Developed with premium client-side security (Zero Server storage)
 * 100% Free, supports up to 500 lines of 2FA keys
 */

document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const body = document.body;
    const textareaInput = document.getElementById("2fa-input");
    const lineCounter = document.getElementById("line-counter");
    const limitIndicator = document.getElementById("limit-indicator");
    const btnGenerate = document.getElementById("btn-generate");
    const btnClear = document.getElementById("btn-clear");
    const resultsContainer = document.getElementById("results-container");
    const resultsTimerText = document.getElementById("results-timer-text");
    const timerCircle = document.getElementById("timer-circle");
    const resultsDivider = document.getElementById("results-divider");
    const resultsWrapper = document.getElementById("results-wrapper");
    
    // Theme Switcher
    const themeBtn = document.getElementById("theme-switch");
    
    // Info Modals
    const infoModals = {
        about: document.getElementById("modal-about"),
        privacy: document.getElementById("modal-privacy"),
        terms: document.getElementById("modal-terms"),
        contact: document.getElementById("modal-contact")
    };
    const modalCloseButtons = document.querySelectorAll(".btn-modal-close");
    const footerLinks = document.querySelectorAll(".footer-modal-link");
    
    // Contact Form inside Modal
    const contactForm = document.getElementById("form-contact");
    const contactFormContainer = document.getElementById("contact-form-container");
    const contactSuccessState = document.getElementById("contact-success-state");

    // Constants
    const LIMIT = 500; // High capacity limit for free usage
    const TIMER_CIRCLE_CIRCUMFERENCE = 2 * Math.PI * 9; // Radius is 9px inside SVG, circumference is ~56.54px
    
    // State
    let activeSecrets = []; // Array of parsed secrets: { label: '', secret: '', originalIndex: 0 }
    let countdownInterval = null;

    // --- THEME INITIALIZATION ---
    let currentTheme = localStorage.getItem("theme_2fa") || "light";
    body.setAttribute("data-theme", currentTheme);
    
    themeBtn.addEventListener("click", () => {
        if (body.getAttribute("data-theme") === "dark") {
            body.setAttribute("data-theme", "light");
            localStorage.setItem("theme_2fa", "light");
            showToast("Đã chuyển sang Chế độ sáng");
        } else {
            body.setAttribute("data-theme", "dark");
            localStorage.setItem("theme_2fa", "dark");
            showToast("Đã chuyển sang Chế độ tối");
        }
    });

    // --- BASE32 DECODING ---
    function base32ToBytes(base32) {
        const base32chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
        base32 = base32.replace(/=+$/, "").replace(/\s/g, "").toUpperCase();
        
        if (!base32) {
            throw new Error("Mã bảo mật trống");
        }

        const len = base32.length;
        const bytes = new Uint8Array(Math.floor((len * 5) / 8));
        let bits = 0;
        let value = 0;
        let index = 0;

        for (let i = 0; i < len; i++) {
            const val = base32chars.indexOf(base32.charAt(i));
            if (val === -1) {
                throw new Error("Ký tự Base32 không hợp lệ: " + base32.charAt(i));
            }
            value = (value << 5) | val;
            bits += 5;
            if (bits >= 8) {
                bytes[index++] = (value >>> (bits - 8)) & 255;
                bits -= 8;
            }
        }
        return bytes;
    }

    // --- TOTP GENERATOR ---
    async function generateTOTP(secret) {
        try {
            const keyBytes = base32ToBytes(secret);
            const epoch = Math.round(new Date().getTime() / 1000);
            const counter = Math.floor(epoch / 30);
            
            // Convert counter to 8-byte big-endian Uint8Array
            const counterBytes = new Uint8Array(8);
            let temp = counter;
            for (let i = 7; i >= 0; i--) {
                counterBytes[i] = temp & 0xff;
                temp = temp >> 8;
            }

            // Web Crypto HMAC SHA-1
            const cryptoKey = await window.crypto.subtle.importKey(
                "raw",
                keyBytes,
                { name: "HMAC", hash: { name: "SHA-1" } },
                false,
                ["sign"]
            );
            
            const signatureBuffer = await window.crypto.subtle.sign(
                "HMAC",
                cryptoKey,
                counterBytes
            );
            
            const hmac = new Uint8Array(signatureBuffer);
            const offset = hmac[hmac.length - 1] & 0xf;
            const code =
                ((hmac[offset] & 0x7f) << 24) |
                ((hmac[offset + 1] & 0xff) << 16) |
                ((hmac[offset + 2] & 0xff) << 8) |
                (hmac[offset + 3] & 0xff);
                
            const otp = (code % 1000000).toString().padStart(6, "0");
            return { success: true, otp };
        } catch (e) {
            return { success: false, error: e.message };
        }
    }

    // --- TOAST NOTIFICATIONS ---
    function showToast(message, type = "success") {
        let toastContainer = document.querySelector(".toast-container");
        if (!toastContainer) {
            toastContainer = document.createElement("div");
            toastContainer.className = "toast-container";
            body.appendChild(toastContainer);
        }

        const toast = document.createElement("div");
        toast.className = `toast toast-${type}`;
        
        let iconSvg = "";
        if (type === "success") {
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>`;
        } else if (type === "error") {
            iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>`;
        }

        toast.innerHTML = `
            ${iconSvg}
            <span class="toast-message">${message}</span>
        `;

        toastContainer.appendChild(toast);

        // Auto remove
        setTimeout(() => {
            toast.classList.add("toast-out");
            toast.addEventListener("transitionend", () => {
                toast.remove();
                if (toastContainer.children.length === 0) {
                    toastContainer.remove();
                }
            });
        }, 3000);
    }

    // --- PARSE AND FORMAT INPUT ---
    function parseInputLines(text) {
        const lines = text.split("\n");
        const parsed = [];
        
        let validIndex = 1;
        lines.forEach((line) => {
            const trimmed = line.trim();
            if (!trimmed) return;

            if (trimmed.startsWith("otpauth://")) {
                try {
                    const url = new URL(trimmed);
                    const secret = url.searchParams.get("secret");
                    let label = "Mã 2FA";
                    
                    let path = decodeURIComponent(url.pathname);
                    path = path.replace(/^\/+totp\/+/, "").replace(/^\/+/, "");
                    
                    if (path) {
                        label = path;
                    } else {
                        const issuer = url.searchParams.get("issuer");
                        if (issuer) label = issuer;
                    }
                    
                    if (secret) {
                        parsed.push({
                            label: label,
                            secret: secret,
                            originalIndex: validIndex++
                        });
                    }
                } catch (e) {
                    // Fail silently
                }
            } else {
                let label = `Dòng #${validIndex}`;
                let secret = trimmed;

                const delimiters = [":", "|", "="];
                let foundDelimiter = false;

                for (const delim of delimiters) {
                    const idx = trimmed.indexOf(delim);
                    if (idx !== -1) {
                        const part1 = trimmed.substring(0, idx).trim();
                        const part2 = trimmed.substring(idx + 1).trim();
                        
                        if (part2.length >= 8) {
                            label = part1;
                            secret = part2;
                            foundDelimiter = true;
                            break;
                        }
                    }
                }

                if (!foundDelimiter) {
                    const spaceIdx = trimmed.lastIndexOf(" ");
                    if (spaceIdx !== -1) {
                        const part1 = trimmed.substring(0, spaceIdx).trim();
                        const part2 = trimmed.substring(spaceIdx + 1).trim();
                        if (part2.length >= 8 && /^[A-Z2-7=\s]+$/i.test(part2)) {
                            label = part1;
                            secret = part2;
                        }
                    }
                }

                parsed.push({
                    label: label,
                    secret: secret.replace(/\s/g, ""), // strip space
                    originalIndex: validIndex++
                });
            }
        });

        return parsed;
    }

    // --- CHECK LIMIT ON INPUT ---
    function updateLineStatus() {
        const text = textareaInput.value;
        const parsed = parseInputLines(text);
        const count = parsed.length;
        
        lineCounter.textContent = count;
        
        if (count > LIMIT) {
            limitIndicator.textContent = `Vượt quá giới hạn tối đa (${count}/${LIMIT} dòng)`;
            limitIndicator.classList.add("limit-warning");
            btnGenerate.disabled = true;
        } else {
            limitIndicator.textContent = `Hỗ trợ nhập tối đa ${LIMIT} dòng`;
            limitIndicator.classList.remove("limit-warning");
            btnGenerate.disabled = false;
        }
    }

    textareaInput.addEventListener("input", updateLineStatus);

    // --- RENDER RESULTS CARD ---
    async function update2FACodes() {
        if (activeSecrets.length === 0) return;

        const promises = activeSecrets.map(async (item, idx) => {
            const result = await generateTOTP(item.secret);
            const cardEl = document.getElementById(`result-card-${idx}`);
            if (!cardEl) return;

            const codeEl = cardEl.querySelector(".result-code");
            const statusEl = cardEl.querySelector(".result-status");

            if (result.success) {
                codeEl.textContent = result.otp;
                codeEl.classList.remove("code-invalid");
                statusEl.className = "result-status status-valid";
            } else {
                codeEl.textContent = "Lỗi mã khóa";
                codeEl.classList.add("code-invalid");
                statusEl.className = "result-status status-invalid";
                cardEl.title = result.error;
            }
        });

        await Promise.all(promises);
    }

    function renderResultsGrid() {
        if (activeSecrets.length === 0) {
            resultsDivider.style.display = "none";
            resultsWrapper.style.display = "none";
            stopCountdown();
            return;
        }

        resultsDivider.style.display = "block";
        resultsWrapper.style.display = "block";
        resultsContainer.innerHTML = "";
        const grid = document.createElement("div");
        grid.className = "results-grid";

        activeSecrets.forEach((item, idx) => {
            const card = document.createElement("div");
            card.className = "result-card";
            card.id = `result-card-${idx}`;

            const maskedSecret = item.secret.substring(0, 4) + "••••••••" + item.secret.slice(-4);

            card.innerHTML = `
                <div class="result-card-header">
                    <span class="result-label" title="${escapeHtml(item.label)}">${escapeHtml(item.label)}</span>
                    <span class="result-status"></span>
                </div>
                <div class="result-code-container">
                    <span class="result-code code-invalid">Đang tạo...</span>
                    <button class="btn-copy" title="Copy mã 2FA">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 1.1rem; height: 1.1rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                    </button>
                </div>
                <div class="result-secret-area">
                    <span class="result-secret" data-secret="${escapeHtml(item.secret)}" data-revealed="false">${maskedSecret}</span>
                    <button class="btn-toggle-secret" title="Hiện mã bí mật">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 0.9rem; height: 0.9rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            `;

            // Copy button listener
            const copyBtn = card.querySelector(".btn-copy");
            copyBtn.addEventListener("click", () => {
                const codeSpan = card.querySelector(".result-code");
                if (codeSpan.classList.contains("code-invalid")) return;
                
                navigator.clipboard.writeText(codeSpan.textContent);
                showToast(`Đã sao chép mã 2FA của "${item.label}": ${codeSpan.textContent}`);
            });

            // Click code to copy
            const codeSpan = card.querySelector(".result-code");
            codeSpan.addEventListener("click", () => {
                if (codeSpan.classList.contains("code-invalid")) return;
                navigator.clipboard.writeText(codeSpan.textContent);
                showToast(`Đã sao chép mã 2FA: ${codeSpan.textContent}`);
            });

            // Toggle secret visibility
            const toggleSecretBtn = card.querySelector(".btn-toggle-secret");
            const secretSpan = card.querySelector(".result-secret");
            toggleSecretBtn.addEventListener("click", () => {
                const isRevealed = secretSpan.getAttribute("data-revealed") === "true";
                if (isRevealed) {
                    secretSpan.textContent = maskedSecret;
                    secretSpan.setAttribute("data-revealed", "false");
                    toggleSecretBtn.title = "Hiện mã bí mật";
                    toggleSecretBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 0.9rem; height: 0.9rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    `;
                } else {
                    secretSpan.textContent = item.secret;
                    secretSpan.setAttribute("data-revealed", "true");
                    toggleSecretBtn.title = "Ẩn mã bí mật";
                    toggleSecretBtn.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width: 0.9rem; height: 0.9rem;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    `;
                }
            });

            grid.appendChild(card);
        });

        resultsContainer.appendChild(grid);
        
        // Initial build
        update2FACodes();
        startCountdown();
    }

    // --- TIMING AND REFRESH DEVISE ---
    function startCountdown() {
        stopCountdown();
        
        const tick = () => {
            const epoch = Math.round(new Date().getTime() / 1000);
            const remaining = 30 - (epoch % 30);
            
            resultsTimerText.textContent = `${remaining}s`;
            
            // Draw progress circle stroke-dashoffset
            const progressRatio = remaining / 30;
            const offset = TIMER_CIRCLE_CIRCUMFERENCE * (1 - progressRatio);
            timerCircle.style.strokeDashoffset = offset;

            if (remaining === 30 || remaining === 0) {
                update2FACodes();
            }
        };

        tick();
        countdownInterval = setInterval(tick, 1000);
    }

    function stopCountdown() {
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }
        resultsTimerText.textContent = "30s";
        timerCircle.style.strokeDashoffset = 0;
    }

    // --- MAIN BUTTON CLICKS ---
    btnGenerate.addEventListener("click", () => {
        const text = textareaInput.value;
        const parsed = parseInputLines(text);
        const count = parsed.length;

        if (count === 0) {
            showToast("Hãy nhập ít nhất một dòng chứa mã bảo mật 2FA!", "error");
            return;
        }

        if (count > LIMIT) {
            showToast(`Vượt quá giới hạn tối đa cho phép (${count}/${LIMIT} dòng).`, "error");
            return;
        }

        activeSecrets = parsed;
        renderResultsGrid();
        showToast(`Đã sinh thành công ${count} mã 2FA.`);
        
        if (window.innerWidth < 992) {
            document.getElementById("results-section-header").scrollIntoView({ behavior: "smooth" });
        }
    });

    btnClear.addEventListener("click", () => {
        textareaInput.value = "";
        activeSecrets = [];
        updateLineStatus();
        renderResultsGrid();
        showToast("Đã xóa toàn bộ dữ liệu nhập.");
    });

    // --- FAQ ACCORDION ---
    const faqQuestions = document.querySelectorAll(".faq-question");
    faqQuestions.forEach((q) => {
        q.addEventListener("click", () => {
            const item = q.parentElement;
            const isActive = item.classList.contains("active");
            
            document.querySelectorAll(".faq-item").forEach((fi) => {
                fi.classList.remove("active");
                fi.querySelector(".faq-answer").style.maxHeight = null;
            });
            
            if (!isActive) {
                item.classList.add("active");
                const answer = item.querySelector(".faq-answer");
                answer.style.maxHeight = answer.scrollHeight + "px";
            }
        });
    });

    // Contact Form submission via PHP API
    if (contactForm) {
        contactForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const btnSubmit = contactForm.querySelector('button[type="submit"]');
            const oldText = btnSubmit.textContent;
            btnSubmit.disabled = true;
            btnSubmit.textContent = "Đang gửi...";
            
            const formData = new FormData(contactForm);
            const actionUrl = contactForm.getAttribute("action") || "api/contact";
            
            fetch(actionUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    contactFormContainer.style.display = "none";
                    contactSuccessState.style.display = "flex";
                    document.getElementById("contact-success-message").textContent = data.message;
                    showToast("Tin nhắn của bạn đã được gửi thành công!");
                } else {
                    showToast(data.message || "Đã xảy ra lỗi, vui lòng thử lại.", "error");
                    btnSubmit.disabled = false;
                    btnSubmit.textContent = oldText;
                }
            })
            .catch(err => {
                showToast("Không thể gửi tin nhắn. Vui lòng kiểm tra kết nối mạng.", "error");
                btnSubmit.disabled = false;
                btnSubmit.textContent = oldText;
            });
        });
    }

    // Helper functions
    function escapeHtml(str) {
        return str
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
});
