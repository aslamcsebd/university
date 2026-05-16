# 🎓 Academic Timetable Module

> A **Laravel 13** web application for managing the full academic scheduling lifecycle —
> departments, courses, subjects, semesters, buildings, rooms, staff and timetable slots.
> Built with a clean sidebar-driven UI, Breeze auth, and a live overview dashboard.

```
URL:      http://127.0.0.1:8000
Email:    admin@gmail.com
Password: 123456789
```

---

## ⚡ Tech Stack

| Layer      | Technology                          |
|------------|-------------------------------------|
| Backend    | PHP 8.5 · Laravel 13.8              |
| Auth       | Laravel Breeze 2.4 (Blade stack)    |
| Frontend   | Blade · Tailwind CSS v4 · Alpine.js |
| Build      | Vite 8                              |
| Database   | MySQL                               |

---

## 🗂️ Navigation Tree

```
🖥️  SIDEBAR NAVIGATION
│
├── 🎓  ACADEMY DASHBOARD  (/academic/*)
│   ├── 🏛️  Departments          /academic/departments
│   ├── 🎓  Courses              /academic/courses
│   ├── 📖  Subjects             /academic/subjects
│   ├── 📅  Semesters            /academic/semesters
│   ├── 🏢  Buildings            /academic/buildings
│   ├── 🏫  Rooms                /academic/rooms
│   ├── 👤  Staff                /academic/staff
│   ├── 🗓️  Timetable            /academic/timetable
│   ├── 📊  Overview             /academic/overview
│   └── 🌳  Nav Tree             /academic/tree
│
├── 🧑🎓  STUDENT PANEL  (/student/*)
│   ├── 🏠  Dashboard            /student/dashboard
│   ├── 📆  Class Schedules      /student/class-schedules
│   ├── 📝  Exam Schedules       /student/exam-schedules
│   ├── ✅  Attendances          /student/attendances
│   ├── 🏖️  Apply Leaves         /student/apply-leaves
│   ├── 💳  Fees Reports         /student/fees-reports
│   ├── 📚  Library              /student/library
│   ├── 📢  Notices              /student/notices
│   ├── 📋  Assignments          /student/assignments
│   ├── ⬇️  Downloads            /student/downloads
│   ├── 🎖️  Transcript           /student/transcript
│   └── 👤  My Profile           /student/my-profile
│
└── 🗂️  ADVANCED NAVIGATION  (expandable inline)
    ├── 🏠  Dashboard
    ├── 📋  Admission  (8)
    │   ├── Applications
    │   ├── New Registration
    │   ├── Student List
    │   ├── Transfers  (2)
    │   │   ├── Transfer In
    │   │   └── Transfer Out
    │   ├── Status Types
    │   ├── ID Cards
    │   └── Settings  (1)
    │       └── ID Card Setting
    ├── 🧑🎓  Students  (9)
    │   ├── Attendances  (2)
    │   │   ├── Subject Attendances
    │   │   └── Attendance Reports
    │   ├── Manage Leave
    │   ├── Student Notes
    │   ├── Enrollments  (4)
    │   │   ├── Single Enroll
    │   │   ├── Group Enrolls
    │   │   ├── Course Add Drop
    │   │   └── Course Graduation
    │   └── Alumni List
    ├── 🏛️  Academic  (9)
    │   ├── Faculties
    │   ├── Programs
    │   ├── Batches
    │   ├── Sessions
    │   ├── Semesters
    │   ├── Sections
    │   ├── Class Rooms
    │   ├── Courses
    │   └── Enroll Courses
    ├── 📆  Routines  (7)
    │   ├── Manage Classes
    │   ├── Class Schedules
    │   ├── Manage Exams
    │   ├── Exam Schedules
    │   ├── Teacher Routines
    │   └── Settings  (2)
    │       ├── Class Schedule
    │       └── Exam Schedule
    ├── 📝  Examinations  (10)
    │   ├── Exam Attendances
    │   ├── Exam Mark Ledger
    │   ├── Exam Results
    │   ├── Course Mark Ledger
    │   ├── Course Results
    │   ├── Grading Systems
    │   ├── Exam Types
    │   ├── Admit Cards
    │   └── Settings  (2)
    │       ├── Admit Setting
    │       └── Mark Distribution
    ├── 📚  Study Materials  (3)
    │   ├── Assignments
    │   ├── Content List
    │   └── Content Types
    ├── 💳  Fees Collection  (11)
    │   ├── Student Fees  (4)
    │   │   ├── Fees Due
    │   │   ├── Quick Assign
    │   │   ├── Quick Received
    │   │   └── Fees Reports
    │   ├── Assign Group Fees
    │   ├── Assigned History
    │   ├── Fees Types
    │   ├── Fees Discounts
    │   ├── Fees Fines
    │   └── Settings  (1)
    │       └── Receipt Setting
    ├── 👥  Human Resources  (9)
    │   ├── Staff List
    │   ├── Staff Notes
    │   ├── Payrolls
    │   ├── Payroll Reports
    │   ├── Work Shift Types
    │   ├── Designations
    │   ├── Departments
    │   └── Settings  (2)
    │       ├── Tax Settings
    │       └── Pay Slip Setting
    ├── ✅  Staff Attendances  (4)
    │   ├── Daily Attendances
    │   ├── Daily Reports
    │   ├── Hourly Attendances
    │   └── Hourly Reports
    ├── 🏖️  Leave Manager  (4)
    │   ├── Apply Leave
    │   ├── My Leaves
    │   ├── Leave Types
    │   └── Manage Leave
    ├── 💰  Accounts  (5)
    │   ├── Income List
    │   ├── Income Categories
    │   ├── Expense List
    │   ├── Expense Categories
    │   └── Outcome Overview
    ├── 📢  Communicates  (6)
    │   ├── Send Email
    │   ├── Send SMS
    │   ├── Event List
    │   ├── Calendar
    │   ├── Notice List
    │   └── Notice Categories
    ├── 📖  Library  (10)
    │   ├── Issue Book
    │   ├── Issue & Return
    │   ├── Members  (3)
    │   │   ├── Student List
    │   │   ├── Staff List
    │   │   └── Outsider List
    │   ├── Book List
    │   ├── Book Requests
    │   ├── Book Categories
    │   └── Settings  (1)
    │       └── Card Setting
    ├── 📦  Inventory  (7)
    │   ├── Issue Item
    │   ├── Issue & Return
    │   ├── Item Stocks
    │   ├── Item List
    │   ├── Stores
    │   ├── Suppliers
    │   └── Categories
    ├── 🏠  Hostels  (6)
    │   ├── Members  (2)
    │   │   ├── Student List
    │   │   └── Staff List
    │   ├── Hostel Rooms
    │   ├── Hostel List
    │   └── Room Types
    ├── 🚌  Transports  (4)
    │   ├── Members  (2)
    │   │   ├── Student List
    │   │   └── Staff List
    │   ├── Vehicles
    │   └── Routes
    ├── 🖥️  Front Desk  (14)
    │   ├── Visitor Logs
    │   ├── Phone Logs
    │   ├── Enquiry List
    │   ├── Complain List
    │   ├── Postal Exchanges
    │   ├── Meeting Schedules
    │   └── Settings  (8)
    │       ├── Visit Purposes
    │       ├── Token Settings
    │       ├── Enquiry Sources
    │       ├── Enquiry References
    │       ├── Complain Types
    │       ├── Complain Sources
    │       ├── Postal Types
    │       └── Meeting Types
    ├── 🎖️  Transcripts  (5)
    │   ├── Semester Marksheets
    │   ├── Total Marksheets
    │   ├── Marksheet Setting
    │   ├── Certificates
    │   └── Certificate Templates
    ├── 📊  Reports  (15)
    │   ├── Student Progress
    │   ├── Course Students
    │   ├── Student Attendance
    │   ├── Subject Attendance
    │   ├── Collected Fees
    │   ├── Student Fees
    │   ├── Salary Paid
    │   ├── Staff Leaves
    │   ├── Total Income
    │   ├── Total Expense
    │   ├── Library History
    │   ├── Book Return Due
    │   ├── Inventory History
    │   ├── Hostel Members
    │   └── Transport Members
    ├── 🌐  Front Web  (13)
    │   ├── Contact Setting
    │   ├── Social Setting
    │   ├── Sliders
    │   ├── About Us
    │   ├── Features
    │   ├── Courses
    │   ├── Event
    │   ├── News
    │   ├── Faqs
    │   ├── Gallery
    │   ├── Testimonials
    │   ├── Footer Pages
    │   └── Call To Action
    ├── ⚙️  Settings  (12)
    │   ├── General
    │   ├── States/Provinces
    │   ├── Districts/Cities
    │   ├── Languages
    │   ├── Mail Setting
    │   ├── SMS Getaways
    │   ├── Payment Getaways
    │   ├── Online Application
    │   ├── Roles and Permissions
    │   ├── Field Settings  (3)
    │   │   ├── Staffs
    │   │   ├── Students
    │   │   └── Applications
    │   └── Student Panel
    └── 👤  My Profile
```

| Panel              | Top-level Groups | Total Items |
|--------------------|:----------------:|:-----------:|
| Academy Dashboard  | —                | 10          |
| Student Panel      | —                | 12          |
| Advanced Nav       | 22               | 147         |
| **Grand Total**    |                  | **169**     |
