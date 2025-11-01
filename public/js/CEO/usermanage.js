/**
 * CEO User Management JavaScript
 * Enhanced mobile and tablet interactions
 */

class CEOUserManagement {
    constructor() {
        this.init();
    }

    init() {
        this.setupMobileInteractions();
        this.setupStaffToggleAnimations();
        this.setupFormValidation();
        this.setupSearchAndFilter();
    }

    setupMobileInteractions() {
        // Add touch-friendly interactions for mobile cards
        const userCards = document.querySelectorAll('.user-card');

        userCards.forEach(card => {
            // Add ripple effect on touch
            card.addEventListener('touchstart', this.addRippleEffect.bind(this));

            // Add hover effect for mouse users
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
                card.style.boxShadow = '0 12px 24px rgba(231, 84, 128, 0.2)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(-2px)';
                card.style.boxShadow = '0 8px 20px rgba(231, 84, 128, 0.15)';
            });
        });
    }

    setupStaffToggleAnimations() {
        // Enhanced animations for staff section toggles
        const staffToggles = document.querySelectorAll('.staff-toggle');

        staffToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                const target = document.querySelector(toggle.getAttribute('data-bs-target'));
                const icon = toggle.querySelector('.fa-chevron-down');

                // Animate the chevron icon
                if (toggle.getAttribute('aria-expanded') === 'true') {
                    icon.style.transform = 'rotate(0deg)';
                    toggle.style.background = 'linear-gradient(135deg, #e75480, #d13c6a)';
                } else {
                    icon.style.transform = 'rotate(180deg)';
                    toggle.style.background = 'linear-gradient(135deg, #d13c6a, #b8325a)';
                }

                // Add loading animation
                this.showLoadingState(toggle);
                setTimeout(() => this.hideLoadingState(toggle), 300);
            });
        });
    }

    setupFormValidation() {
        // Enhanced form validation with better mobile feedback
        const forms = document.querySelectorAll('form');

        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                    this.showMobileErrorMessage('Please fill in all required fields correctly.');
                }
            });
        });
    }

    setupSearchAndFilter() {
        // Enhanced search and filter functionality
        const filterForm = document.querySelector('.filter-form form');
        const branchSelect = document.getElementById('branch_id');

        if (branchSelect) {
            branchSelect.addEventListener('change', () => {
                // Auto-submit on mobile for better UX
                if (window.innerWidth <= 768) {
                    setTimeout(() => {
                        filterForm.submit();
                    }, 100);
                }
            });
        }
    }

    addRippleEffect(e) {
        const card = e.currentTarget;
        const ripple = document.createElement('span');
        const rect = card.getBoundingClientRect();
        const size = 60;
        const x = e.touches[0].clientX - rect.left - size / 2;
        const y = e.touches[0].clientY - rect.top - size / 2;

        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');

        // Add ripple styles
        Object.assign(ripple.style, {
            position: 'absolute',
            borderRadius: '50%',
            background: 'rgba(231, 84, 128, 0.3)',
            transform: 'scale(0)',
            animation: 'ripple 0.6s linear',
            pointerEvents: 'none'
        });

        card.style.position = 'relative';
        card.style.overflow = 'hidden';
        card.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    showLoadingState(button) {
        const originalText = button.innerHTML;
        button.dataset.originalText = originalText;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        button.disabled = true;
    }

    hideLoadingState(button) {
        button.innerHTML = button.dataset.originalText;
        button.disabled = false;
    }

    validateForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                this.highlightErrorField(field);
            } else {
                this.clearErrorField(field);
            }
        });

        return isValid;
    }

    highlightErrorField(field) {
        field.style.borderColor = '#dc3545';
        field.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';

        // Add shake animation
        field.style.animation = 'shake 0.5s ease-in-out';
        setTimeout(() => {
            field.style.animation = '';
        }, 500);
    }

    clearErrorField(field) {
        field.style.borderColor = '#e75480';
        field.style.boxShadow = '0 0 0 0.2rem rgba(231, 84, 128, 0.25)';
    }

    showMobileErrorMessage(message) {
        // Create mobile-friendly error toast
        const toast = document.createElement('div');
        toast.className = 'mobile-toast mobile-toast-error';
        toast.innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            <span>${message}</span>
        `;

        // Add toast styles
        Object.assign(toast.style, {
            position: 'fixed',
            top: '20px',
            left: '50%',
            transform: 'translateX(-50%)',
            background: '#dc3545',
            color: 'white',
            padding: '12px 20px',
            borderRadius: '25px',
            boxShadow: '0 4px 12px rgba(0,0,0,0.3)',
            zIndex: '9999',
            fontSize: '0.9rem',
            fontWeight: '600',
            maxWidth: '90vw',
            textAlign: 'center'
        });

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(-50%) translateY(0)';
        }, 10);

        // Remove after 3 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(-50%) translateY(-100px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Utility method to check if user is on mobile device
    isMobileDevice() {
        return window.innerWidth <= 768;
    }

    // Method to refresh mobile layout on orientation change
    handleOrientationChange() {
        setTimeout(() => {
            // Recalculate layout after orientation change
            window.dispatchEvent(new Event('resize'));
        }, 100);
    }
}

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    .mobile-toast {
        transition: all 0.3s ease;
    }
`;
document.head.appendChild(style);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const userManagement = new CEOUserManagement();

    // Handle orientation changes
    window.addEventListener('orientationchange', () => {
        userManagement.handleOrientationChange();
    });
});

// Export for external use
window.CEOUserManagement = CEOUserManagement;
