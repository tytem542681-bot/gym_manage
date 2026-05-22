# IT9A PROJECT DOCUMENTATION
## GYM MEMBERSHIP MANAGEMENT SYSTEM

---

## 1. COVER PAGE

**Project Title:** Gym Membership Management System

**Course / Subject:** IT9A - Web Application Development

**Instructor:** [Instructor Name]

**Student Name(s):** [Student Names]

**Section:** [Section]

**Date Submitted:** May 22, 2026

---

## 2. BUSINESS CASE

### 2.1 Background of the Study

The fitness industry has experienced significant growth in recent years, with gyms and fitness centers becoming increasingly popular. However, managing gym memberships, attendance tracking, and membership status manually or with outdated systems has become challenging. Gym owners and administrators struggle with:

- **Current Situation:** Many gyms still rely on manual record-keeping or spreadsheets to track membership information, leading to data inconsistencies and difficulty in accessing real-time information.
- **Who is Affected:** Gym administrators, staff members, fitness instructors, and gym members are affected by inefficient management systems.
- **Why a System is Needed:** A digital, automated Gym Membership Management System is needed to streamline operations, improve member experience, track attendance, manage membership renewals, and generate insightful reports.

### 2.2 Problem Statement

1. **Manual Membership Tracking:** Current manual processes are time-consuming and prone to errors, making it difficult to track active, expired, and inactive memberships accurately.

2. **Lack of Attendance Monitoring:** Gym staff cannot efficiently track member attendance, making it difficult to identify inactive members or calculate engagement metrics.

3. **Difficulty in Membership Renewal Management:** There is no automated system to notify members about upcoming membership expiration, leading to lost revenue opportunities.

4. **Inefficient Reporting:** Gym administrators struggle to generate timely reports on membership status, revenue, and member activity without spending significant time on data compilation.

5. **Poor Member Communication:** Members don't have easy access to their membership details, attendance history, or renewal status, leading to dissatisfaction.

### 2.3 Objectives of the System

**General Objective:**
To develop a comprehensive web-based Gym Membership Management System that automates membership tracking, attendance monitoring, and member engagement while providing administrators with powerful reporting and analytics capabilities.

**Specific Objectives:**
- To create a centralized database for storing and managing gym member information securely.
- To implement automatic membership expiration and status management based on predefined business rules.
- To track member attendance and generate attendance reports for performance analysis.
- To provide administrators and staff with user-friendly dashboards for quick access to critical information.
- To enable members to view their profile, membership details, and attendance history.
- To generate automated reports on membership status, revenue, and member activity trends.

### 2.4 Proposed Solution

**Gym Membership Management System** is a Laravel-based web application designed to automate and streamline gym operations.

**What It Does:**
- Manages member registration and membership plans (Basic, Standard, Premium, VIP)
- Tracks member attendance with date/time records
- Automatically updates membership status (Active, Expired, Inactive)
- Provides role-based access (Admin, Staff, Client)
- Generates reports and insights on membership trends

**Who Will Use It:**
- **Admin:** Full system access, user management, and reporting
- **Staff:** Member management, attendance tracking, and basic reporting
- **Members (Clients):** View personal profile, membership status, and attendance history

**Main Features:**
- Member registration and profile management
- Membership plan management with start/end dates
- Attendance tracking system
- Automatic membership expiration after end date
- Role-based access control (RBAC)
- Admin dashboard with key metrics
- Staff interface for member management
- Client portal for viewing personal information
- Automated status updates for inactive members
- User authentication and security

### 2.5 Scope and Limitations

**Scope (Included):**
- Member registration and profile management
- Membership plan assignment and tracking
- Attendance recording and history
- Automatic membership status management
- Role-based user access (Admin, Staff, Client)
- Dashboard with summary metrics
- CRUD operations for all core entities
- User authentication and authorization
- Responsive web interface

**Limitations (Not Included):**
- Payment processing integration (can be added in future phases)
- Mobile application (web-only for phase 1)
- SMS/Email notifications (can be extended)
- Advanced analytics and machine learning
- Integration with external fitness tracking devices
- Multi-branch/location support (single location only)
- Inventory management for gym equipment

---

## 3. ENTITY-RELATIONSHIP DIAGRAM (ERD)

### Entities and Relationships:

