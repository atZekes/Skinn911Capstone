// Branch Management JavaScript - Simple Version
// This file handles creating, editing, and managing branches

// Get the security token from the page
const securityToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Variables to prevent double-clicking the submit button
let isCreatingBranch = false;

// Function to show success or error messages
function showMessage(message, isSuccess) {
    const title = isSuccess ? 'Success!' : 'Error!';
    const icon = isSuccess ? 'success' : 'error';

    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        timer: 3000,
        showConfirmButton: false
    });
}

// Function to show/hide the loading spinner
function showLoading() {
    const loader = document.querySelector('.loading-overlay');
    if (loader) {
        loader.style.display = 'flex';
    }
}

function hideLoading() {
    const loader = document.querySelector('.loading-overlay');
    if (loader) {
        loader.style.display = 'none';
    }
}

// Function to clean up modal backgrounds when they close
function cleanupModalBackgrounds() {
    // Find all gray backgrounds left behind
    const backgrounds = document.querySelectorAll('.modal-backdrop');

    // Remove each background
    for (let i = 0; i < backgrounds.length; i++) {
        backgrounds[i].remove();
    }

    // Reset the page body styles
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
}

// Function to open the "Add New Branch" popup
function openAddBranchPopup() {
    // Reset the prevention flag
    isCreatingBranch = false;

    // Clear the form
    const form = document.getElementById('addBranchForm');
    if (form) {
        form.reset();
    }

    // Show the popup
    const popup = new bootstrap.Modal(document.getElementById('addBranchModal'));
    popup.show();
}

// Function to handle creating a new branch
function createNewBranch(event) {
    // Stop the form from submitting normally
    event.preventDefault();
    event.stopImmediatePropagation(); // Prevent other listeners from firing

    // Check if we're already creating a branch (prevent double-click)
    if (isCreatingBranch) {
        console.log('Already creating a branch, please wait...');
        return false;
    }

    // Set flag to prevent double submission
    isCreatingBranch = true;

    // Get the submit button and disable it immediately
    const submitButton = event.target.querySelector('button[type="submit"]');
    if (!submitButton) {
        console.error('Submit button not found');
        isCreatingBranch = false;
        return false;
    }
    
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
    
    // Also disable the form to prevent any other submission attempts
    const form = event.target;
    form.style.pointerEvents = 'none';
    form.style.opacity = '0.6';

    // Get all the form data
    const formData = new FormData(event.target);

    // Show loading spinner
    showLoading();

    // Send data to server
    fetch('/ceo/create-branch', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': securityToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(result) {
        // Hide loading spinner
        hideLoading();

        // Reset the flag
        isCreatingBranch = false;

        if (result.success) {
            // Close the popup
            const popup = bootstrap.Modal.getInstance(document.getElementById('addBranchModal'));
            popup.hide();

            // Show success message
            showMessage(result.message, true);

            // Refresh the page after 1.5 seconds
            setTimeout(function() {
                window.location.reload();
            }, 1500);
        } else {
            // Show error message
            showMessage(result.message, false);

            // Re-enable the form and button
            const form = document.getElementById('addBranchForm');
            form.style.pointerEvents = '';
            form.style.opacity = '';
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-save me-2"></i>Add Branch';
        }
    })
    .catch(function(error) {
        // Hide loading spinner
        hideLoading();

        // Reset the flag
        isCreatingBranch = false;

        // Show error message
        showMessage('Failed to create branch. Please try again.', false);

        // Re-enable the form and button
        const form = document.getElementById('addBranchForm');
        form.style.pointerEvents = '';
        form.style.opacity = '';
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="fas fa-save me-2"></i>Add Branch';
    });
}

