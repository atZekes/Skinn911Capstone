# 📱 Mobile Zoom Calendar Feature

## Overview
A three-level zoom calendar interface designed specifically for mobile devices, providing an intuitive way for clients to navigate through weeks, days, and time slots.

## User Experience Flow

### Level 1: Month View (Weeks)
- Shows 4 weeks of the current month
- Each week displayed as a card with date range
- Tap on any week to zoom into day view

### Level 2: Week View (Days)
- Shows 7 days of the selected week (Monday - Sunday)
- Each day shows availability status:
  - **Green indicator**: Slots available
  - **Full indicator**: Fully booked
  - **Gray**: No slots configured
- Real-time availability count
- Back button to return to weeks

### Level 3: Day View (Time Slots)
- Shows all available time slots for selected day
- Each slot displays:
  - Time range (e.g., "9:00AM - 10:00AM")
  - Availability ("X left" or "Full")
  - "Book Now" button for available slots
- Visual distinction between available and full slots
- Back button to return to days

## Features

### 🎯 Smart Navigation
- **Zoom in/out animations** for smooth transitions
- **Back button** at each level for easy navigation
- **Breadcrumb-style header** showing current context

### 📊 Real-time Availability
- **Dynamic slot calculations** based on bookings
- **Color-coded status indicators**
- **Availability counts** for quick decision-making

### 🎨 Visual Design
- **Brand colors** (#F56289 pink theme)
- **Card-based layout** for touch-friendly interaction
- **Smooth animations** (300ms zoom transitions)
- **High contrast** for readability

### ♿ Accessibility
- **44px minimum touch targets** (Apple/Google guidelines)
- **Clear visual hierarchy**
- **Disabled states** for unavailable options
- **Alert messages** when branch not selected

## Technical Implementation

### Files Modified
1. **`resources/views/Client/calendar_viewer.blade.php`**
   - Added mobile zoom calendar container
   - Passes booking data to JavaScript
   - Maintains desktop/tablet grid view

2. **`public/js/client/calendar_viewer.js`**
   - New `initMobileZoomCalendar()` function
   - Three view renderers: `renderMonthView()`, `renderWeekView()`, `renderDayView()`
   - Navigation logic: `zoomIntoWeek()`, `zoomIntoDay()`, `zoomOut()`
   - Helper functions for date formatting and availability calculation

3. **`public/css/client/calendar_viewer.css`**
   - Mobile-specific styles (< 768px)
   - Zoom animation keyframes
   - Card layouts for each view level
   - Touch-optimized button styles

### Data Flow
```
Blade Template (PHP)
    ↓ Generates booking data
JavaScript (window.calendarData)
    ↓ Processes and renders
Mobile Zoom Calendar UI
    ↓ User interaction
Booking Route
```

### Responsive Breakpoints
- **Mobile (< 768px)**: Zoom calendar interface
- **Tablet (768px - 1200px)**: Original horizontal grid
- **Desktop (> 1200px)**: Full horizontal grid

## Usage

### For Users
1. **Select a branch** from the dropdown
2. **Tap on a week** to view available days
3. **Tap on a day** to view time slots
4. **Tap "Book Now"** on available slot
5. Use **back button** to navigate up levels

### For Developers

#### Testing Mobile View
```bash
# Start server
php artisan serve

# Open in browser with mobile device emulation
# Chrome DevTools → Toggle Device Toolbar → iPhone/Android
```

#### Customization
```javascript
// Adjust number of weeks shown (in calendar_viewer.js)
for (let weekNum = 1; weekNum <= 4; weekNum++) { // Change 4 to desired number

// Modify animation duration (in calendar_viewer.css)
@keyframes zoomIn {
    /* Change 0.3s to your preferred duration */
}
```

## Browser Support
- ✅ Chrome/Edge (latest)
- ✅ Safari (iOS 12+)
- ✅ Firefox (latest)
- ✅ Samsung Internet

## Performance
- **Lightweight**: < 5KB additional JavaScript
- **No external dependencies**
- **CSS animations** (hardware accelerated)
- **Lazy data loading** (only renders current view)

## Future Enhancements
- [ ] Swipe gestures for navigation
- [ ] Month/year selector
- [ ] Horizontal day scrolling
- [ ] Haptic feedback on iOS
- [ ] Service duration indicators
- [ ] Multi-day booking flow

## Notes
- Desktop/tablet views remain unchanged
- All existing booking logic preserved
- Branch selection required for booking
- Availability calculated server-side for accuracy

---
**Created**: October 25, 2025  
**Version**: 1.0.0  
**Compatibility**: Laravel 10+, Bootstrap 5+
