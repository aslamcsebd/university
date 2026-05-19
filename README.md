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

## 🗂️ All Sidebar Pages (Top → Bottom)

### 🏛️ Academic Dashboard Sidebar (`/academic/*`)

| # | Page | URL |
|---|------|-----|
| 1 | 📊 Overview | `/academic/overview` |
| 2 | 🌳 Nav Tree | `/academic/tree` |
| **🏛️ Academic** | | |
| 3 | Departments | `/academic/departments` |
| 4 | Courses | `/academic/courses` |
| 5 | Subjects | `/academic/subjects` |
| 6 | Semesters | `/academic/semesters` |
| 7 | Faculties | `/academic-ext/faculties` |
| 8 | Programs | `/academic-ext/programs` |
| 9 | Batches | `/academic-ext/batches` |
| 10 | Sessions | `/academic-ext/sessions` |
| 11 | Sections | `/academic-ext/sections` |
| 12 | Class Rooms | `/academic-ext/class-rooms` |
| 13 | Enroll Courses | `/academic-ext/enroll-courses` |
| **🗓️ Timetable** | | |
| 14 | Timetable | `/academic/timetable` |
| 15 | Manage Classes | `/routines/manage-classes` |
| 16 | Class Schedules | `/routines/class-schedules` |
| 17 | Manage Exams | `/routines/manage-exams` |
| 18 | Exam Schedules | `/routines/exam-schedules` |
| 19 | Teacher Routines | `/routines/teacher-routines` |
| 20 | Class Schedule (setting) | `/routines/class-schedule-setting` |
| 21 | Exam Schedule (setting) | `/routines/exam-schedule-setting` |
| **📝 Examinations** | | |
| 22 | Exam Attendances | `/examinations/exam-attendances` |
| 23 | Exam Mark Ledger | `/examinations/exam-mark-ledger` |
| 24 | Exam Results | `/examinations/exam-results` |
| 25 | Course Mark Ledger | `/examinations/course-mark-ledger` |
| 26 | Course Results | `/examinations/course-results` |
| 27 | Grading Systems | `/examinations/grading-systems` |
| 28 | Exam Types | `/examinations/exam-types` |
| 29 | Admit Cards | `/examinations/admit-cards` |
| 30 | Admit Setting | `/examinations/admit-setting` |
| 31 | Mark Distribution | `/examinations/mark-distribution` |
| **🧑🎓 Students** | | |
| 32 | Applications | `/admission/applications` |
| 33 | New Registration | `/admission/new-registration` |
| 34 | Student List | `/admission/student-list` |
| 35 | Transfer In | `/admission/transfer-in` |
| 36 | Transfer Out | `/admission/transfer-out` |
| 37 | Status Types | `/admission/status-types` |
| 38 | ID Cards | `/admission/id-cards` |
| 39 | ID Card Setting | `/admission/id-card-setting` |
| 40 | Attendances | `/student/attendances` |
| 41 | Subject Attendances | `/students/subject-attendances` |
| 42 | Attendance Reports | `/students/attendance-reports` |
| 43 | Manage Leave | `/students/manage-leave` |
| 44 | Student Notes | `/students/student-notes` |
| 45 | Alumni List | `/students/alumni-list` |
| 46 | Single Enroll | `/students/single-enroll` |
| 47 | Group Enrolls | `/students/group-enrolls` |
| 48 | Course Add Drop | `/students/course-add-drop` |
| 49 | Course Graduation | `/students/course-graduation` |
| **📖 Study Materials** | | |
| 50 | Assignments | `/study/assignments` |
| 51 | Content List | `/study/content-list` |
| 52 | Content Types | `/study/content-types` |
| 53 | Downloads | `/study/downloads` |
| **👥 Staff** | | |
| 54 | Staff | `/academic/staff` |
| 55 | Staff List | `/staff/staff-list` |
| 56 | Staff Notes | `/staff/staff-notes` |
| 57 | Payrolls | `/staff/payrolls` |
| 58 | Payroll Reports | `/staff/payroll-reports` |
| 59 | Work Shift Types | `/staff/work-shift-types` |
| 60 | Designations | `/staff/designations` |
| 61 | Departments | `/staff/departments` |
| 62 | Tax Settings | `/staff/tax-settings` |
| 63 | Pay Slip Setting | `/staff/pay-slip-setting` |
| 64 | Daily Attendances | `/staff/daily-attendances` |
| 65 | Daily Reports | `/staff/daily-reports` |
| 66 | Hourly Attendances | `/staff/hourly-attendances` |
| 67 | Hourly Reports | `/staff/hourly-reports` |
| 68 | Apply Leave | `/staff/apply-leave` |
| 69 | My Leaves | `/staff/my-leaves` |
| 70 | Leave Types | `/staff/leave-types` |
| 71 | Manage Leave | `/staff/manage-leave` |
| **🏢 Facilities** | | |
| 72 | Buildings | `/academic/buildings` |
| 73 | Rooms | `/academic/rooms` |
| 74 | Hostel List | `/facilities/hostel-list` |
| 75 | Hostel Rooms | `/facilities/hostel-rooms` |
| 76 | Room Types | `/facilities/room-types` |
| 77 | Hostel Students | `/facilities/hostel-students` |
| 78 | Hostel Staff | `/facilities/hostel-staff` |
| 79 | Vehicles | `/facilities/vehicles` |
| 80 | Routes | `/facilities/routes` |
| 81 | Transport Students | `/facilities/transport-students` |
| 82 | Transport Staff | `/facilities/transport-staff` |
| **💳 Finance** | | |
| 83 | Fees Due | `/finance/fees-due` |
| 84 | Quick Assign | `/finance/quick-assign` |
| 85 | Quick Received | `/finance/quick-received` |
| 86 | Fees Reports | `/finance/fees-reports` |
| 87 | Assign Group Fees | `/finance/assign-group-fees` |
| 88 | Assigned History | `/finance/assigned-history` |
| 89 | Fees Types | `/finance/fees-types` |
| 90 | Fees Discounts | `/finance/fees-discounts` |
| 91 | Fees Fines | `/finance/fees-fines` |
| 92 | Receipt Setting | `/finance/receipt-setting` |
| 93 | Income List | `/finance/income-list` |
| 94 | Income Categories | `/finance/income-categories` |
| 95 | Expense List | `/finance/expense-list` |
| 96 | Expense Categories | `/finance/expense-categories` |
| 97 | Outcome Overview | `/finance/outcome-overview` |
| **📚 Library** | | |
| 98 | Library | `/student/library` |
| 99 | Issue Book | `/library-mgmt/issue-book` |
| 100 | Issue & Return | `/library-mgmt/issue-return` |
| 101 | Book List | `/library-mgmt/book-list` |
| 102 | Book Requests | `/library-mgmt/book-requests` |
| 103 | Book Categories | `/library-mgmt/book-categories` |
| 104 | Book Return Due | `/library-mgmt/book-return-due` |
| 105 | Student Members | `/library-mgmt/student-members` |
| 106 | Staff Members | `/library-mgmt/staff-members` |
| 107 | Outsider Members | `/library-mgmt/outsider-members` |
| 108 | Card Setting | `/library-mgmt/card-setting` |
| **📦 Inventory** | | |
| 109 | Issue Item | `/inventory/issue-item` |
| 110 | Issue & Return | `/inventory/issue-return` |
| 111 | Item Stocks | `/inventory/item-stocks` |
| 112 | Item List | `/inventory/item-list` |
| 113 | Stores | `/inventory/stores` |
| 114 | Suppliers | `/inventory/suppliers` |
| 115 | Categories | `/inventory/categories` |
| **🖥️ Front Desk** | | |
| 116 | Visitor Logs | `/frontdesk/visitor-logs` |
| 117 | Phone Logs | `/frontdesk/phone-logs` |
| 118 | Enquiry List | `/frontdesk/enquiry-list` |
| 119 | Complain List | `/frontdesk/complain-list` |
| 120 | Postal Exchanges | `/frontdesk/postal-exchanges` |
| 121 | Meeting Schedules | `/frontdesk/meeting-schedules` |
| 122 | Visit Purposes | `/frontdesk/visit-purposes` |
| 123 | Token Settings | `/frontdesk/token-settings` |
| 124 | Enquiry Sources | `/frontdesk/enquiry-sources` |
| 125 | Enquiry References | `/frontdesk/enquiry-references` |
| 126 | Complain Types | `/frontdesk/complain-types` |
| 127 | Complain Sources | `/frontdesk/complain-sources` |
| 128 | Postal Types | `/frontdesk/postal-types` |
| 129 | Meeting Types | `/frontdesk/meeting-types` |
| **🎓 Student Panel** | | |
| 130 | Dashboard | `/student/dashboard` |
| 131 | Class Schedules | `/student/class-schedules` |
| 132 | Exam Schedules | `/student/exam-schedules` |
| 133 | Apply Leaves | `/student/apply-leaves` |
| 134 | Notices | `/student/notices` |
| 135 | Transcript | `/student/transcript` |
| 136 | My Profile | `/student/my-profile` |
| **🎖️ Transcripts** | | |
| 137 | Semester Marksheets | `/transcripts/semester-marksheets` |
| 138 | Total Marksheets | `/transcripts/total-marksheets` |
| 139 | Marksheet Setting | `/transcripts/marksheet-setting` |
| 140 | Certificates | `/transcripts/certificates` |
| 141 | Certificate Templates | `/transcripts/certificate-templates` |
| **📊 Reports** | | |
| 142 | Student Progress | `/reports/student-progress` |
| 143 | Course Students | `/reports/course-students` |
| 144 | Student Attendance | `/reports/student-attendance` |
| 145 | Subject Attendance | `/reports/subject-attendance` |
| 146 | Collected Fees | `/reports/collected-fees` |
| 147 | Student Fees | `/reports/student-fees` |
| 148 | Salary Paid | `/reports/salary-paid` |
| 149 | Staff Leaves | `/reports/staff-leaves` |
| 150 | Total Income | `/reports/total-income` |
| 151 | Total Expense | `/reports/total-expense` |
| 152 | Library History | `/reports/library-history` |
| 153 | Book Return Due | `/reports/book-return-due` |
| 154 | Inventory History | `/reports/inventory-history` |
| 155 | Hostel Members | `/reports/hostel-members` |
| 156 | Transport Members | `/reports/transport-members` |
| **📢 Communicate** | | |
| 157 | Send Email | `/communicate/send-email` |
| 158 | Send SMS | `/communicate/send-sms` |
| 159 | Event List | `/communicate/event-list` |
| 160 | Calendar | `/communicate/calendar` |
| 161 | Notice List | `/communicate/notice-list` |
| 162 | Notice Categories | `/communicate/notice-categories` |
| **🌐 Front Web** | | |
| 163 | Contact Setting | `/frontweb/contact-setting` |
| 164 | Social Setting | `/frontweb/social-setting` |
| 165 | Sliders | `/frontweb/sliders` |
| 166 | About Us | `/frontweb/about-us` |
| 167 | Features | `/frontweb/features` |
| 168 | Courses | `/frontweb/courses` |
| 169 | Event | `/frontweb/event` |
| 170 | News | `/frontweb/news` |
| 171 | Faqs | `/frontweb/faqs` |
| 172 | Gallery | `/frontweb/gallery` |
| 173 | Testimonials | `/frontweb/testimonials` |
| 174 | Footer Pages | `/frontweb/footer-pages` |
| 175 | Call To Action | `/frontweb/call-to-action` |
| **⚙️ Settings** | | |
| 176 | General | `/settings/general` |
| 177 | States/Provinces | `/settings/states-provinces` |
| 178 | Districts/Cities | `/settings/districts-cities` |
| 179 | Languages | `/settings/languages` |
| 180 | Mail Setting | `/settings/mail-setting` |
| 181 | SMS Getaways | `/settings/sms-getaways` |
| 182 | Payment Getaways | `/settings/payment-getaways` |
| 183 | Online Application | `/settings/online-application` |
| 184 | Roles & Permissions | `/settings/roles-permissions` |
| 185 | Staffs Fields | `/settings/staffs-fields` |
| 186 | Students Fields | `/settings/students-fields` |
| 187 | Applications Fields | `/settings/applications-fields` |
| 188 | Student Panel | `/settings/student-panel` |

