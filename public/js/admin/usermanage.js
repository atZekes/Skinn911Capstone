/**
 * Admin User Management JavaScript
 * Extracted from Usermanage.blade.php
 */

class UserManager {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.initTempPasswordHandlers();
            this.initToggleActiveHandlers();
        });
    }

    // Clipboard functionality
    fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            document.execCommand('copy');
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }

        document.body.removeChild(textArea);
    }

    copyText(text) {
        if (!text) return;

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).catch(() => {
                this.fallbackCopyTextToClipboard(text);
            });
        } else {
            this.fallbackCopyTextToClipboard(text);
        }
    }

    // Initialize temporary password handlers
    initTempPasswordHandlers() {
        // Get session data from meta tags or data attributes
        const sessionWho = document.querySelector('meta[name="temp-password-for"]')?.getAttribute('content');
        const sessionTemp = document.querySelector('meta[name="temp-password"]')?.getAttribute('content');

        // Handle temp password modals
        document.querySelectorAll('[data-bs-target*="viewTempModal"]').forEach(btn => {
            const modalId = btn.getAttribute('data-bs-target');
            const userId = modalId.replace('#viewTempModal', '');

            const display = document.getElementById(`tempPasswordDisplay${userId}`);
            const copyBtn = document.getElementById(`copyTempBtn${userId}`);
            const indicator = btn.querySelector('.temp-indicator');

            btn.addEventListener('click', () => {
                if (sessionWho == userId && sessionTemp) {
                    if (display) display.textContent = sessionTemp;
                    if (copyBtn) copyBtn.style.display = 'inline-block';
                    if (indicator) indicator.style.display = 'none';
                } else {
                    if (display) display.textContent = 'No temporary password generated for this user.';
                    if (copyBtn) copyBtn.style.display = 'none';
                }
            });

            if (copyBtn && display) {
                copyBtn.addEventListener('click', () => {
                    this.copyText(display.textContent);
                    if (indicator) indicator.style.display = 'none';
                });
            }
        });
    }

    // Initialize toggle active/inactive handlers
    initToggleActiveHandlers() {
        document.querySelectorAll('.toggle-active-form').forEach(form => {
            form.addEventListener('submit', (e) => {
                const button = form.querySelector('button[type=submit]');
                const action = button ? button.textContent.trim() : 'Toggle';
                const confirmMsg = action === 'Deactivate'
                    ? 'Are you sure you want to deactivate this staff account?'
                    : 'Are you sure you want to activate this staff account?';

                if (!confirm(confirmMsg)) {
                    e.preventDefault();
                }
            });
        });
    }

    // Helper method to set session data for temp passwords
    setSessionData(tempPasswordFor, tempPassword) {
        // Create or update meta tags for session data
        let metaFor = document.querySelector('meta[name="temp-password-for"]');
        if (!metaFor) {
            metaFor = document.createElement('meta');
            metaFor.setAttribute('name', 'temp-password-for');
            document.head.appendChild(metaFor);
        }
        metaFor.setAttribute('content', tempPasswordFor);

        let metaTemp = document.querySelector('meta[name="temp-password"]');
        if (!metaTemp) {
            metaTemp = document.createElement('meta');
            metaTemp.setAttribute('name', 'temp-password');
            document.head.appendChild(metaTemp);
        }
        metaTemp.setAttribute('content', tempPassword);
    }
}

// Initialize when DOM is loaded
new UserManager();