// Function to open the "Edit Branch" popup
function openEditBranchPopup(branchId) {
    // Find the branch data on the page
    let branchRow = document.querySelector('tr[data-branch-id="' + branchId + '"]');
    let branchName, branchAddress, isActive, mapSource, contactNumber, telephoneNumber, operatingDays;

    if (branchRow) {
        // Get data from desktop table
        branchName = branchRow.querySelector('.branch-name').textContent.trim();
        branchAddress = branchRow.querySelector('.branch-address').textContent.trim();
        isActive = branchRow.querySelector('.status-badge').classList.contains('status-active');

        const mapButton = branchRow.querySelector('.btn-map');
        mapSource = mapButton ? mapButton.getAttribute('data-map-src') : '';

        const editButton = branchRow.querySelector('.btn-edit');
        contactNumber = editButton ? editButton.getAttribute('data-contact-number') : '';
        telephoneNumber = editButton ? editButton.getAttribute('data-telephone-number') : '';
        operatingDays = editButton ? editButton.getAttribute('data-operating-days') : '';
    } else {
        // Get data from mobile card
        const branchCard = document.querySelector('.branch-card[data-branch-id="' + branchId + '"]');
        if (!branchCard) {
            showMessage('Branch data not found.', false);
            return;
        }

        branchName = branchCard.querySelector('.branch-name').textContent.trim();
        const addressElement = branchCard.querySelector('.branch-address');
        branchAddress = addressElement ? addressElement.textContent.trim() : '';
        isActive = branchCard.querySelector('.branch-status-badge').classList.contains('active');

        const mapButton = branchCard.querySelector('.btn-map');
        mapSource = mapButton ? mapButton.getAttribute('data-map-src') : '';

        const editButton = branchCard.querySelector('.btn-edit');
        contactNumber = editButton ? editButton.getAttribute('data-contact-number') : '';
        telephoneNumber = editButton ? editButton.getAttribute('data-telephone-number') : '';
        operatingDays = editButton ? editButton.getAttribute('data-operating-days') : '';
    }

    // Fill the edit form with current data
    document.getElementById('editBranchId').value = branchId;
    document.getElementById('editBranchName').value = branchName;
    document.getElementById('editBranchAddress').value = branchAddress;
    document.getElementById('editBranchMapSrc').value = mapSource;
    document.getElementById('editBranchContactNumber').value = contactNumber || '';
    document.getElementById('editBranchTelephoneNumber').value = telephoneNumber || '';
    document.getElementById('editBranchActive').checked = isActive;

    // Set operating days checkboxes
    const operatingDaysArray = operatingDays ? operatingDays.split(',') : [];
    const dayCheckboxes = document.querySelectorAll('input[name="operating_days[]"]');
    dayCheckboxes.forEach(checkbox => {
        checkbox.checked = operatingDaysArray.includes(checkbox.value);
    });

    // Show the popup
    const popup = new bootstrap.Modal(document.getElementById('editBranchModal'));
    popup.show();
}

// Function to handle editing a branch
function editBranch(event) {
    // Stop the form from submitting normally
    event.preventDefault();

    // Get form data and branch ID
    const formData = new FormData(event.target);
    const branchId = document.getElementById('editBranchId').value;
    formData.append('_method', 'PUT');

    // Debug: Log form data
    console.log('CEO Branch Update - Form Data:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    console.log('Branch ID:', branchId);

    // Show loading spinner
    showLoading();

    // Send data to server
    fetch('/ceo/branch-manage/' + branchId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': securityToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(function(response) {
        console.log('CEO Branch Update - Response status:', response.status);
        if (!response.ok) {
            throw new Error('HTTP ' + response.status + ': ' + response.statusText);
        }
        return response.json();
    })
    .then(function(result) {
        console.log('CEO Branch Update - Result:', result);
        // Hide loading spinner
        hideLoading();

        if (result.success) {
            // Close the popup
            const popup = bootstrap.Modal.getInstance(document.getElementById('editBranchModal'));
            popup.hide();

            // Show success message
            showMessage(result.message, true);

            // Refresh the page
            setTimeout(function() {
                window.location.reload();
            }, 1500);
        } else {
            showMessage(result.message || 'Update failed. Please try again.', false);
        }
    })
    .catch(function(error) {
        console.error('CEO Branch Update - Error:', error);
        hideLoading();
        showMessage('Failed to update branch: ' + error.message, false);
    });
}

// Function to ask user if they want to delete a branch
function askToDeleteBranch(branchId, branchName) {
    Swal.fire({
        title: 'Delete Branch?',
        text: 'Are you sure you want to delete ' + branchName + '? This cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then(function(result) {
        if (result.isConfirmed) {
            deleteBranch(branchId);
        }
    });
}

// Function to delete a branch
function deleteBranch(branchId) {
    showLoading();

    fetch('/ceo/branch-manage/' + branchId, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': securityToken,
            'Accept': 'application/json'
        }
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(result) {
        hideLoading();

        if (result.success) {
            showMessage(result.message, true);
            setTimeout(function() {
                window.location.reload();
            }, 1500);
        } else {
            showMessage(result.message, false);
        }
    })
    .catch(function(error) {
        hideLoading();
        showMessage('Failed to delete branch. Please try again.', false);
    });
}

