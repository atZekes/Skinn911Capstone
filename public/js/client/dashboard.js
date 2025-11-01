// Simple, readable client dashboard JS
document.addEventListener('DOMContentLoaded', function() {
    // 1) Auto-dismiss and remove success toast overlay after a short delay
    try {
        var overlay = document.getElementById('success-toast-overlay');
        if (overlay) {
            setTimeout(function() {
                overlay.style.opacity = '0';
                setTimeout(function() { if (overlay.parentNode) overlay.parentNode.removeChild(overlay); }, 150);
            }, 1000);
        }
    } catch (e) { /* fail silently */ }

    // 2) Attach click handlers to cancel buttons to open modal and set form action
    try {
        var cancelButtons = document.querySelectorAll('.cancel-booking-btn');
        cancelButtons.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var form = document.getElementById('cancelBookingForm');
                if (!form) return;
                form.action = btn.getAttribute('data-action');
                // show bootstrap modal
                var modalEl = document.getElementById('cancelBookingModal');
                if (modalEl && typeof bootstrap !== 'undefined') {
                    var modal = new bootstrap.Modal(modalEl);
                    modal.show();
                }
            });
        });

        // Ensure form hides modal when submitted
        var cancelForm = document.getElementById('cancelBookingForm');
        if (cancelForm) {
            cancelForm.addEventListener('submit', function() {
                var modalEl = document.getElementById('cancelBookingModal');
                if (modalEl && typeof bootstrap !== 'undefined') {
                    var modalInst = bootstrap.Modal.getInstance(modalEl);
                    if (modalInst) modalInst.hide();
                }
            });
        }

        // 'No' button reloads/redirects to the dashboard route
        var noBtn = document.getElementById('cancelNoBtn');
        if (noBtn) {
            noBtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = noBtn.href;
            });
        }
    } catch (e) { /* fail silently */ }

    // 3) Mobile friendly table labels: add data-label attributes to td elements
    try {
        function addLabels(table, labels) {
            if (!table) return;
            var rows = table.querySelectorAll('tbody tr');
            rows.forEach(function(row) {
                var cells = row.querySelectorAll('td');
                cells.forEach(function(cell, i) {
                    cell.setAttribute('data-label', labels[i] || '');
                });
            });
        }
        var tables = document.querySelectorAll('.card-body table.table-bordered');
        if (tables.length > 0) addLabels(tables[0], ['Service','Price','Date Purchased','Location','Status']);
        if (tables.length > 1) addLabels(tables[1], ['Branch','Service','Date','Time Slot','Status','Action']);
    } catch (e) { /* fail silently */ }

    // 4) Booking search filter
    try {
        var searchInput = document.getElementById('clientBookingSearch');
        if (searchInput) {
            var tbody = document.querySelector('#clientBookingQueue table tbody');
            if (tbody) {
                var rows = Array.from(tbody.querySelectorAll('tr'));
                function filterRows() {
                    var q = (searchInput.value || '').trim().toLowerCase();
                    var anyVisible = false;
                    rows.forEach(function(r) {
                        if (r.classList && r.classList.contains('no-results')) return;
                        var nameCell = r.cells[1];
                        var branchCell = r.cells[0];
                        var name = nameCell ? (nameCell.textContent || nameCell.innerText || '').toLowerCase() : '';
                        var branch = branchCell ? (branchCell.textContent || branchCell.innerText || '').toLowerCase() : '';
                        var match = q === '' || name.indexOf(q) !== -1 || branch.indexOf(q) !== -1;
                        r.style.display = match ? '' : 'none';
                        if (match) anyVisible = true;
                    });
                    var noResults = tbody.querySelector('.no-results');
                    if (noResults) noResults.style.display = anyVisible ? 'none' : '';
                }
                searchInput.addEventListener('input', filterRows);
            }
        }
    } catch (e) { /* fail silently */ }
});
