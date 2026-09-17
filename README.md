Markdown# TicketDesk Enterprise — Support & Task Dispatching System

A modern, role-based Ticket & Task Management System built with Laravel. The platform provides distinct portal workflows for Administrators and Staff members, validated data pipelines, soft-delete data safety, and a dedicated Sanctum REST API.

---

## 🌟 Key Features

* **Role-Based Access Control (RBAC):** Explicit role separation (`admin` and `staff`) guarded via custom `role` route middleware.
* **Administrative Control Hub:**
  * Complete CRUD for staff management (create, update, soft-delete).
  * Task dispatching and reassignment across active staff members.
  * Real-time search by task title/keyword.
* **Staff Workspace:**
  * Overview metrics tracking assigned, pending, and completed tasks.
  * Fast, single-click inline operational status transitions (`Open` / `Completed`).
  * Self-service profile management with phone validation and locked login email.
* **Security & Validation:**
  * Strict unique email formatting via RFC/DNS checks.
  * Contact numbers strictly constrained to 10 numeric digits.
  * Minimum 8-character password enforcement.
* **Data Safety:** Laravel Eloquent `SoftDeletes` implemented across all primary records.
* **REST API Suite:** Laravel Sanctum token authentication with JSON responses covering listing, creation, and status dispatching.
* **UI/UX:** Dark slate theme with indigo glow accents and custom Bootstrap 5 scaffolding.

---

## 🚀 Quick Setup & Installation

### 1. Prerequisites
* PHP >= 8.1
* Composer
* MySQL / MariaDB

### 2. Clone the Repository
```bash
git clone [https://github.com/PrajulVP/Ticket-Management.git](https://github.com/PrajulVP/Ticket-Management.git)
cd Ticket-Management


3. Install DependenciesBash

composer install

4. Environment Configuration

Copy .env.example to .env:

    cp .env.example .env

Generate the application encryption key:
    php artisan key:generate

Configure your database credentials inside .env:

Code snippet

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ticket_management
    DB_USERNAME=root
    DB_PASSWORD=


5. Run Migrations & Seeders
    
    Execute migrations alongside database seeders to populate initial admin and staff credentials:
    
    php artisan migrate:fresh --seed


6. Run the Application
    
    php artisan serve

    Access the application at http://127.0.0.1:8000.


## 🖼️ Application Screenshots

### Admin Portal

<p align="center">
  <b>Admin Task Operations & Management</b><br>
  <img src="screenshots/admin_tasks.png" alt="Admin Task Operations" width="850" style="border-radius: 10px; border: 1px solid #334155; margin-top: 10px; margin-bottom: 25px;">
</p>

<p align="center">
  <b>Staff Directory & Registration</b><br>
  <img src="screenshots/admin_staff.png" alt="Staff Directory" width="850" style="border-radius: 10px; border: 1px solid #334155; margin-top: 10px; margin-bottom: 25px;">
</p>

---

### Staff Portal

<p align="center">
  <b>Staff Overview Dashboard</b><br>
  <img src="screenshots/staff_dashboard.png" alt="Staff Dashboard" width="850" style="border-radius: 10px; border: 1px solid #334155; margin-top: 10px; margin-bottom: 25px;">
</p>

<p align="center">
  <b>My Task Center (Status Transitions)</b><br>
  <img src="screenshots/staff_tasks.png" alt="My Task Center" width="850" style="border-radius: 10px; border: 1px solid #334155; margin-top: 10px; margin-bottom: 25px;">
</p>

<p align="center">
  <b>Staff Profile Settings</b><br>
  <img src="screenshots/staff_profile.png" alt="Staff Profile Settings" width="850" style="border-radius: 10px; border: 1px solid #334155; margin-top: 10px;">
</p>


📄 License
This project is open-source software licensed under the MIT license.