```
┌─────────────────────┐
│       Users         │
├─────────────────────┤
│ PK: id              │
│ name                │
│ email (UNIQUE)      │
│ password            │
│ role                │
│ last_login          │
│ created_at          │
└──────────┬──────────┘
           │ 1
           │
           ├──────────────────────────┐
           │                          │
           │ 1:M                      │ 1:M
           │                          │
    ┌──────▼──────────┐      ┌────────▼─────────┐
    │   GymMember     │      │ MembershipHistory│
    ├─────────────────┤      ├──────────────────┤
    │ PK: id          │      │ PK: id           │
    │ name            │      │ FK: gym_member_id│
    │ age             │      │ plan             │
    │ gender          │      │ start_date       │
    │ contact_number  │      │ end_date         │
    │ membership_plan │      │ created_at       │
    │ start_date      │      │ updated_at       │
    │ end_date        │      └──────────────────┘
    │ status          │
    │ created_at      │
    └──────┬──────────┘
           │ 1
           │ 1:M
           │
    ┌──────▼───────────┐
    │   Attendance     │
    ├──────────────────┤
    │ PK: id           │
    │ FK: gym_member_id│
    │ check_in_time    │
    │ check_out_time   │
    │ date             │
    │ created_at       │
    └──────────────────┘
```

**Brief Explanation:**

- **Users ↔ GymMember:** One user can manage many gym members (staff/admin relationship). Each gym member is associated with user registration for login.

- **GymMember ↔ MembershipHistory:** One gym member has many membership history records. This tracks all membership changes, plans, and periods for a single member.

- **GymMember ↔ Attendance:** One gym member has many attendance records. This maintains a complete history of every check-in and check-out for each member.

- **MembershipHistory:** Maintains historical records of membership changes, allowing admins to track when members upgraded/downgraded plans or renewed memberships.

---

## 4. DATA DICTIONARY

### Table: users
| Field Name | Data Type | Description | Constraints |
|---|---|---|---|
| id | INT | Unique user identifier | PK, Auto Increment |
| name | VARCHAR(255) | Full name of the user | NOT NULL |
| email | VARCHAR(255) | User email address | NOT NULL, UNIQUE |
| email_verified_at | TIMESTAMP | Email verification timestamp | NULLABLE |
| password | VARCHAR(255) | Hashed password | NOT NULL |
| role | VARCHAR(50) | User role | NOT NULL, DEFAULT: 'client' |
| last_login | TIMESTAMP | Last login timestamp | NULLABLE |
| remember_token | VARCHAR(100) | Authentication token | NULLABLE |
| created_at | TIMESTAMP | Record creation date | DEFAULT: CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Record last update date | DEFAULT: CURRENT_TIMESTAMP |

### Table: gym_members
| Field Name | Data Type | Description | Constraints |
|---|---|---|---|
| id | INT | Unique member identifier | PK, Auto Increment |
| name | VARCHAR(255) | Member full name | NOT NULL |
| age | INT | Member age | NULLABLE |
| gender | VARCHAR(10) | Member gender | NULLABLE, Enum: male/female |
| contact_number | VARCHAR(20) | Contact phone number | NULLABLE |
| membership_plan | VARCHAR(50) | Membership plan type | NOT NULL, Enum: Basic/Standard/Premium/VIP |
| start_date | DATE | Membership start date | NOT NULL |
| end_date | DATE | Membership end date | NOT NULL |
| status | VARCHAR(20) | Member status | NOT NULL, Enum: active/expired/inactive |
| created_at | TIMESTAMP | Record creation date | DEFAULT: CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Record last update date | DEFAULT: CURRENT_TIMESTAMP |

### Table: membership_history
| Field Name | Data Type | Description | Constraints |
|---|---|---|---|
| id | INT | Unique history record ID | PK, Auto Increment |
| gym_member_id | INT | Reference to gym member | FK, NOT NULL |
| plan | VARCHAR(50) | Membership plan | NOT NULL |
| start_date | DATE | Plan start date | NOT NULL |
| end_date | DATE | Plan end date | NOT NULL |
| created_at | TIMESTAMP | Record creation date | DEFAULT: CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Record last update date | DEFAULT: CURRENT_TIMESTAMP |

### Table: attendance
| Field Name | Data Type | Description | Constraints |
|---|---|---|---|
| id | INT | Unique attendance record ID | PK, Auto Increment |
| gym_member_id | INT | Reference to gym member | FK, NOT NULL |
| date | DATE | Attendance date | NOT NULL |
| check_in_time | TIME | Check-in time | NOT NULL |
| check_out_time | TIME | Check-out time | NULLABLE |
| created_at | TIMESTAMP | Record creation date | DEFAULT: CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Record last update date | DEFAULT: CURRENT_TIMESTAMP |

