<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fff 60%, #ffe4ec 100%);
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            min-height: 100vh;
        }
        .dashboard-container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            padding: 48px 36px;
        }
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 32px;
        }
        .dashboard-header img {
            width: 80px;
            margin-right: 18px;
        }
        .dashboard-header h1 {
            color: #e75480;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
        }
        .dashboard-content {
            text-align: center;
        }
        .dashboard-content h2 {
            color: #e75480;
            font-size: 1.5rem;
            margin-bottom: 18px;
        }
        .dashboard-content p {
            color: #333;
            font-size: 1.1rem;
        }
        .btn {
            background: linear-gradient(90deg, #e75480 0%, #ffb6c1 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 32px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 24px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: linear-gradient(90deg, #ffb6c1 0%, #e75480 100%);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <img src="/img/logo.png" alt="Logo">
            <h1>Skin911 Staff Dashboard</h1>
        </div>
        <div class="dashboard-content">
            <h2>Welcome, {{ Auth::user()->name ?? 'Staff' }}!</h2>
            <p>This is your staff dashboard. Here you can manage appointments, view your profile, and more.</p>
            <a href="{{ route('staff.show', Auth::user()->id) }}" class="btn">View Profile</a>
        </div>
    </div>
    <div class="container py-5">
        <h2 class="mb-4" style="color:#e75480;">POS & Branch Transactions</h2>
        <div class="card mb-4">
            <div class="card-header" style="background:#e75480;color:#fff;">Record New Transaction</div>
            <div class="card-body">
                <form method="POST" action="{{ route('staff.pos.record') }}">
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
    
    <script>
    // Double-submit prevention for transaction form
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[method="POST"]');
        if (form) {
            let isSubmitting = false;
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (isSubmitting || (submitBtn && submitBtn.disabled)) {
                    e.preventDefault();
                    return false;
                }
                if (submitBtn) {
                    isSubmitting = true;
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Recording...';
                    // Re-enable after 3 seconds as fallback
                    setTimeout(function() {
                        isSubmitting = false;
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }, 3000);
                }
            });
        }
    });
    </script>
</body>
</html>