// Function to ask user if they want to enable/disable a branch
function askToToggleBranchStatus(branchId, branchName, shouldEnable) {
    const action = shouldEnable ? 'enable' : 'disable';
    const title = shouldEnable ? 'Enable Branch?' : 'Disable Branch?';
    const message = 'Are you sure you want to ' + action + ' ' + branchName + '?';

    Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: shouldEnable ? '#28a745' : '#ffc107',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, ' + action + ' it!'
    }).then(function(result) {
        if (result.isConfirmed) {
            toggleBranchStatus(branchId, shouldEnable);
        }
    });
}

// Function to enable or disable a branch
function toggleBranchStatus(branchId, shouldEnable) {
    showLoading();

    // Create form data
    const formData = new FormData();
    formData.append('active', shouldEnable ? '1' : '0');
    formData.append('_method', 'PUT');

    fetch('/ceo/branch-manage/' + branchId, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': securityToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(result) {
        hideLoading();

        if (result.success) {
            showMessage(result.message, true);
            setTimeout(function() {
                window.location.reload();
            }, 1500);
        } else {
            showMessage(result.message, false);
        }
    })
    .catch(function(error) {
        hideLoading();
        showMessage('Failed to update branch status. Please try again.', false);
    });
}

// Function to show map in popup
function showMapPopup(mapSource, branchName) {
    // Check if map source exists
    if (!mapSource || mapSource.trim() === '') {
        showMessage('No map available for this branch.', false);
        return;
    }

    // Set popup title
    document.getElementById('mapModalLabel').innerHTML =
        '<i class="fas fa-map-marker-alt me-2"></i>' + branchName + ' - Location';

    // Get the map frame and clear it first
    const mapFrame = document.getElementById('mapFrame');
    mapFrame.src = '';

    // Show the popup
    const popup = new bootstrap.Modal(document.getElementById('mapModal'));
    popup.show();

    // Load the map after popup is shown
    setTimeout(function() {
        mapFrame.src = mapSource;
    }, 500);
}

// Function to clear the map when popup closes
function clearMap() {
    const mapFrame = document.getElementById('mapFrame');
    if (mapFrame) {
        mapFrame.src = '';
    }
}

// When the page loads, set up all the event listeners
document.addEventListener('DOMContentLoaded', function() {

    // Set up "Add Branch" buttons
    const addBranchButtons = [
        'addBranchBtnTable',
        'addBranchBtnEmpty',
        'addBranchBtnEmptyMobile',
        'addBranchCardMobile'
    ];

    for (let i = 0; i < addBranchButtons.length; i++) {
        const button = document.getElementById(addBranchButtons[i]);
        if (button) {
            button.addEventListener('click', openAddBranchPopup);
        }
    }

    // Set up form submissions
    const addForm = document.getElementById('addBranchForm');
    if (addForm) {
        addForm.addEventListener('submit', createNewBranch);
    }

    const editForm = document.getElementById('editBranchForm');
    if (editForm) {
        editForm.addEventListener('submit', editBranch);
    }

    // Set up button clicks for edit/delete/enable/disable/map
    document.addEventListener('click', function(event) {
        const button = event.target.closest('button');
        if (!button) return;

        const branchId = button.getAttribute('data-branch-id');
        if (!branchId) return;

        const branchName = button.getAttribute('data-branch-name');

        // Check which type of button was clicked
        if (button.classList.contains('btn-edit')) {
            openEditBranchPopup(branchId);
        } else if (button.classList.contains('btn-map')) {
            const mapSource = button.getAttribute('data-map-src');
            showMapPopup(mapSource, branchName);
        } else if (button.classList.contains('btn-delete')) {
            askToDeleteBranch(branchId, branchName);
        } else if (button.classList.contains('btn-enable')) {
            askToToggleBranchStatus(branchId, branchName, true);
        } else if (button.classList.contains('btn-disable')) {
            askToToggleBranchStatus(branchId, branchName, false);
        }
    });

    // Set up popup cleanup when they close
    const popups = ['addBranchModal', 'editBranchModal', 'mapModal'];

    for (let i = 0; i < popups.length; i++) {
        const popup = document.getElementById(popups[i]);
        if (popup) {
            // When popup closes completely
            popup.addEventListener('hidden.bs.modal', function() {
                cleanupModalBackgrounds();
                if (popups[i] === 'mapModal') {
                    clearMap();
                }
            });

            // When close buttons are clicked
            const closeButtons = popup.querySelectorAll('[data-bs-dismiss="modal"]');
            for (let j = 0; j < closeButtons.length; j++) {
                closeButtons[j].addEventListener('click', function() {
                    setTimeout(cleanupModalBackgrounds, 100);
                });
            }
        }
    }

    // Clean up any leftover backgrounds when page loads
    cleanupModalBackgrounds();
});
