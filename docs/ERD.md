# Gym Membership Management System - Entity Relationship Diagram (ERD)

## Database Schema Overview

The Gym Management System consists of 5 main entities with their relationships and attributes.

---

## Entities

### 1. Users
**Purpose:** Authentication and user management with role-based access control

**Attributes:**
- `id` (Primary Key, Auto-increment)
- `name` (String, 255) - User's full name
- `email` (String, 255) - Unique email address
- `password` (String, 255) - Hashed password
- `role` (Enum) - User role: 'admin', 'staff', 'client'
- `email_verified_at` (DateTime, nullable) - Email verification timestamp
- `remember_token` (String, 100, nullable) - Remember me token
- `created_at` (DateTime) - Account creation timestamp
- `updated_at` (DateTime) - Last update timestamp

**Relationships:**
- One-to-One with GymMember (if user is a client)
- One-to-Many with MembershipHistory (as admin/staff who made changes)

---

### 2. GymMembers
**Purpose:** Core member information and membership details

**Attributes:**
- `id` (Primary Key, Auto-increment)
- `name` (String, 255) - Member's full name
- `age` (Integer) - Member's age
- `gender` (Enum) - Gender: 'male', 'female', 'other'
- `contact_number` (String, 20) - Phone number
- `membership_plan` (String, 50) - Current plan: 'Basic', 'Standard', 'Premium', 'VIP'
- `start_date` (Date) - Membership start date
- `end_date` (Date) - Membership end date
- `status` (Enum, default 'active') - Status: 'active', 'expired', 'inactive'
- `created_at` (DateTime) - Record creation timestamp
- `updated_at` (DateTime) - Last update timestamp

**Relationships:**
- Many-to-One with Users (foreign key: user_id)
- One-to-Many with Attendance (member can have many attendance records)
- One-to-Many with MembershipHistory (member can have many plan changes)

---

### 3. MembershipHistory
**Purpose:** Track all membership plan changes and modifications

**Attributes:**
- `id` (Primary Key, Auto-increment)
- `gym_member_id` (Foreign Key) - References GymMembers.id
- `previous_plan` (String, 50, nullable) - Previous membership plan
- `new_plan` (String, 50) - New membership Plan
- `previous_price` (Decimal, 8,2, nullable) - Previous plan price
- `new_price` (Decimal, 8,2) - New plan price
- `effective_date` (Date) - When change takes effect
- `notes` (Text, nullable) - Additional notes about the change
- `change_type` (Enum) - Type: 'upgrade', 'downgrade', 'renewal', 'new'
- `created_at` (DateTime) - Record creation timestamp
- `updated_at` (DateTime) - Last update timestamp

**Relationships:**
- Many-to-One with GymMembers (foreign key: gym_member_id)
- Many-to-One with Users (admin/staff who made the change)

---

### 4. Attendance
**Purpose:** Track member check-ins, check-outs, and gym activities

**Attributes:**
- `id` (Primary Key, Auto-increment)
- `gym_member_id` (Foreign Key) - References GymMembers.id
- `check_in_date` (Date) - Date of check-in
- `check_in_time` (Time) - Time of check-in
- `check_out_date` (Date, nullable) - Date of check-out
- `check_out_time` (Time, nullable) - Time of check-out
- `duration_hours` (Decimal, 4,2, nullable) - Total visit duration
- `activity_type` (String, 50, default 'workout') - Type of activity
- `notes` (Text, nullable) - Additional notes about the visit
- `created_at` (DateTime) - Record creation timestamp
- `updated_at` (DateTime) - Last update timestamp

**Relationships:**
- Many-to-One with GymMembers (foreign key: gym_member_id)
- Many-to-One with Users (member who checked in)

---

### 5. Cache (System Table)
**Purpose:** Laravel's caching system

**Attributes:**
- `key` (String, 255) - Cache key
- `value` (Text) - Cached data
- `expiration` (Integer) - Cache expiration time

---

## Relationships Summary

### Primary Relationships
```
Users (1) ──────── (1) GymMembers
  │                    │
  │                    ├── (1) Attendance
  │                    │
  │                    └── (1) MembershipHistory
  │
  └── (1) MembershipHistory (as admin/staff)
```

### Cardinality
- **Users ↔ GymMembers**: One-to-One (A user can have one gym member profile)
- **GymMembers ↔ Attendance**: One-to-Many (A member can have many attendance records)
- **GymMembers ↔ MembershipHistory**: One-to-Many (A member can have many membership changes)
- **Users ↔ MembershipHistory**: One-to-Many (An admin/staff can make many membership changes)