---

## 5. PROCESS FLOW DIAGRAM

### 5.1 User Login Process

```
Start
  ↓
User Opens Application
  ↓
User Enters Email & Password
  ↓
System Validates Credentials
  ├─→ Invalid? → Display Error Message → Return to Login
  │
  └─→ Valid? ↓
System Checks User Role
  ├─→ Admin Role? → Redirect to Admin Dashboard
  ├─→ Staff Role? → Redirect to Staff Dashboard
  └─→ Client Role? → Redirect to Client Dashboard
  ↓
Update Last Login Timestamp
  ↓
End
```

### 5.2 Member Registration Process (Admin/Staff)

```
Start
  ↓
Admin/Staff Opens Member Registration Form
  ↓
Enter Member Information
  • Name, Age, Gender, Contact
  • Select Membership Plan
  • Set Start & End Dates
  ↓
System Validates Input
  ├─→ Invalid Data? → Show Error → Back to Form
  │
  └─→ Valid? ↓
Create Member Record in Database
  ↓
Set Status = "Active"
  ↓
Create Initial Membership History Record
  ↓
Display Success Message
  ↓
Redirect to Member List
  ↓
End
```

### 5.3 Attendance Recording Process

```
Start
  ↓
Member Scans ID / Staff Enters Member ID
  ↓
System Searches for Member
  ├─→ Not Found? → Show Error
  │
  └─→ Found? ↓
Check Member Status
  ├─→ Expired or Inactive? → Show Warning
  │
  └─→ Active? ↓
Check if Already Checked In Today
  ├─→ Yes → Record Check-Out Time
  │
  └─→ No → Record Check-In Time
  ↓
Save Attendance Record
  ↓
Display Confirmation Message
  ↓
End
```

### 5.4 Automatic Membership Status Update Process

```
Start (Daily Job - Scheduled)
  ↓
Fetch All Members with Active Status
  ↓
For Each Member:
  ├─→ Check if end_date < Today
  │   ├─→ Yes? → Update Status = "Expired"
  │   │
  │   └─→ No? ↓
  ├─→ Check Last Attendance Date
  │   ├─→ No Attendance for 30+ Days? 
  │   │   ├─→ Yes? → Update Status = "Inactive"
  │   │   │
  │   │   └─→ No? → Keep Status = "Active"
  │
  └─→ End Loop
  ↓
Log Update Summary
  ↓
End
```

---

## 6. DASHBOARD UI SCREENSHOTS & DESCRIPTIONS

### 6.1 Admin Dashboard

**Key Information Displayed:**
- Total active members count
- Total expired memberships count
- Inactive members count
- Monthly new registrations chart
- Revenue by membership plan
- Recent member registrations (table)
- Recent attendance records

**Why It's Important:**
- Provides executive summary of gym operations
- Helps identify trends and member activity
- Enables quick decision-making based on key metrics

---

## 7. MAIN TRANSACTION PROTOTYPES

### 7.1 Member Management - Create (Add New Member)

**Screen Components:**
- Form Title: "Add New Member"
- Input Fields:
  - Member Name (text input)
  - Age (number input)
  - Gender (dropdown: Male/Female)
  - Contact Number (phone input)
  - Membership Plan (dropdown: Basic/Standard/Premium/VIP)
  - Start Date (date picker)
  - End Date (date picker)
  - Status (dropdown: Active/Expired/Inactive)
- Buttons: [Save] [Cancel] [Clear]

**Process:**
1. Staff clicks "Add Member" button
2. Form opens with empty fields
3. Staff fills in all required information
4. System validates input on submission
5. If valid, record saved to database
6. Success message displayed
7. Redirect to member list

---

### 7.2 Member Management - Read (View/List Members)

**Screen Components:**
- Table with columns:
  - Member ID
  - Name
  - Contact Number
  - Membership Plan
  - Start Date
  - End Date
  - Status (badge: Active/Expired/Inactive)
  - Actions (Edit, View, Delete)
- Search & Filter options:
  - Search by name
  - Filter by status
  - Filter by membership plan
- Pagination controls

