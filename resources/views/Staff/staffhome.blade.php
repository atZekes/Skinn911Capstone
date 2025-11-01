@extends('layouts.staffapp')
@section('tab-content')
<div class="container py-5">
    <h2 class="mb-4" style="color:#e75480;">POS & Branch Transactions</h2>
    <div class="mb-4 card">
        <div class="card-header" style="background:#e75480;color:#fff;">Record New Transaction</div>
        <div class="card-body">
            <form id="transaction-form" method="POST" action="{{ route('staff.pos.record') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="service_id" style="color:#e75480;">Service</label>
                        <select name="service_id" class="form-control" required>
                            @foreach(App\Models\Service::all() as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="amount" style="color:#e75480;">Amount</label>
                        <input type="number" name="amount" class="form-control" required min="0" step="0.01">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="payment_method" style="color:#e75480;">Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="E-wallet">E-wallet</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-pink" style="background:#e75480;color:#fff;">Record Transaction</button>
                <div id="transaction-success" class="mt-3 alert alert-success alert-dismissible fade show" role="alert" style="display:none;">
                    Transaction recorded successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header" style="background:#e75480;color:#fff;">Today's Transactions</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaction->service->name ?? '-' }}</td>
                        <td>{{ number_format($transaction->amount, 2) }}</td>
                        <td>{{ $transaction->payment_method }}</td>
                        <td>{{ $transaction->created_at->format('H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No transactions found for today.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(function() {
    var servicePrices = {};
    @foreach(App\Models\Service::all() as $service)
        servicePrices[{{ $service->id }}] = {{ is_numeric($service->price) ? $service->price : 0 }};
    @endforeach
    var $serviceSelect = $('#transaction-form select[name="service_id"]');
    var $amountInput = $('#transaction-form input[name="amount"]');
    $serviceSelect.on('change', function() {
        var selectedId = $(this).val();
        var price = servicePrices[selectedId];
        if (typeof price === 'undefined' || price === null || price === '') {
            price = 0;
        }
        console.log('Selected service:', selectedId, 'Price:', price);
        $amountInput.val(price);
    });
    // Trigger change on page load to set initial value
    $serviceSelect.trigger('change');

    // AJAX submit for transaction form
        $('#transaction-form').on('submit', function(e) {
            e.preventDefault();
            console.log('AJAX submit triggered');
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#transaction-success').show();
                    } else {
                        alert('Unexpected response.');
                    }
                    form[0].reset();
                    $('select[name="service_id"]').trigger('change');
                },
                error: function(xhr) {
                    alert('Error recording transaction. Please try again.');
                    // Re-enable submit button on error
                    submitBtn.prop('disabled', false);
                    submitBtn.html(originalBtnText);
                }
            });
            return false;
        });

        // Double-submit prevention
        let isSubmitting = false;
        let originalBtnText = '';
        $('#transaction-form').on('submit', function(e) {
            var submitBtn = $(this).find('button[type="submit"]');
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            isSubmitting = true;
            originalBtnText = submitBtn.html();
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Recording...');

            // Re-enable after 3 seconds as fallback
            setTimeout(function() {
                isSubmitting = false;
                submitBtn.prop('disabled', false);
                submitBtn.html(originalBtnText);
            }, 3000);
        });
});
</script>
@endsection
