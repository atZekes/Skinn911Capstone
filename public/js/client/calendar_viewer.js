document.addEventListener('DOMContentLoaded', function() {
    // Calendar day selection
    document.querySelectorAll('.calendar-day-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.calendar-day-btn').forEach(b => b.classList.remove('btn-pink'));
            btn.classList.add('btn-pink');
            var sel = document.getElementById('selected_date'); if (sel) sel.value = btn.getAttribute('data-date');
            updateTimeSlots();
        });
    });
    // Time slot selection
    document.querySelectorAll('.time-slot-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.time-slot-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');
            var st = document.getElementById('selected_time_slot'); if (st) st.value = btn.getAttribute('data-slot');
        });
    });
    // Initial date selection
    var firstDay = document.querySelector('.calendar-day-btn');
    if (firstDay) {
        firstDay.click();
    }
    // Fetch and disable full slots
    function updateTimeSlots() {
        var branchEl = document.getElementById('branch_id');
        var branchId = branchEl ? branchEl.value : '';
        var dateEl = document.getElementById('selected_date');
        var date = dateEl ? dateEl.value : '';
        // by default assume single-hour query; calendar viewer shows per-slot availability
        fetch(`/api/booking/slots?branch_id=${branchId}&date=${date}&duration=1`)
            .then(response => response.json())
            .then(data => {
                document.querySelectorAll('.time-slot-btn').forEach(function(btn) {
                    var slot = btn.getAttribute('data-slot');
                    if (data.fullSlots && data.fullSlots.includes(slot)) {
                        btn.disabled = true;
                        btn.textContent = slot + ' (Full)';
                        btn.classList.remove('selected');
                        btn.style.background = '#eee';
                        btn.style.color = '#aaa';
                    } else {
                        btn.disabled = false;
                        btn.textContent = slot;
                        btn.style.background = '';
                        btn.style.color = '';
                    }
                });
            });
    }
});

// Event listeners for external booking changes
window.addEventListener('booking:rescheduled', function(e){
    try {
        var bid = e.detail && e.detail.branch_id ? String(e.detail.branch_id) : null;
        var current = document.getElementById('branch_id') ? document.getElementById('branch_id').value : '';
        if (!bid || !current || bid === current) {
            location.reload();
        }
    } catch(e) { console.warn('booking:rescheduled handler error', e); }
});
window.addEventListener('booking:created', function(e){
    try {
        var bid = e.detail && e.detail.branch_id ? String(e.detail.branch_id) : null;
        var current = document.getElementById('branch_id') ? document.getElementById('branch_id').value : '';
        if (!bid || !current || bid === current) {
            location.reload();
        }
    } catch(err) { console.warn('booking:created handler error', err); }
});

// Branch filter form submit helper
document.addEventListener('DOMContentLoaded', function() {
    var branchSel = document.getElementById('branch_id');
    if (branchSel) {
        branchSel.addEventListener('change', function() {
            var form = document.getElementById('branchFilterForm');
            if (form) form.submit();
        });
    }
    // Prevent clicking available links if no branch is selected
    setTimeout(function() {
        document.querySelectorAll('.available-link, .booked-link').forEach(function(link) {
            if (!document.getElementById('branch_id').value) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert('Please select a branch first.');
                });
            }
        });
        document.querySelectorAll('.booked-link.bg-danger').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                alert('This slot is already full and cannot be booked.');
            });
        });
    }, 100);

    // Mobile calendar reorganization: group by day instead of by time slot
    if (window.innerWidth < 768) {
        initMobileZoomCalendar();
    }

    // Re-run on resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth < 768 && !document.body.classList.contains('mobile-zoom-active')) {
                initMobileZoomCalendar();
            } else if (window.innerWidth >= 768 && document.body.classList.contains('mobile-zoom-active')) {
                location.reload(); // Reload to restore desktop view
            }
        }, 250);
    });
});

// Mobile Zoom Calendar: Three-level navigation (Month → Week → Day)
let zoomState = {
    view: 'month', // 'month', 'week', 'day'
    selectedWeek: null,
    selectedDate: null,
    calendarData: null
};

function initMobileZoomCalendar() {
    if (!window.calendarData) {
        console.warn('Calendar data not available');
        return;
    }

    zoomState.calendarData = window.calendarData;
    const mobileCalendar = document.getElementById('mobile-zoom-calendar');
    const desktopCalendar = document.getElementById('calendar-viewer');

    if (mobileCalendar && desktopCalendar) {
        mobileCalendar.classList.remove('d-none');
        desktopCalendar.style.display = 'none';
        document.body.classList.add('mobile-zoom-active');

        // Initialize month view
        renderMonthView();

        // Back button handler
        document.getElementById('zoom-back-btn').addEventListener('click', zoomOut);
    }
}

