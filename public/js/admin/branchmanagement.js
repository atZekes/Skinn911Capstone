/**
 * Admin Branch Management JavaScript
 * Extracted from branchmanagement.blade.php
 */

class BranchManagement {
    constructor() {
        this.selectedServices = new Map();
        this.init();
    }

    init() {
        this.bindEvents();
        this.initCategoryFilters();
    }

    bindEvents() {
        // Package service selection and quantity handling
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('newpkg-svc-checkbox')) {
                this.handleServiceSelection(e.target);
            }

            if (e.target.classList.contains('newpkg-svc-qty')) {
                this.handleQuantityChange(e.target);
            }
        });

        // Category filter change
        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('category-filter')) {
                this.handleCategoryFilter(e.target);
            }
        });

        // Package creation form submission
        document.addEventListener('submit', (e) => {
            if (e.target.id === 'createPackageForm') {
                this.handlePackageSubmission(e);
            }
        });
    }

    handleServiceSelection(checkbox) {
        const serviceId = checkbox.value;
        const isChecked = checkbox.checked;
        const qtyInput = document.querySelector(`input[name="service_quantities[${serviceId}]"]`);

        if (isChecked) {
            // Service is selected
            if (qtyInput) {
                qtyInput.disabled = false;
                qtyInput.value = qtyInput.value || 1; // Default to 1 if empty
                this.selectedServices.set(serviceId, parseInt(qtyInput.value));
            }
        } else {
            // Service is deselected
            if (qtyInput) {
                qtyInput.disabled = true;
                qtyInput.value = '';
                this.selectedServices.delete(serviceId);
            }
        }

        this.updatePackageDuration();
    }

    handleQuantityChange(qtyInput) {
        const serviceId = qtyInput.name.match(/\[(\d+)\]/)[1];
        const quantity = parseInt(qtyInput.value) || 0;

        if (quantity > 0) {
            this.selectedServices.set(serviceId, quantity);
        } else {
            this.selectedServices.delete(serviceId);
        }

        this.updatePackageDuration();
    }

    updatePackageDuration() {
        let totalDuration = 0;

        // Iterate through selected services and calculate total duration
        this.selectedServices.forEach((quantity, serviceId) => {
            const checkbox = document.querySelector(`input[value="${serviceId}"].newpkg-svc-checkbox`);
            if (checkbox && checkbox.checked) {
                const serviceRow = checkbox.closest('tr');
                const durationCell = serviceRow ? serviceRow.querySelector('td:nth-child(3)') : null;

                if (durationCell) {
                    const duration = parseInt(durationCell.textContent) || 0;
                    totalDuration += duration * quantity;
                }
            }
        });

        // Update the duration display
        const durationDisplay = document.getElementById('package-duration-display');
        if (durationDisplay) {
            durationDisplay.textContent = `${totalDuration} minutes`;
        }

        // Update hidden input if exists
        const durationInput = document.querySelector('input[name="duration"]');
        if (durationInput) {
            durationInput.value = totalDuration;
        }
    }

    handleCategoryFilter(selectElement) {
        const selectedCategory = selectElement.value;
        const branchId = selectElement.dataset.branchId;
        const serviceTableBody = document.querySelector(`#services-table-${branchId} tbody`);

        if (!serviceTableBody) return;

        const rows = serviceTableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const categoryCell = row.querySelector('td:nth-child(2)'); // Category is in 2nd column

            if (!categoryCell) return;

            const rowCategory = categoryCell.textContent.trim();

            if (selectedCategory === '' || rowCategory === selectedCategory) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    initCategoryFilters() {
        // Initialize category filters for all branch service tables
        const categoryFilters = document.querySelectorAll('.category-filter');

        categoryFilters.forEach(filter => {
            // Set up initial state
            this.handleCategoryFilter(filter);
        });
    }

    handlePackageSubmission(form) {
        // Ensure all selected services are properly included
        const checkedServices = form.querySelectorAll('.newpkg-svc-checkbox:checked');

        if (checkedServices.length === 0) {
            alert('Please select at least one service for the package.');
            return false;
        }

        // Validate quantities
        let hasValidQuantities = true;
        checkedServices.forEach(checkbox => {
            const serviceId = checkbox.value;
            const qtyInput = form.querySelector(`input[name="service_quantities[${serviceId}]"]`);

            if (!qtyInput || !qtyInput.value || parseInt(qtyInput.value) < 1) {
                hasValidQuantities = false;
            }
        });

        if (!hasValidQuantities) {
            alert('Please ensure all selected services have valid quantities (minimum 1).');
            return false;
        }

        return true;
    }

    // Utility method to refresh service data if needed
    refreshServiceData(branchId) {
        // This can be extended to fetch updated service data via AJAX
        console.log(`Refreshing service data for branch ${branchId}`);
    }

    // Method to reset package form
    resetPackageForm(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.reset();
            this.selectedServices.clear();

            // Reset all quantity inputs
            const qtyInputs = form.querySelectorAll('.newpkg-svc-qty');
            qtyInputs.forEach(input => {
                input.disabled = true;
                input.value = '';
            });

            // Update duration display
            this.updatePackageDuration();
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new BranchManagement();
});

// Expose for external access if needed
window.BranchManagement = BranchManagement;
