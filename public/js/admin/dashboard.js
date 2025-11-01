/**
 * Admin Dashboard JavaScript
 * Extracted from dashboard.blade.php
 */

class AdminDashboard {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.initChart();
            this.initSearchFilter();
            this.initBookingModal();
            this.initLiveUpdates();
        });
    }

    // Initialize Chart.js chart
    initChart() {
        const chartContainer = document.getElementById('bookingsChart');
        if (!chartContainer) return;

        // Get data from data attributes or meta tags
        const labels = this.getChartData('labels');
        const datasets = this.getChartData('datasets');

        if (!labels.length || !datasets.length) return;

        const colors = ['#e75480','#6f42c1','#0d6efd','#198754','#fd7e14','#20c997'];

        const chartDatasets = datasets.map((ds, idx) => ({
            label: ds.label,
            data: ds.data,
            backgroundColor: colors[idx % colors.length],
            borderColor: colors[idx % colors.length],
            fill: false,
            tension: 0.2,
        }));

        const ctx = chartContainer.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: { labels: labels, datasets: chartDatasets },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true, precision:0 } }
            }
        });
    }

    // Initialize search/filter functionality
    initSearchFilter() {
        const input = document.getElementById('booking-search');
        const table = document.getElementById('recent-bookings-table');

        if (!input || !table) return;

        const tbody = table.tBodies[0];
        const rows = tbody ? Array.from(tbody.rows) : [];

        const normalize = (s) => (s || '').toString().toLowerCase();

        const filterRows = (q) => {
            q = normalize(q);
            rows.forEach((r) => {
                const id = normalize(r.querySelector('.col-id')?.textContent);
                const client = normalize(r.querySelector('.col-client')?.textContent);
                const branch = normalize(r.querySelector('.col-branch')?.textContent);
                const date = normalize(r.querySelector('.col-date')?.textContent);
                const time = normalize(r.querySelector('.col-time')?.textContent);
                const hay = [id, client, branch, date, time].join(' ');
                r.style.display = hay.indexOf(q) !== -1 ? '' : 'none';
            });
        };

        let timer = null;
        input.addEventListener('input', (e) => {
            clearTimeout(timer);
            timer = setTimeout(() => filterRows(input.value), 180);
        });

        // Prevent default View anchor until a real handler is added
        table.addEventListener('click', (ev) => {
            const btn = ev.target.closest('.btn-view-booking');
            if (btn) {
                ev.preventDefault();
                // This will be handled by the modal functionality
            }
        });
    }

    // Initialize booking detail modal
    initBookingModal() {
        const modalEl = document.getElementById('bookingDetailModal');
        const table = document.getElementById('recent-bookings-table');

        if (!modalEl || !table) return;

        const bsModal = new bootstrap.Modal(modalEl);

        table.addEventListener('click', (ev) => {
            const btn = ev.target.closest('.btn-view-booking');
            if (!btn) return;

            ev.preventDefault();
            const row = btn.closest('tr');
            if (!row) return;

            // Populate modal with row data
            const bookingId = row.querySelector('.col-id')?.textContent || '';
            document.getElementById('md-booking-id').textContent = bookingId;
            document.getElementById('md-booking-client').textContent =
                row.querySelector('.col-client')?.textContent || '';
            document.getElementById('md-booking-branch').textContent =
                row.querySelector('.col-branch')?.textContent || '';
            document.getElementById('md-booking-date').textContent =
                row.querySelector('.col-date')?.textContent || '';
            document.getElementById('md-booking-time').textContent =
                row.querySelector('.col-time')?.textContent || '';

            // Basic status derivation
            const statusText = row.dataset?.status || 'N/A';
            document.getElementById('md-booking-status').textContent = statusText;

            bsModal.show();
        });
    }

    // Initialize live updates for newly created bookings
    initLiveUpdates() {
        window.addEventListener('booking:created', (e) => {
            try {
                const b = e && e.detail ? e.detail : null;
                if (!b) return;

                // Increment walkins KPI if it's a walk-in
                if (b.is_walkin || (!b.user_name && b.walkin_name)) {
                    const el = document.getElementById('kpi-walkins');
                    if (el) {
                        const cur = parseInt(el.textContent || '0', 10) || 0;
                        el.textContent = (cur + 1).toString();
                    }
                }

                // Update branch summary if present
                if (b.branch_id) {
                    this.updateBranchSummary(b.branch_id);
                }
            } catch (err) {
                console.warn('booking:created handler error', err);
            }
        });
    }

    // Update branch summary statistics
    updateBranchSummary(branchId) {
        const summary = document.querySelector(`.branch-summary[data-branch-id="${branchId}"]`);
        if (!summary) return;

        const countEl = summary.querySelector('.branch-count');
        const utilEl = summary.querySelector('.branch-util');
        const statusEl = summary.querySelector('.branch-status');

        if (countEl) {
            // Parse "X / Y"
            const parts = (countEl.textContent || '').split('/').map(s => s.trim());
            let today = parseInt(parts[0] || '0', 10) || 0;
            const cap = parseInt(parts[1] || '0', 10) || 0;

            today = today + 1;
            countEl.textContent = `${today} / ${cap}`;

            const util = cap > 0 ? Math.round((today / cap) * 100) : 0;

            if (utilEl) utilEl.textContent = `Utilization: ${util}%`;

            if (statusEl) {
                if (util >= 90) {
                    statusEl.textContent = 'High (≥90%)';
                    statusEl.style.color = '#c92a2a';
                } else if (util >= 70) {
                    statusEl.textContent = 'Medium (70–89%)';
                    statusEl.style.color = '#e67700';
                } else {
                    statusEl.textContent = 'Low';
                    statusEl.style.color = '#2f9e44';
                }
            }
        }
    }

    // Helper method to get chart data from data attributes or meta tags
    getChartData(type) {
        // Try to get from data attributes first
        const chartContainer = document.getElementById('bookingsChart');
        if (chartContainer) {
            const data = chartContainer.dataset[type];
            if (data) {
                try {
                    return JSON.parse(data);
                } catch (e) {
                    console.warn(`Failed to parse ${type} data:`, e);
                }
            }
        }

        // Fallback to meta tags
        const metaTag = document.querySelector(`meta[name="chart-${type}"]`);
        if (metaTag) {
            try {
                return JSON.parse(metaTag.getAttribute('content'));
            } catch (e) {
                console.warn(`Failed to parse ${type} from meta tag:`, e);
            }
        }

        return [];
    }

    // Method to set chart data (can be called from blade template)
    setChartData(labels, datasets) {
        const chartContainer = document.getElementById('bookingsChart');
        if (chartContainer) {
            chartContainer.dataset.labels = JSON.stringify(labels);
            chartContainer.dataset.datasets = JSON.stringify(datasets);
        }
    }
}

// Initialize when DOM is loaded
new AdminDashboard();
