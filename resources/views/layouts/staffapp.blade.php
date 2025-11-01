<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Skin911 Staff Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Force pink for sidebar nav links and icons, override Bootstrap */
        .sidebar .nav-link,
        .sidebar .nav-link:visited,
        .sidebar .nav-link:active,
        .sidebar .nav-link:focus,
        .sidebar .nav-link:hover,
        .sidebar .nav-link i {
            color: #e75480 !important;
        }
        body {
            background: linear-gradient(135deg, #fff 60%, #ffe4ec 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
            min-height: 100vh;
        }
        .staff-header {
            background: #fff;
            border-bottom: 2px solid #ffe4ec;
            padding: 24px 0 12px 0;
            text-align: center;
        /* Only sidebar tab links are pink */

        .sidebar .nav-link i {
            color: #e75480 !important;
        }
            font-weight: bold;
            font-size: 2.2rem;
            margin: 0;
        }
        .staff-header img {
            width: 80px;
            margin-bottom: 8px;
        }
        .staff-content {
            padding: 32px 0;
        }

        /* Custom Alert Styles */
        .custom-alert {
            position: relative;
            display: flex;
            align-items: start;
            gap: 15px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: slideInDown 0.4s ease-out, fadeOut 0.5s ease-in 4.5s;
            animation-fill-mode: forwards;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .custom-alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 5px solid #28a745;
            color: #155724;
        }

        .custom-alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 5px solid #dc3545;
            color: #721c24;
        }

        .custom-alert .alert-icon {
            font-size: 2rem;
            min-width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-alert-success .alert-icon {
            color: #28a745;
            animation: bounceIn 0.6s ease-out;
        }

        .custom-alert-error .alert-icon {
            color: #dc3545;
            animation: shake 0.6s ease-out;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-10px);
            }
            75% {
                transform: translateX(10px);
            }
        }

        .custom-alert .alert-content {
            flex: 1;
        }

        .custom-alert .alert-content strong {
            display: block;
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .custom-alert .alert-content p {
            margin: 0;
            line-height: 1.5;
        }

        .custom-alert .alert-content ul {
            margin: 0.5rem 0 0 0;
            padding-left: 1.5rem;
        }

        .custom-alert .alert-content ul li {
            margin: 0.25rem 0;
        }

        .custom-alert .alert-close {
            background: transparent;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0.6;
            transition: all 0.3s;
            padding: 0;
            min-width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-alert .alert-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .custom-alert-success .alert-close {
            color: #155724;
        }

        .custom-alert-error .alert-close {
            color: #721c24;
        }
    </style>
    @yield('styles')
    @yield('head')
</head>
<body>
    <div class="staff-header" style="background:#fff;border-bottom:2px solid #ffe4ec;padding:16px 0 8px 0;">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-2 d-flex align-items-center justify-content-start">
                    <img src="/img/skinlogo.png" alt="Skin911 Logo" style="width:180px;max-width:100%;margin-bottom:0;">
                </div>
                <div class="col-md-10 d-flex align-items-center justify-content-center">
                    @php
                        $staffUser = auth('staff')->user();
                        $branchName = '';
                        if ($staffUser && $staffUser->branch_id) {
                            $branch = \App\Models\Branch::find($staffUser->branch_id);
                            $branchName = $branch ? $branch->name : '';
                        }
                    @endphp
                    <h1 style="font-size:2.6rem;color:#e75480;font-weight:bold;margin:0;">
                        Skin911 {{ $branchName ? $branchName . ' Branch' : '' }} Staff Panel
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="bg-white shadow-sm col-md-2 d-none d-md-block sidebar" style="border-right: 1px solid #e5e5e5; min-height: 100vh;">
                <div class="pt-4 sidebar-sticky" style="display:flex;flex-direction:column;height:100%;">
                    <ul class="nav flex-column" id="staffTabNav" style="flex:1 1 auto;">
                        <li class="mb-2 nav-item">
                            <a class="nav-link" href="{{ route('staff.appointments') }}">
                                <i class="mr-2 fa fa-calendar-check-o"></i> Appointment Management
                            </a>
                        </li>

                        <li class="mb-2 nav-item">
                          <a class="nav-link" href="{{ route('staff.interact') }}">
                                        <i class="mr-2 fa fa-user"></i> Customer Interaction
                                    </a>
                            <ul class="ml-4 nav flex-column" style="margin-top:4px;">
                                <li class="nav-item">

                                </li>
                            </ul>
                        </li>
                        <li class="mb-2 nav-item">
                                <a class="nav-link" href="{{ route('staff.availability') }}">
                                    <i class="mr-2 fa fa-clock-o"></i> Real-Time Availability
                                </a>
                        </li>

                        <li class="mb-2 nav-item">
                            <a class="nav-link" href="{{ route('staff.index') }}">
                                <i class="mr-2 fa fa-credit-card"></i> POS
                            </a>
                        </li>
                    </ul>
                    <ul class="nav flex-column" style="margin-top:auto;">
                        <li class="mb-2 nav-item logout-nav">
                            <form method="POST" action="{{ route('staff.logout') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="color:#e75480;padding:0;text-align:left;width:100%;">
                                    <i class="mr-2 fa fa-sign-out"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Main Content -->
            <main role="main" class="px-4 py-4 col-md-10 ml-sm-auto staff-main-content">
                @if(session('success'))
                    <div class="custom-alert custom-alert-success" role="alert">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Success!</strong>
                            <p>{{ session('success') }}</p>
                        </div>
                        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="custom-alert custom-alert-error" role="alert">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Error!</strong>
                            <p>{{ session('error') }}</p>
                        </div>
                        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="custom-alert custom-alert-error" role="alert">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Validation Error!</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                <div class="tab-content" id="staffTabContent">
                    @yield('tab-content')
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    @yield('scripts')
    <script>
$(document).ready(function() {
    // Custom cancel confirmation modal
    if ($('#cancelConfirmModal').length === 0) {
        $('body').append(`
            <div class="modal fade" id="cancelConfirmModal" tabindex="-1" role="dialog" aria-labelledby="cancelConfirmLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content" style="border-radius:16px;">
                  <div class="modal-header" style="background:#e75480;color:#fff;border-top-left-radius:16px;border-top-right-radius:16px;">
                    <h5 class="modal-title" id="cancelConfirmLabel">Cancel Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" style="color:#e75480;">Are you sure you want to cancel this appointment?</div>
                  <div class="modal-footer" style="background:#fff;border-bottom-left-radius:16px;border-bottom-right-radius:16px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-pink" id="confirmCancelBtn" style="background:#e75480;color:#fff;">Yes, Cancel</button>
                  </div>
                </div>
              </div>
            </div>
        `);
    }
    var cancelForm = null;
    // Intercept cancel button
    $('.table').on('click', 'form[action*="cancelAppointment"] button[type="submit"]', function(e) {
        e.preventDefault();
        cancelForm = $(this).closest('form');
        $('#cancelConfirmModal').modal('show');
    });
    // Handle confirm cancel
    $('body').on('click', '#confirmCancelBtn', function() {
        if(cancelForm) {
            $.ajax({
                url: cancelForm.attr('action'),
                method: 'POST',
                data: cancelForm.serialize(),
                success: function(response) {
                    $('#cancelConfirmModal').modal('hide');
                    $('<div class="mt-3 alert alert-success">Successfully cancelled.</div>').insertBefore('.table').delay(2000).fadeOut();
                    var row = cancelForm.closest('tr');
                    row.find('td:eq(5)').html('<span class="text-muted">Cancelled</span>');
                    row.find('td:eq(6)').html('<span class="text-muted">Cancelled</span>');
                },
                error: function(xhr) {
                    alert('Error cancelling appointment.');
                }
            });
        }
    });
});
</script>
<script>
$(function() {
    function filterTimeSlotsClient() {
        var selectedDate = $('input[name="date"]:visible').val();
        var now = new Date();
        var today = now.toISOString().slice(0,10);
        var currentHour = now.getHours();
        var currentMinute = now.getMinutes();
        var currentTime = currentHour * 60 + currentMinute;
        var slotMap = {
            '09:00-10:00': 9 * 60,
            '10:00-11:00': 10 * 60,
            '11:00-12:00': 11 * 60,
            '12:00-13:00': 12 * 60,
            '13:00-14:00': 13 * 60,
            '14:00-15:00': 14 * 60,
            '15:00-16:00': 15 * 60,
            '16:00-17:00': 16 * 60,
            '17:00-18:00': 17 * 60
        };
        var select = $('select[name="time_slot"]:visible');
        select.find('option').each(function() {
            var slot = $(this).val();
            if(selectedDate === today && slotMap[slot] < currentTime) {
                $(this).prop('disabled', true).text(slot + ' (Past)');
            } else {
                $(this).prop('disabled', false).text(slot);
            }
        });
    }
    $('input[name="date"]:visible').on('change', filterTimeSlotsClient);
    $(document).ready(filterTimeSlotsClient);
});
</script>
</body>
</html>