**Process:**
1. Admin/Staff opens Member List
2. System displays all members in table
3. User can search, filter, or sort data
4. Click "View" to see detailed member profile
5. Click "Edit" to modify member information
6. Click "Delete" to remove member

---

### 7.3 Member Management - Update (Edit Member)

**Screen Components:**
- Form Title: "Edit Member - [Member Name]"
- All input fields from Create screen (pre-populated with current data)
- Buttons: [Update] [Cancel] [Delete]

**Process:**
1. Staff clicks "Edit" on member from list
2. Form loads with existing member data
3. Staff modifies necessary fields
4. System validates updated information
5. If valid, changes saved to database
6. Success message displayed
7. Redirect to member list or detail view

---

### 7.4 Attendance Recording

**Screen Components:**
- Member Search/ID Input
- Display:
  - Member Name
  - Current Status
  - Last Check-In Time
  - Today's Check-In Status
- Quick Action Buttons:
  - [Check In]
  - [Check Out]
  - [View Today's Attendance]

**Process:**
1. Staff opens Attendance page
2. Enters or scans member ID
3. System displays member information
4. Staff clicks "Check In" or "Check Out"
5. System records timestamp
6. Confirmation message displayed
7. Member information refreshed

---

### 7.5 Membership History View

**Screen Components:**
- Member Name and current status
- Table showing:
  - Plan type
  - Start date
  - End date
  - Duration
  - Created date
- [Add New Membership] button
- [Back to Member] link

**Process:**
1. Admin/Staff clicks "View History" on member
2. System displays all past and current membership records
3. Sorted by most recent first
4. Can click on each record for details
5. Can add new membership plan for member

---

## 8. BUSINESS LOGIC & RULES

### 8.1 Membership Status Rules

- **Active:** Membership start_date ≤ today ≤ end_date AND attendance within last 30 days
- **Expired:** end_date < today (regardless of attendance)
- **Inactive:** start_date ≤ today ≤ end_date BUT no attendance in last 30 days

### 8.2 Membership Plans

| Plan | Duration | Price Range | Features |
|---|---|---|---|
| Basic | 1 Month | $20-30 | Gym access during off-peak hours |
| Standard | 3 Months | $50-70 | Full gym access |
| Premium | 6 Months | $100-150 | Full access + personal trainer consultation |
| VIP | 12 Months | $200-300 | All premium features + priority support |

### 8.3 Role Permissions

**Admin:**
- View all members and attendance
- Manage members (CRUD)
- Generate reports
- Manage staff accounts
- System settings
- View financial reports

**Staff:**
- View all members
- Add/edit members
- Record attendance
- View basic reports
- Cannot access financial or staff management

**Client:**
- View own profile
- View own attendance history
- View own membership status and renewal date
- Cannot edit personal information directly

---

## 9. SYSTEM REQUIREMENTS

### 9.1 Functional Requirements
1. User authentication and authorization
2. Member profile management
3. Membership plan tracking
4. Attendance recording and tracking
5. Automatic status updates
6. Report generation
7. Dashboard with key metrics

### 9.2 Non-Functional Requirements
- **Security:** Password encryption, role-based access control
- **Performance:** Response time < 2 seconds for all queries
- **Scalability:** Support up to 1000+ members
- **Reliability:** 99% uptime
- **Usability:** Intuitive UI, accessible on desktop/tablet browsers

---

## 10. TECHNOLOGY STACK

- **Backend:** PHP with Laravel Framework
- **Frontend:** Blade templating, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **Server:** Apache/Nginx
- **Version Control:** Git

---

## 11. DEPLOYMENT

The system is configured for deployment on **Render** with the following steps:

1. Push code changes to GitHub repository: `https://github.com/tytem542681-bot/gym_manage.git`
2. Connect Render to GitHub repository
3. Run migrations: `php artisan migrate`
4. Run seeders: `php artisan db:seed`
5. Application goes live

**Credentials for Testing:**
- Admin: `admin@gmail.com` / `password`
- Staff: `staff@gmail.com` / `password`
- Client: `client@gmail.com` / `password`

---

## 12. FUTURE ENHANCEMENTS

- Payment integration (Stripe/PayPal)
- Mobile application
- SMS/Email notifications for membership renewal
- Advanced analytics and reporting
- Integration with fitness tracking devices
- Multi-branch support
- Instructor scheduling system
- Equipment inventory management
- Class/trainer session booking

---

**End of Documentation**