---

### 🧑🎓 Student Panel Sidebar (`/student/*`)

| # | Page | URL |
|---|------|-----|
| 1 | 🏠 Dashboard | `/student/dashboard` |
| 2 | 📆 Class Schedules | `/student/class-schedules` |
| 3 | 📝 Exam Schedules | `/student/exam-schedules` |
| 4 | ✅ Attendances | `/student/attendances` |
| 5 | 🏖️ Apply Leaves | `/student/apply-leaves` |
| 6 | 💳 Fees Reports | `/student/fees-reports` |
| 7 | 📚 Library | `/student/library` |
| 8 | 📢 Notices | `/student/notices` |
| 9 | 📋 Assignments | `/student/assignments` |
| 10 | ⬇️ Downloads | `/student/downloads` |
| 11 | 🎖️ Transcript | `/student/transcript` |
| 12 | 👤 My Profile | `/student/my-profile` |

---

### 🗂️ Advanced Navigation Sidebar (`advanced-nav` layout)

| # | Page | URL |
|---|------|-----|
| 1 | 🏠 Dashboard | `/dashboard` |
| **📋 Admission** | | |
| 2 | Applications | `/admission/applications` |
| 3 | New Registration | `/admission/new-registration` |
| 4 | Student List | `/admission/student-list` |
| 5 | Transfer In | `/admission/transfer-in` |
| 6 | Transfer Out | `/admission/transfer-out` |
| 7 | Status Types | `/admission/status-types` |
| 8 | ID Cards | `/admission/id-cards` |
| 9 | ID Card Setting | `/admission/id-card-setting` |
| **🧑🎓 Students** | | |
| 10 | Subject Attendances | `/students/subject-attendances` |
| 11 | Attendance Reports | `/students/attendance-reports` |
| 12 | Manage Leave | `/students/manage-leave` |
| 13 | Student Notes | `/students/student-notes` |
| 14 | Single Enroll | `/students/single-enroll` |
| 15 | Group Enrolls | `/students/group-enrolls` |
| 16 | Course Add Drop | `/students/course-add-drop` |
| 17 | Course Graduation | `/students/course-graduation` |
| 18 | Alumni List | `/students/alumni-list` |
| **🏛️ Academic** | | |
| 19 | Faculties | `/academic-ext/faculties` |
| 20 | Programs | `/academic-ext/programs` |
| 21 | Batches | `/academic-ext/batches` |
| 22 | Sessions | `/academic-ext/sessions` |
| 23 | Semesters | `/academic/semesters` |
| 24 | Sections | `/academic-ext/sections` |
| 25 | Class Rooms | `/academic-ext/class-rooms` |
| 26 | Courses | `/academic/courses` |
| 27 | Enroll Courses | `/academic-ext/enroll-courses` |
| **📆 Routines** | | |
| 28 | Manage Classes | `/routines/manage-classes` |
| 29 | Class Schedules | `/routines/class-schedules` |
| 30 | Manage Exams | `/routines/manage-exams` |
| 31 | Exam Schedules | `/routines/exam-schedules` |
| 32 | Teacher Routines | `/routines/teacher-routines` |
| 33 | Class Schedule (setting) | `/routines/class-schedule-setting` |
| 34 | Exam Schedule (setting) | `/routines/exam-schedule-setting` |
| **📝 Examinations** | | |
| 35 | Exam Attendances | `/examinations/exam-attendances` |
| 36 | Exam Mark Ledger | `/examinations/exam-mark-ledger` |
| 37 | Exam Results | `/examinations/exam-results` |
| 38 | Course Mark Ledger | `/examinations/course-mark-ledger` |
| 39 | Course Results | `/examinations/course-results` |
| 40 | Grading Systems | `/examinations/grading-systems` |
| 41 | Exam Types | `/examinations/exam-types` |
| 42 | Admit Cards | `/examinations/admit-cards` |
| 43 | Admit Setting | `/examinations/admit-setting` |
| 44 | Mark Distribution | `/examinations/mark-distribution` |
| **📚 Study Materials** | | |
| 45 | Assignments | `/study/assignments` |
| 46 | Content List | `/study/content-list` |
| 47 | Content Types | `/study/content-types` |
| **💳 Fees Collection** | | |
| 48 | Fees Due | `/finance/fees-due` |
| 49 | Quick Assign | `/finance/quick-assign` |
| 50 | Quick Received | `/finance/quick-received` |
| 51 | Fees Reports | `/finance/fees-reports` |
| 52 | Assign Group Fees | `/finance/assign-group-fees` |
| 53 | Assigned History | `/finance/assigned-history` |
| 54 | Fees Types | `/finance/fees-types` |
| 55 | Fees Discounts | `/finance/fees-discounts` |
| 56 | Fees Fines | `/finance/fees-fines` |
| 57 | Receipt Setting | `/finance/receipt-setting` |
| **👥 Human Resources** | | |
| 58 | Staff List | `/staff/staff-list` |
| 59 | Staff Notes | `/staff/staff-notes` |
| 60 | Payrolls | `/staff/payrolls` |
| 61 | Payroll Reports | `/staff/payroll-reports` |
| 62 | Work Shift Types | `/staff/work-shift-types` |
| 63 | Designations | `/staff/designations` |
| 64 | Departments | `/staff/departments` |
| 65 | Tax Settings | `/staff/tax-settings` |
| 66 | Pay Slip Setting | `/staff/pay-slip-setting` |
| **✅ Staff Attendances** | | |
| 67 | Daily Attendances | `/staff/daily-attendances` |
| 68 | Daily Reports | `/staff/daily-reports` |
| 69 | Hourly Attendances | `/staff/hourly-attendances` |
| 70 | Hourly Reports | `/staff/hourly-reports` |
| **🏖️ Leave Manager** | | |
| 71 | Apply Leave | `/staff/apply-leave` |
| 72 | My Leaves | `/staff/my-leaves` |
| 73 | Leave Types | `/staff/leave-types` |
| 74 | Manage Leave | `/staff/manage-leave` |
| **💰 Accounts** | | |
| 75 | Income List | `/finance/income-list` |
| 76 | Income Categories | `/finance/income-categories` |
| 77 | Expense List | `/finance/expense-list` |
| 78 | Expense Categories | `/finance/expense-categories` |
| 79 | Outcome Overview | `/finance/outcome-overview` |
| **📢 Communicates** | | |
| 80 | Send Email | `/communicate/send-email` |
| 81 | Send SMS | `/communicate/send-sms` |
| 82 | Event List | `/communicate/event-list` |
| 83 | Calendar | `/communicate/calendar` |
| 84 | Notice List | `/communicate/notice-list` |
| 85 | Notice Categories | `/communicate/notice-categories` |
| **📖 Library** | | |
| 86 | Issue Book | `/library-mgmt/issue-book` |
| 87 | Issue & Return | `/library-mgmt/issue-return` |
| 88 | Student List (members) | `/library-mgmt/student-members` |
| 89 | Staff List (members) | `/library-mgmt/staff-members` |
| 90 | Outsider List | `/library-mgmt/outsider-members` |
| 91 | Book List | `/library-mgmt/book-list` |
| 92 | Book Requests | `/library-mgmt/book-requests` |
| 93 | Book Categories | `/library-mgmt/book-categories` |
| 94 | Card Setting | `/library-mgmt/card-setting` |
| **📦 Inventory** | | |
| 95 | Issue Item | `/inventory/issue-item` |
| 96 | Issue & Return | `/inventory/issue-return` |
| 97 | Item Stocks | `/inventory/item-stocks` |
| 98 | Item List | `/inventory/item-list` |
| 99 | Stores | `/inventory/stores` |
| 100 | Suppliers | `/inventory/suppliers` |
| 101 | Categories | `/inventory/categories` |
| **🏠 Hostels** | | |
| 102 | Student List (hostel) | `/facilities/hostel-students` |
| 103 | Staff List (hostel) | `/facilities/hostel-staff` |
| 104 | Hostel Rooms | `/facilities/hostel-rooms` |
| 105 | Hostel List | `/facilities/hostel-list` |
| 106 | Room Types | `/facilities/room-types` |
| **🚌 Transports** | | |
| 107 | Student List (transport) | `/facilities/transport-students` |
| 108 | Staff List (transport) | `/facilities/transport-staff` |
| 109 | Vehicles | `/facilities/vehicles` |
| 110 | Routes | `/facilities/routes` |
| **🖥️ Front Desk** | | |
| 111 | Visitor Logs | `/frontdesk/visitor-logs` |
| 112 | Phone Logs | `/frontdesk/phone-logs` |
| 113 | Enquiry List | `/frontdesk/enquiry-list` |
| 114 | Complain List | `/frontdesk/complain-list` |
| 115 | Postal Exchanges | `/frontdesk/postal-exchanges` |
| 116 | Meeting Schedules | `/frontdesk/meeting-schedules` |
| 117 | Visit Purposes | `/frontdesk/visit-purposes` |
| 118 | Token Settings | `/frontdesk/token-settings` |
| 119 | Enquiry Sources | `/frontdesk/enquiry-sources` |
| 120 | Enquiry References | `/frontdesk/enquiry-references` |
| 121 | Complain Types | `/frontdesk/complain-types` |
| 122 | Complain Sources | `/frontdesk/complain-sources` |
| 123 | Postal Types | `/frontdesk/postal-types` |
| 124 | Meeting Types | `/frontdesk/meeting-types` |
| **🎖️ Transcripts** | | |
| 125 | Semester Marksheets | `/transcripts/semester-marksheets` |
| 126 | Total Marksheets | `/transcripts/total-marksheets` |
| 127 | Marksheet Setting | `/transcripts/marksheet-setting` |
| 128 | Certificates | `/transcripts/certificates` |
| 129 | Certificate Templates | `/transcripts/certificate-templates` |
| **📊 Reports** | | |
| 130 | Student Progress | `/reports/student-progress` |
| 131 | Course Students | `/reports/course-students` |
| 132 | Student Attendance | `/reports/student-attendance` |
| 133 | Subject Attendance | `/reports/subject-attendance` |
| 134 | Collected Fees | `/reports/collected-fees` |
| 135 | Student Fees | `/reports/student-fees` |
| 136 | Salary Paid | `/reports/salary-paid` |
| 137 | Staff Leaves | `/reports/staff-leaves` |
| 138 | Total Income | `/reports/total-income` |
| 139 | Total Expense | `/reports/total-expense` |
| 140 | Library History | `/reports/library-history` |
| 141 | Book Return Due | `/reports/book-return-due` |
| 142 | Inventory History | `/reports/inventory-history` |
| 143 | Hostel Members | `/reports/hostel-members` |
| 144 | Transport Members | `/reports/transport-members` |
| **🌐 Front Web** | | |
| 145 | Contact Setting | `/frontweb/contact-setting` |
| 146 | Social Setting | `/frontweb/social-setting` |
| 147 | Sliders | `/frontweb/sliders` |
| 148 | About Us | `/frontweb/about-us` |
| 149 | Features | `/frontweb/features` |
| 150 | Courses | `/frontweb/courses` |
| 151 | Event | `/frontweb/event` |
| 152 | News | `/frontweb/news` |
| 153 | Faqs | `/frontweb/faqs` |
| 154 | Gallery | `/frontweb/gallery` |
| 155 | Testimonials | `/frontweb/testimonials` |
| 156 | Footer Pages | `/frontweb/footer-pages` |
| 157 | Call To Action | `/frontweb/call-to-action` |
| **⚙️ Settings** | | |
| 158 | General | `/settings/general` |
| 159 | States/Provinces | `/settings/states-provinces` |
| 160 | Districts/Cities | `/settings/districts-cities` |
| 161 | Languages | `/settings/languages` |
| 162 | Mail Setting | `/settings/mail-setting` |
| 163 | SMS Getaways | `/settings/sms-getaways` |
| 164 | Payment Getaways | `/settings/payment-getaways` |
| 165 | Online Application | `/settings/online-application` |
| 166 | Roles and Permissions | `/settings/roles-permissions` |
| 167 | Staffs Fields | `/settings/staffs-fields` |
| 168 | Students Fields | `/settings/students-fields` |
| 169 | Applications Fields | `/settings/applications-fields` |
| 170 | Student Panel | `/settings/student-panel` |
| 171 | 👤 My Profile | `/profile` |

---

## 📊 Page Count Summary

| Sidebar | Pages |
|---------|------:|
| 🏛️ Academic Dashboard | 188 |
| 🧑🎓 Student Panel | 12 |
| 🗂️ Advanced Navigation | 171 |
