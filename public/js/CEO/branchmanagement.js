/**
 * Simple Branch Management JavaScript
 * Works with unified responsive table design
 */

class BranchManager {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadBranches();
    }

    bindEvents() {
        // Add Branch Buttons
        const addBranchBtnTable = document.getElementById('addBranchBtnTable');
        if (addBranchBtnTable) {
            addBranchBtnTable.addEventListener('click', () => this.showAddModal());
        }

        const addBranchBtnEmpty = document.getElementById('addBranchBtnEmpty');
        if (addBranchBtnEmpty) {
            addBranchBtnEmpty.addEventListener('click', () => this.showAddModal());
        }

        // Form Submits
        const addBranchForm = document.getElementById('addBranchForm');
        if (addBranchForm) {
            addBranchForm.addEventListener('submit', (e) => this.handleAddBranch(e));
        }

        const editBranchForm = document.getElementById('editBranchForm');
        if (editBranchForm) {
            editBranchForm.addEventListener('submit', (e) => this.handleEditBranch(e));
        }

        // Event delegation for table buttons
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-edit') || e.target.closest('.btn-edit')) {
                const button = e.target.classList.contains('btn-edit') ? e.target : e.target.closest('.btn-edit');
                const branchId = button.getAttribute('data-branch-id');
                this.showEditModal(branchId);
            }

            if (e.target.classList.contains('btn-map') || e.target.closest('.btn-map')) {
                const button = e.target.classList.contains('btn-map') ? e.target : e.target.closest('.btn-map');
                const mapSrc = button.getAttribute('data-map-src');
                const branchName = button.getAttribute('data-branch-name');
                this.showMapModal(mapSrc, branchName);
            }

            if (e.target.classList.contains('btn-delete') || e.target.closest('.btn-delete')) {
                const button = e.target.classList.contains('btn-delete') ? e.target : e.target.closest('.btn-delete');
                const branchId = button.getAttribute('data-branch-id');
                const branchName = button.getAttribute('data-branch-name');
                this.confirmDelete(branchId, branchName);
            }

            if (e.target.classList.contains('btn-enable') || e.target.closest('.btn-enable')) {
                const button = e.target.classList.contains('btn-enable') ? e.target : e.target.closest('.btn-enable');
                const branchId = button.getAttribute('data-branch-id');
                const branchName = button.getAttribute('data-branch-name');
                this.confirmToggleStatus(branchId, branchName, true);
            }

            if (e.target.classList.contains('btn-disable') || e.target.closest('.btn-disable')) {
                const button = e.target.classList.contains('btn-disable') ? e.target : e.target.closest('.btn-disable');
                const branchId = button.getAttribute('data-branch-id');
                const branchName = button.getAttribute('data-branch-name');
                this.confirmToggleStatus(branchId, branchName, false);
            }
        });
    }

    async loadBranches() {
        try {
            this.showLoading();
            const response = await fetch('/ceo/branchmanagement');
            if (response.ok) {
                const html = await response.text();
                // Parse the response to extract branch data if needed
                this.hideLoading();
            }
        } catch (error) {
            console.error('Error loading branches:', error);
            this.hideLoading();
            this.showAlert('Error loading branches', 'error');
        }
    }

    showAddModal() {
        console.log('showAddModal called'); // Debug
        const modalElement = document.getElementById('addBranchModal');
        console.log('Modal element found:', modalElement); // Debug

        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            const form = document.getElementById('addBranchForm');
            if (form) {
                form.reset();
            }
            modal.show();
        } else {
            console.error('Add Branch Modal not found!');
        }
    }

    async handleAddBranch(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        try {
            this.showLoading();

            const response = await fetch('/ceo/create-branch', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            this.hideLoading();

            if (result.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addBranchModal'));
                modal.hide();

                this.showAlert(result.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                this.showAlert(result.message, 'error');
            }
        } catch (error) {
            this.hideLoading();
            console.error('Error adding branch:', error);
            this.showAlert('Failed to add branch. Please try again.', 'error');
        }
    }

    async showEditModal(branchId) {
        try {
            // Find the table row with the branch data
            const branchRow = document.querySelector(`tr[data-branch-id="${branchId}"]`);

            if (!branchRow) {
                console.error('Branch row not found for ID:', branchId);
                return;
            }

            // Get data from table row
            const name = branchRow.querySelector('.branch-name').textContent.trim();
            const address = branchRow.querySelector('.branch-address').textContent.trim();
            const isActive = branchRow.querySelector('.status-badge').classList.contains('status-active');

            // Get map source from map button if available
            const mapButton = branchRow.querySelector('.btn-map');
            const mapSrc = mapButton ? mapButton.getAttribute('data-map-src') : '';

            // Fill the edit form
            document.getElementById('editBranchId').value = branchId;
            document.getElementById('editBranchName').value = name;
            document.getElementById('editBranchAddress').value = address;
            document.getElementById('editBranchMapSrc').value = mapSrc || '';
            document.getElementById('editBranchActive').checked = isActive;

            const modalElement = document.getElementById('editBranchModal');
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            } else {
                console.error('Edit Branch Modal not found!');
            }
        } catch (error) {
            console.error('Error showing edit modal:', error);
            this.showAlert('Error loading branch data', 'error');
        }
    }

    showMapModal(mapSrc, branchName) {
        console.log('showMapModal called:', { mapSrc, branchName }); // Debug

        const modalTitle = document.querySelector('#mapModalLabel');
        const mapFrame = document.getElementById('mapFrame');

        if (modalTitle) {
            modalTitle.innerHTML = `<i class="fas fa-map-marker-alt me-2"></i>${branchName} - Location`;
        }

        if (mapFrame && mapSrc) {
            mapFrame.src = mapSrc;
        }

        const modalElement = document.getElementById('mapModal');
        if (modalElement) {
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        } else {
            console.error('Map Modal not found!');
        }
    }

    async handleEditBranch(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const branchId = document.getElementById('editBranchId').value;

        // Add the _method field for Laravel's method spoofing
        formData.append('_method', 'PUT');

        try {
            this.showLoading();

            const response = await fetch(`/ceo/branch-manage/${branchId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            this.hideLoading();

            if (result.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editBranchModal'));
                modal.hide();

                this.showAlert(result.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                this.showAlert(result.message, 'error');
            }
        } catch (error) {
            this.hideLoading();
            console.error('Error updating branch:', error);
            this.showAlert('Failed to update branch. Please try again.', 'error');
        }
    }

    confirmDelete(branchId, branchName) {
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete "${branchName}". This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                this.deleteBranch(branchId);
            }
        });
    }

    async deleteBranch(branchId) {
        try {
            this.showLoading();

            const response = await fetch(`/ceo/branch-manage/${branchId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            this.hideLoading();

            if (result.success) {
                this.showAlert(result.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                this.showAlert(result.message, 'error');
            }
        } catch (error) {
            this.hideLoading();
            console.error('Error deleting branch:', error);
            this.showAlert('Failed to delete branch. Please try again.', 'error');
        }
    }

    confirmToggleStatus(branchId, branchName, enable) {
        const action = enable ? 'enable' : 'disable';
        const actionTitle = enable ? 'Enable Branch' : 'Disable Branch';
        const actionText = enable ?
            `Are you sure you want to enable "${branchName}"?` :
            `Are you sure you want to disable "${branchName}"?`;
        const confirmButtonText = enable ? 'Yes, enable it!' : 'Yes, disable it!';
        const confirmButtonColor = enable ? '#28a745' : '#ffc107';

        Swal.fire({
            title: actionTitle,
            text: actionText,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                this.toggleBranchStatus(branchId, enable);
            }
        });
    }

    async toggleBranchStatus(branchId, enable) {
        try {
            this.showLoading();

            const formData = new FormData();
            formData.append('active', enable ? '1' : '0');
            formData.append('_method', 'PUT');

            const response = await fetch(`/ceo/branch-manage/${branchId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const result = await response.json();

            this.hideLoading();

            if (result.success) {
                this.showAlert(result.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                this.showAlert(result.message, 'error');
            }
        } catch (error) {
            this.hideLoading();
            console.error('Error toggling branch status:', error);
            this.showAlert('Failed to update branch status. Please try again.', 'error');
        }
    }

    showLoading() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.style.display = 'flex';
        }
    }

    hideLoading() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
    }

    showAlert(message, type = 'info') {
        let icon = 'info';
        let confirmButtonColor = '#3085d6';

        switch (type) {
            case 'success':
                icon = 'success';
                confirmButtonColor = '#28a745';
                break;
            case 'error':
                icon = 'error';
                confirmButtonColor = '#dc3545';
                break;
            case 'warning':
                icon = 'warning';
                confirmButtonColor = '#ffc107';
                break;
        }

        Swal.fire({
            title: type.charAt(0).toUpperCase() + type.slice(1),
            text: message,
            icon: icon,
            confirmButtonColor: confirmButtonColor,
            confirmButtonText: 'OK'
        });
    }

    // Utility method to format phone numbers
    formatPhoneNumber(phone) {
        // Remove all non-numeric characters
        const cleaned = phone.replace(/\D/g, '');

        // Format as (XXX) XXX-XXXX if 10 digits
        if (cleaned.length === 10) {
            return `(${cleaned.slice(0, 3)}) ${cleaned.slice(3, 6)}-${cleaned.slice(6)}`;
        }

        return phone; // Return original if not 10 digits
    }

    // Utility method to validate email
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Form validation
    validateForm(formData) {
        const errors = [];

        if (!formData.get('name') || formData.get('name').trim().length < 2) {
            errors.push('Branch name must be at least 2 characters long');
        }

        if (!formData.get('address') || formData.get('address').trim().length < 5) {
            errors.push('Address must be at least 5 characters long');
        }

        return errors;
    }

    // Setup mobile card interactions
    setupMobileCardInteractions() {
        const branchCards = document.querySelectorAll('.branch-card:not(.add-branch-card)');

        branchCards.forEach(card => {
            // Add touch-friendly interactions
            card.addEventListener('touchstart', this.addRippleEffect.bind(this));

            // Add hover effect for mouse users
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-4px)';
                card.style.boxShadow = '0 12px 24px rgba(0, 123, 255, 0.2)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(-2px)';
                card.style.boxShadow = '0 8px 20px rgba(0, 123, 255, 0.15)';
            });
        });
    }

    // Add ripple effect for touch interactions
    addRippleEffect(e) {
        const card = e.currentTarget;
        const ripple = document.createElement('span');
        const rect = card.getBoundingClientRect();
        const size = 60;

        let x, y;
        if (e.touches && e.touches[0]) {
            x = e.touches[0].clientX - rect.left - size / 2;
            y = e.touches[0].clientY - rect.top - size / 2;
        } else {
            x = e.clientX - rect.left - size / 2;
            y = e.clientY - rect.top - size / 2;
        }

        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');

        // Add ripple styles
        Object.assign(ripple.style, {
            position: 'absolute',
            borderRadius: '50%',
            background: 'rgba(0, 123, 255, 0.3)',
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

    // Enhanced mobile error handling
    showMobileErrorMessage(message) {
        const toast = document.createElement('div');
        toast.className = 'mobile-toast mobile-toast-error';
        toast.innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            <span>${message}</span>
        `;

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

        setTimeout(() => {
            toast.style.transform = 'translateX(-50%) translateY(0)';
        }, 10);

        setTimeout(() => {
            toast.style.transform = 'translateX(-50%) translateY(-100px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Enhanced mobile success message
    showMobileSuccessMessage(message) {
        const toast = document.createElement('div');
        toast.className = 'mobile-toast mobile-toast-success';
        toast.innerHTML = `
            <i class="fas fa-check-circle"></i>
            <span>${message}</span>
        `;

        Object.assign(toast.style, {
            position: 'fixed',
            top: '20px',
            left: '50%',
            transform: 'translateX(-50%)',
            background: '#28a745',
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

        setTimeout(() => {
            toast.style.transform = 'translateX(-50%) translateY(0)';
        }, 10);

        setTimeout(() => {
            toast.style.transform = 'translateX(-50%) translateY(-100px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Check if user is on mobile device
    isMobileDevice() {
        return window.innerWidth <= 1024;
    }
}

// Initialize the branch manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new BranchManager();

    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .mobile-toast {
            transition: all 0.3s ease;
        }

        .branch-card {
            transition: all 0.3s ease;
        }

        .add-branch-card {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);
});

// Export for use in other scripts if needed
window.BranchManager = BranchManager;