### Foreign Key Constraints
- `attendance.gym_member_id` → `gym_members.id` (CASCADE DELETE)
- `membership_history.gym_member_id` → `gym_members.id` (CASCADE DELETE)

---

## Business Rules

### 1. User Roles
- **Admin**: Full system access, can manage all members, view all data
- **Staff**: Limited access, can manage members, view attendance and activities
- **Client**: Member access, can only view own data, change plan, view attendance

### 2. Membership Plans
- **Basic**: ₱1,499.00/month
- **Standard**: ₱2,499.00/month  
- **Premium**: ₱3,999.00/month
- **VIP**: ₱6,499.00/month

### 3. Status Flow
- **Active**: Current date ≤ end_date
- **Expired**: Current date > end_date
- **Inactive**: Manually set status

### 4. Data Integrity
- All foreign key relationships use CASCADE DELETE
- Membership dates must be logical (start_date ≤ end_date)
- Check-out time must be after check-in time
- Price values stored with 2 decimal places for Philippine Peso

---

## ERD Notation Legend

```
[Entity]          - Entity/Table
PK                 - Primary Key
FK                 - Foreign Key
(1)                - One
(*)                 - Many
---                 - Relationship line
|                   - Attribute
```

---

## Visual ERD Structure

```
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────────┐    ┌─────────────────┐
│     Users      │    │  GymMembers     │    │ MembershipHistory │    │  Attendance    │
├─────────────────┤    ├──────────────────┤    ├─────────────────────┤    ├─────────────────┤
│ PK id           │    │ PK id           │    │ PK id            │    │ PK id           │
│ name            │    │ name            │    │ FK gym_member_id │    │ FK gym_member_id │
│ email           │    │ age             │    │ previous_plan     │    │ check_in_date   │
│ password        │    │ gender           │    │ new_plan         │    │ check_in_time   │
│ role            │    │ contact_number   │    │ previous_price   │    │ check_out_date  │
│ email_verified   │    │ membership_plan │    │ new_price        │    │ duration_hours  │
│ created_at      │    │ start_date      │    │ effective_date   │    │ activity_type   │
│ updated_at      │    │ end_date        │    │ notes            │    │ notes          │
│                 │    │ status          │    │ change_type      │    │ created_at      │
│                 │    │ created_at      │    │ created_at       │    │ updated_at      │
│                 │    │ updated_at      │    │ updated_at       │    │                 │
└─────────────────┘    └──────────────────┘    └─────────────────────┘    └─────────────────┘
         │                      │                      │                    │
         │                      │                      │                    │
         │              (1)       │              (1)                 │
         │                      │                      │                    │
         └──────────────────────┘                      └────────────────────┘
                │                                            │
                │                                            │
                │                                      (1)       │
                │                                            │
                └────────────────────────────────────────────────────┘
```

---

## Index Recommendations

### Primary Indexes
- `users.id` (Primary)
- `users.email` (Unique)
- `gym_members.id` (Primary)
- `attendance.id` (Primary)
- `membership_history.id` (Primary)

### Foreign Key Indexes
- `attendance.gym_member_id`
- `membership_history.gym_member_id`

### Composite Indexes
- `attendance.check_in_date` (For daily attendance reports)
- `membership_history.effective_date` (For change history reports)

---

## Data Flow Examples

### New Member Registration
1. User creates account (Users table)
2. Admin creates gym member profile (GymMembers table)
3. Link established: Users ↔ GymMembers
4. Initial attendance records created (Attendance table)

### Plan Change Process
1. Member requests plan change
2. Staff/Admin processes change
3. Old record created in MembershipHistory
4. GymMembers.plan updated
5. New record created in MembershipHistory

### Daily Attendance Flow
1. Member checks in (Attendance record created)
2. Activity tracked during visit
3. Member checks out (Attendance record updated)
4. Duration calculated automatically

---

## System Architecture Notes

### Security Considerations
- Password hashing implemented via Laravel's built-in authentication
- Role-based access control implemented
- Foreign key constraints prevent orphaned records
- CSRF protection on all forms

### Performance Considerations
- Proper indexing on frequently queried columns
- Cascade deletes maintain data integrity
- Decimal precision for financial calculations
- Date/time separation for better query performance

### Scalability Considerations
- Enum fields limit status/plan options for consistency
- Text fields for flexible notes storage
- Separate history table for audit trail
- Cache table for performance optimization

This ERD provides a comprehensive overview of the Gym Membership Management System's database structure, relationships, and business logic flow.
