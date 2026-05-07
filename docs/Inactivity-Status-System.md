# Automatic Inactivity Status System

## Overview

The Gym Management System now includes an automatic inactivity detection system that sets membership status to 'inactive' when a member doesn't attend the gym for 3 consecutive days. This helps maintain accurate membership records and encourages member engagement.

---

## Implementation Details

### 1. **Model-Level Inactivity Detection**
**File:** `app/Models/GymMember.php`

**Helper Methods Added:**
```php
// Check if member has no attendance for 3 days
public function hasNoAttendanceForThreeDays()

// Get days since last attendance
public function daysSinceLastAttendance()
```

**Logic:**
- Checks last 3 days for any attendance records
- Returns true if no attendance found in 3-day window
- Calculates days since last attendance for analytics

### 2. **Console Command for Batch Updates**
**File:** `app/Console/Commands/UpdateInactiveMemberships.php`

**Features:**
- **Batch Processing:** Updates all inactive memberships at once
- **3-Day Window:** Checks attendance for past 3 days
- **Logging:** Records all status changes for audit
- **Reporting:** Shows count of updated memberships

**Usage:**
```bash
# Manual execution
php artisan memberships:update-inactive
```

### 3. **Enhanced Status Component**
**File:** `resources/views/components/membership-status.blade.php`

**Status Indicators:**
- **Expired (Red):** End date passed
- **Inactive (Gray):** No attendance for 3+ days
- **Expiring Soon (Yellow):** End date within 7 days
- **Active (Green):** Normal membership status

---

## Inactivity Logic

### **3-Day Rule:**
1. **Check Window:** Last 3 days from current date
2. **Attendance Query:** Look for any check-in within 3-day window
3. **Status Update:** Set to 'inactive' if no attendance found
4. **Notification:** Display warning with reactivation link

### **Detection Algorithm:**
```php
$threeDaysAgo = Carbon::now()->subDays(3);

$lastAttendance = $member->attendances()
    ->where('check_in_date', '>=', $threeDaysAgo->format('Y-m-d'))
    ->orderBy('check_in_date', 'desc')
    ->first();

return !$lastAttendance;
```

---

## Frontend Integration

### **Enhanced Status Banners:**

#### **Inactive Membership Warning:**
```html
<div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
    <div class="flex items-center">
        <svg class="w-5 h-5 text-gray-600 mr-2">
            <!-- Warning Icon -->
        </svg>
        <div>
            <h3 class="text-gray-800 font-semibold">Membership Inactive</h3>
            <p class="text-gray-600 text-sm">
                Your membership has been marked as inactive due to no gym visits for 3 consecutive days.
            </p>
            <p class="text-gray-600 text-sm mt-2">
                Please <a href="{{ route('client.attendance') }}" class="underline font-medium">check in</a> 
                to reactivate your membership.
            </p>
        </div>
    </div>
</div>
```

#### **Status Priority Order:**
1. **Expired** (Red) - Highest priority
2. **Inactive** (Gray) - Medium priority  
3. **Expiring Soon** (Yellow) - Low priority
4. **Active** (No banner) - Normal state

---

## Database Impact

### **Query Optimization:**
- **Indexed Fields:** `check_in_date` for fast attendance lookups
- **Efficient Queries:** Uses `whereDate` and `orderBy` for performance
- **Batch Updates:** Single query for all inactive members

### **Data Integrity:**
- **Cascade Deletes:** Maintains relationship integrity
- **Status Consistency:** Prevents conflicting states
- **Audit Trail:** All changes logged with timestamps

---

## Business Benefits

### **1. Accurate Membership Metrics:**
- **Active Count:** Only truly active members counted
- **Revenue Forecasting:** Better prediction based on real activity
- **Retention Analysis:** Identifies at-risk members

### **2. Automated Member Engagement:**
- **Proactive Outreach:** System identifies inactive members
- **Reactivation Guidance:** Clear instructions for returning
- **Retention Strategies:** Data-driven engagement campaigns

### **3. Operational Efficiency:**
- **Reduced Manual Work:** Automatic status updates
- **Consistent Application:** Rules applied uniformly
- **Administrative Savings:** Less time spent on status management

---

## Configuration Options

### **Customizable Settings:**
```php
// Can be modified for different business rules
const INACTIVITY_DAYS = 3; // Configurable
const INACTIVITY_CHECK_FREQUENCY = 'daily'; // Schedule frequency
```

### **Flexible Thresholds:**
- **Days Threshold:** Easily change from 3 to any number
- **Check Frequency:** Daily, weekly, or custom schedules
- **Grace Periods:** Optional warning periods before inactivity

---

## Monitoring and Analytics

### **Status Change Tracking:**
```php
Log::info("Updated {$inactiveCount} memberships to inactive status due to 3-day attendance gaps.");
```

### **Attendance Analytics:**
```php
// Days since last attendance
$daysSinceLastVisit = $member->daysSinceLastAttendance();

// Inactivity identification
$isInactive = $member->hasNoAttendanceForThreeDays();
```

### **Reporting Capabilities:**
- **Inactive Members Report:** List all inactive members
- **Activity Trends:** Attendance patterns over time
- **Reactivation Rates:** Track member return rates

---

## User Experience

### **Clear Communication:**
- **Status Banners:** Visual indicators for each membership state
- **Action Links:** Direct paths to reactivation
- **Progressive Disclosure:** Information revealed based on relevance

### **Reactivation Guidance:**
1. **Immediate Action:** Check-in to reactivate automatically
2. **Plan Change:** Option to select new membership plan
3. **Contact Support:** Direct link to gym staff assistance

---

## Implementation Status

✅ **Completed:**
- Model-level inactivity detection methods
- Console command for batch updates
- Enhanced status component with all states
- Client dashboard integration
- Comprehensive documentation

🔄 **Optional Setup:**
- Scheduler configuration in `AppServiceProvider`
- Email notification system
- SMS alert integration
- Custom inactivity thresholds

---

## Usage Instructions

### **Manual Testing:**
```bash
# Test inactivity detection
php artisan memberships:update-inactive

# Check specific member status
$member = GymMember::find(1);
echo $member->hasNoAttendanceForThreeDays() ? 'Inactive' : 'Active';
```

### **Automatic Scheduling:**
```bash
# Add to scheduler (run daily at 2 AM)
$schedule->command('memberships:update-inactive')->dailyAt('02:00');
```

The automatic inactivity status system ensures that membership records accurately reflect member engagement levels and provides clear pathways for reactivation, improving both data accuracy and member retention.