function renderMonthView() {
    zoomState.view = 'month';
    zoomState.selectedWeek = null;
    zoomState.selectedDate = null;

    const content = document.getElementById('zoom-content');
    const title = document.getElementById('zoom-title');
    const backBtn = document.getElementById('zoom-back-btn');

    title.textContent = 'Select a Week';
    backBtn.style.display = 'none';

    // Generate 4 weeks starting from today
    const today = new Date();
    const currentMonth = today.toLocaleString('default', { month: 'long', year: 'numeric' });

    let html = `<div class="zoom-month-view">`;
    html += `<div class="zoom-month-label">${currentMonth}</div>`;

    for (let weekNum = 1; weekNum <= 4; weekNum++) {
        const weekStart = new Date(today);
        weekStart.setDate(today.getDate() + (weekNum - 1) * 7);
        const weekEnd = new Date(weekStart);
        weekEnd.setDate(weekStart.getDate() + 6);

        const startLabel = weekStart.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        const endLabel = weekEnd.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });

        html += `
            <div class="zoom-week-card" data-week="${weekNum}" data-start="${weekStart.toISOString()}">
                <div class="zoom-week-number">Week ${weekNum}</div>
                <div class="zoom-week-range">${startLabel} - ${endLabel}</div>
                <div class="zoom-week-arrow">→</div>
            </div>
        `;
    }

    html += `</div>`;
    content.innerHTML = html;

    // Add click handlers
    document.querySelectorAll('.zoom-week-card').forEach(card => {
        card.addEventListener('click', function() {
            const weekNum = parseInt(this.dataset.week);
            const weekStart = new Date(this.dataset.start);
            zoomIntoWeek(weekNum, weekStart);
        });
    });

    // Add animation
    content.classList.remove('zoom-in', 'zoom-out');
    setTimeout(() => content.classList.add('zoom-in'), 10);
}

function zoomIntoWeek(weekNum, weekStart) {
    zoomState.view = 'week';
    zoomState.selectedWeek = { num: weekNum, start: weekStart };

    const content = document.getElementById('zoom-content');
    const title = document.getElementById('zoom-title');
    const backBtn = document.getElementById('zoom-back-btn');

    title.textContent = `Week ${weekNum}`;
    backBtn.style.display = 'flex';
    document.getElementById('zoom-back-text').textContent = 'Back to Weeks';

    // Zoom out animation
    content.classList.add('zoom-out');

    setTimeout(() => {
        renderWeekView(weekStart);
    }, 300);
}

function renderWeekView(weekStart) {
    const content = document.getElementById('zoom-content');
    const { currentBranchId, operatingDays } = zoomState.calendarData;

    let html = `<div class="zoom-week-view">`;

    if (!currentBranchId) {
        html += `
            <div class="zoom-alert">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <p>Please select a branch first to view available days</p>
            </div>
        `;
    }

    // Generate 7 days
    for (let i = 0; i < 7; i++) {
        const date = new Date(weekStart);
        date.setDate(date.getDate() + i);
        const dateStr = formatDateForBackend(date);
        const dayName = date.toLocaleDateString('en-US', { weekday: 'long' });
        const dateLabel = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });

        // Check if day is closed (not an operating day)
        const isDayOfWeekClosed = operatingDays && operatingDays.length > 0 && !operatingDays.includes(dayName);
        const isClosed = isDayOfWeekClosed;

        // Calculate availability for this day (only if not closed)
        const availability = isClosed ? { total: 0, available: 0, percentage: 0 } : calculateDayAvailability(dateStr);
        const availabilityClass = isClosed ? 'closed-day' : (availability.total === 0 ? 'no-slots' : availability.available > 0 ? 'has-slots' : 'full-slots');

        html += `
            <div class="zoom-day-card ${availabilityClass} ${!currentBranchId || isClosed ? 'disabled' : ''}" data-date="${dateStr}">
                <div class="zoom-day-header">
                    <div class="zoom-day-name">${dayName}</div>
                    <div class="zoom-day-date">${dateLabel}</div>
                </div>
                <div class="zoom-day-availability">
                    ${isClosed ?
                        `<span class="closed-label">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 4px;">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="15" y1="9" x2="9" y2="15"/>
                                <line x1="9" y1="9" x2="15" y2="15"/>
                            </svg>
                            Closed
                        </span>` :
                        availability.total > 0 ? `
                            ${availability.available > 0 ?
                                `<span class="available-count">${availability.available} slots available</span>` :
                                `<span class="full-label">Fully Booked</span>`
                            }
                        ` : `<span class="no-slots-label">No slots</span>`
                    }
                </div>
                ${currentBranchId && !isClosed && availability.available > 0 ? '<div class="zoom-day-arrow">→</div>' : ''}
            </div>
        `;
    }

    html += `</div>`;
    content.innerHTML = html;

    // Add click handlers (only for open days)
    if (currentBranchId) {
        document.querySelectorAll('.zoom-day-card:not(.disabled):not(.no-slots):not(.full-slots):not(.closed-day)').forEach(card => {
            card.addEventListener('click', function() {
                const dateStr = this.dataset.date;
                zoomIntoDay(dateStr);
            });
        });
    }

    // Add animation
    content.classList.remove('zoom-out');
    content.classList.add('zoom-in');
}function zoomIntoDay(dateStr) {
    zoomState.view = 'day';
    zoomState.selectedDate = dateStr;

    const content = document.getElementById('zoom-content');
    const title = document.getElementById('zoom-title');
    const backBtn = document.getElementById('zoom-back-btn');

    const date = new Date(dateStr + 'T00:00:00');
    const dateLabel = date.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' });

    title.textContent = dateLabel;
    document.getElementById('zoom-back-text').textContent = 'Back to Days';

    // Zoom out animation
    content.classList.add('zoom-out');

    setTimeout(() => {
        renderDayView(dateStr);
    }, 300);
}

