# Student Management System — BCA Final Year Project

A PHP + MySQL web application for managing student records, courses and attendance.

## Technology
- PHP 8+
- MySQL 5.7+ / MariaDB 10.4+
- HTML5, CSS3, Bootstrap 5
- PDO for database access

## Features
- Admin login/logout
- Dashboard statistics
- Add, search, edit and delete student records
- Add and view courses
- Record and view attendance
- Prepared SQL statements, password hashing, session authentication and CSRF tokens

## Run locally (XAMPP)
1. Install XAMPP with PHP 8+ and MySQL.
2. Extract this project into `C:\xampp\htdocs\student_management_system_bca`.
3. Open XAMPP Control Panel and start **Apache** and **MySQL**.
4. Open `http://localhost/phpmyadmin`.
5. Select **Import**, choose `database/student_management.sql`, and import it.
6. Open `config/database.php`. The default settings are:
   - host: `localhost`
   - database: `student_management`
   - username: `root`
   - password: blank (the XAMPP default; change it if your MySQL setup differs)
7. Visit `http://localhost/student_management_system_bca/`.

### Demo login
- Username: `admin`
- Password: `password`

Change the demo password before storing real student information. This is an educational project, not a production-ready student information system.

## Upload to GitHub
1. Create a new **public** or **private** repository on GitHub, for example `bca-student-management-system`.
2. Extract this ZIP on your computer.
3. Open a terminal in the extracted project folder and run:

```bash
git init
git add .
git commit -m "Initial commit: BCA Student Management System"
git branch -M main
git remote add origin https://github.com/YOUR-USERNAME/bca-student-management-system.git
git push -u origin main
```

Replace `YOUR-USERNAME` with your GitHub username and use your actual repository URL. GitHub stores the source code; it does **not** run PHP/MySQL projects automatically.

## Run after uploading to GitHub
To run it on your own computer, clone the repository into the XAMPP `htdocs` folder:

```bash
cd C:/xampp/htdocs
git clone https://github.com/YOUR-USERNAME/bca-student-management-system.git student_management_system_bca
```

Then import `database/student_management.sql`, start Apache/MySQL, and open the local URL shown above.

To make the project publicly accessible as a website, deploy it to a PHP/MySQL hosting provider and create/import the database there. GitHub Pages alone cannot run PHP or MySQL.

## Project structure

```text
student_management_system_bca/
├── assets/css/style.css
├── config/database.php
├── database/student_management.sql
├── includes/auth.php
├── includes/header.php
├── includes/footer.php
├── report/project_report.md
├── index.php
├── login.php
├── logout.php
├── dashboard.php
├── students.php
├── student_form.php
├── student_delete.php
├── courses.php
├── attendance.php
├── .gitignore
└── README.md
```

## Before submitting
- Replace the name, roll number, college and guide placeholders in `report/project_report.md`.
- Add screenshots of your own running application.
- Test every module and document the actual results.
- Change the demo password and never commit real student data or production credentials.
