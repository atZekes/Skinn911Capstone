<!-- Refund Policy Modal -->
<div class="modal fade" id="refundPolicyModal" tabindex="-1" aria-labelledby="refundPolicyModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #F56289 0%, #e75480 100%); color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold" id="refundPolicyModalLabel">
                    <i class="fas fa-file-contract me-2"></i>Refund & Cancellation Policy
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="display: none;"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <div class="alert alert-info mb-4" style="border-left: 4px solid #F56289; background: rgba(245, 98, 137, 0.05); border-radius: 8px;">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Important:</strong> Please carefully read our refund policy before proceeding with your payment.
                </div>

                <div class="policy-content mb-4">
                    <h6 class="fw-bold mb-3" style="color: #F56289;">
                        <i class="fas fa-shield-alt me-2"></i>Booking Cancellation & Refund Terms
                    </h6>

                    <div class="policy-section mb-4">
                        <h6 class="fw-semibold mb-2" style="color: #333;">
                            <i class="fas fa-calendar-times me-2" style="color: #F56289;"></i>Cancellation Window
                        </h6>
                        <ul class="list-unstyled ms-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Cancellations made <strong>24 hours or more</strong> before your appointment are eligible for a <strong>full refund</strong>.</li>
                            <li class="mb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Cancellations made <strong>less than 24 hours</strong> before your appointment will incur a <strong>50% cancellation fee</strong>.</li>
                            <li class="mb-2"><i class="fas fa-ban text-danger me-2"></i><strong>No-shows</strong> or same-day cancellations are <strong>non-refundable</strong>.</li>
                        </ul>
                    </div>

                    <div class="policy-section mb-4">
                        <h6 class="fw-semibold mb-2" style="color: #333;">
                            <i class="fas fa-credit-card me-2" style="color: #F56289;"></i>Payment Methods & Refund Processing
                        </h6>
                        <ul class="list-unstyled ms-4">
                            <li class="mb-2"><i class="fas fa-mobile-alt text-primary me-2"></i><strong>GCash Payments:</strong> Refunds will be processed back to your GCash account within <strong>3-5 business days</strong>.</li>
                            <li class="mb-2"><i class="fas fa-credit-card text-info me-2"></i><strong>Credit/Debit Card Payments:</strong> Refunds will appear on your card statement within <strong>5-10 business days</strong>, depending on your bank.</li>
                            <li class="mb-2"><i class="fas fa-money-bill-wave text-success me-2"></i><strong>Cash Payments:</strong> Refunds for walk-in bookings will be processed as <strong>store credit</strong> or <strong>cash refund</strong> upon request at the branch.</li>
                        </ul>
                    </div>

                    <div class="policy-section mb-4">
                        <h6 class="fw-semibold mb-2" style="color: #333;">
                            <i class="fas fa-exclamation-circle me-2" style="color: #F56289;"></i>Important Notes
                        </h6>
                        <ul class="list-unstyled ms-4">
                            <li class="mb-2"><i class="fas fa-hourglass-half text-secondary me-2"></i>Refund processing times may vary depending on your payment provider.</li>
                            <li class="mb-2"><i class="fas fa-envelope text-info me-2"></i>You will receive an email confirmation once your refund has been initiated.</li>
                            <li class="mb-2"><i class="fas fa-phone-alt text-success me-2"></i>For refund inquiries, please contact our support team at <strong>{{ config('mail.from.address') }}</strong>.</li>
                        </ul>
                    </div>

                    <div class="alert alert-warning" style="background: rgba(255, 193, 7, 0.1); border-left: 4px solid #ffc107; border-radius: 8px;">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Pro Tip:</strong> We recommend booking in advance and reviewing your appointment details carefully to avoid cancellation fees.
                    </div>
                </div>

                <!-- Agreement Checkboxes -->
                <div class="agreement-section">
                    <div class="form-check mb-3 p-3" style="background: rgba(245, 98, 137, 0.05); border-radius: 8px; border: 1px solid rgba(245, 98, 137, 0.2);">
                        <input class="form-check-input" type="checkbox" id="agreeRefundPolicy" required style="cursor: pointer; width: 18px; height: 18px;">
                        <label class="form-check-label ms-2" for="agreeRefundPolicy" style="cursor: pointer; user-select: none;">
                            <strong>I have read and agree to the Refund & Cancellation Policy</strong>
                        </label>
                    </div>

                </div>

                <div id="agreementError" class="alert alert-danger mt-3" style="display: none; border-radius: 8px;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Please agree to the Refund & Cancellation Policy to proceed.</strong>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #eee; padding: 20px 30px;">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal" style="border-radius: 8px;">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn px-4" id="confirmRefundPolicy" style="background: linear-gradient(135deg, #F56289 0%, #e75480 100%); color: white; border: none; border-radius: 8px;">
                    <i class="fas fa-check me-2"></i>I Agree & Continue
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const refundPolicyModal = new bootstrap.Modal(document.getElementById('refundPolicyModal'));
    const agreeCheckbox = document.getElementById('agreeRefundPolicy');
    const confirmButton = document.getElementById('confirmRefundPolicy');
    const agreementError = document.getElementById('agreementError');

    // Confirm button click handler
    confirmButton.addEventListener('click', function() {
        if (!agreeCheckbox.checked) {
            agreementError.style.display = 'block';
            agreeCheckbox.focus();
            return;
        }

        agreementError.style.display = 'none';

        // Mark as agreed
        window.refundPolicyAgreed = true;

        // Close modal
        refundPolicyModal.hide();

        // Trigger form submission if form exists
        if (window.pendingBookingSubmission) {
            window.pendingBookingSubmission();
        }
    });

    // Reset error when checkbox is checked
    agreeCheckbox.addEventListener('change', function() {
        if (this.checked) {
            agreementError.style.display = 'none';
        }
    });

    // Expose function to show modal
    window.showRefundPolicyModal = function() {
        agreeCheckbox.checked = false;
        agreementError.style.display = 'none';
        refundPolicyModal.show();
    };

    // Expose function to check if modal should be shown (always show now)
    window.shouldShowRefundPolicyModal = function() {
        return true;
    };
});
</script>

<style>
.policy-content {
    line-height: 1.8;
    color: #444;
}

.policy-section {
    padding: 15px;
    background: rgba(0, 0, 0, 0.02);
    border-radius: 10px;
    border-left: 3px solid #F56289;
}

.form-check-input:checked {
    background-color: #F56289;
    border-color: #F56289;
}

.form-check-input:focus {
    border-color: #F56289;
    box-shadow: 0 0 0 0.25rem rgba(245, 98, 137, 0.25);
}

#refundPolicyModal .modal-body {
    max-height: 70vh;
}

@media (max-width: 768px) {
    #refundPolicyModal .modal-body {
        padding: 20px;
        font-size: 0.9rem;
    }

    .policy-section h6 {
        font-size: 0.95rem;
    }

    .policy-section ul li {
        font-size: 0.85rem;
    }
}
</style>