function renderDayView(dateStr) {
    const content = document.getElementById('zoom-content');
    const { slots, occupyingCount, maxSlots, currentBranchId, bookingRoute } = zoomState.calendarData;

    let html = `<div class="zoom-day-view">`;

    slots.forEach(slot => {
        const occ = (occupyingCount[dateStr] && occupyingCount[dateStr][slot]) || 0;
        const available = maxSlots - occ;
        const isFull = occ >= maxSlots;

        // Format time slot
        let formattedSlot = slot;
        if (slot.includes('-')) {
            try {
                const [start, end] = slot.split('-');
                const startTime = formatTime(start.trim());
                const endTime = formatTime(end.trim());
                formattedSlot = `${startTime} - ${endTime}`;
            } catch (e) {
                formattedSlot = slot;
            }
        }

        const bookingUrl = bookingRoute
            .replace('__BRANCH__', currentBranchId)
            .replace('__DATE__', dateStr)
            .replace('__SLOT__', encodeURIComponent(slot));

        html += `
            <div class="zoom-slot-card ${isFull ? 'full' : 'available'}">
                <div class="zoom-slot-time">${formattedSlot}</div>
                <div class="zoom-slot-status">
                    ${isFull ?
                        `<span class="status-full">Full</span>` :
                        `<a href="${bookingUrl}" class="status-available">
                            <span class="slot-count">${available} left</span>
                            <span class="book-label">Book Now</span>
                        </a>`
                    }
                </div>
            </div>
        `;
    });

    html += `</div>`;
    content.innerHTML = html;

    // Add animation
    content.classList.remove('zoom-out');
    content.classList.add('zoom-in');
}

function zoomOut() {
    const content = document.getElementById('zoom-content');
    content.classList.add('zoom-out');

    setTimeout(() => {
        if (zoomState.view === 'day') {
            renderWeekView(zoomState.selectedWeek.start);
        } else if (zoomState.view === 'week') {
            renderMonthView();
        }
    }, 300);
}

// Helper functions
function formatDateForBackend(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

function formatTime(timeStr) {
    try {
        const [hours, minutes] = timeStr.split(':');
        const hour = parseInt(hours);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const displayHour = hour > 12 ? hour - 12 : (hour === 0 ? 12 : hour);
        return `${displayHour}:${minutes}${ampm}`;
    } catch (e) {
        return timeStr;
    }
}

function calculateDayAvailability(dateStr) {
    const { slots, occupyingCount, maxSlots } = zoomState.calendarData;
    let totalSlots = slots.length;
    let availableSlots = 0;

    slots.forEach(slot => {
        const occ = (occupyingCount[dateStr] && occupyingCount[dateStr][slot]) || 0;
        const available = maxSlots - occ;
        if (available > 0) availableSlots++;
    });

    return {
        total: totalSlots,
        available: availableSlots,
        percentage: totalSlots > 0 ? Math.round((availableSlots / totalSlots) * 100) : 0
    };
}

// Remove old mobile reorganization function
function reorganizeCalendarForMobile() {
    // Deprecated - now using zoom calendar
    return;
}

