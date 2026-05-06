# Student Manager

A modern web platform for student management built with PHP & MySQL — 
includes CRUD operations, advanced search, authentication, 
and security testing with OWASP ZAP.

## Description

Student Manager is a full-stack web application that allows administrators
to manage students efficiently. The project includes a secure login system,
a dashboard with real-time statistics, and an advanced search with filters.
It also features intentional vulnerability injection and testing with OWASP ZAP
to demonstrate common web security flaws and their fixes.

## Tech Stack

- PHP 8.3 + PDO
- MySQL 8.4
- HTML5 / CSS3 / JavaScript
- WAMP64 (local server)
- Git & GitHub
- OWASP ZAP 2.17.0

## Features

- Secure login system with session management
- Dashboard with real-time statistics (total students, average grade, best grade, fields)
- Full CRUD operations (Create, Read, Update, Delete)
- Advanced search with filters (name, field, min/max grade)
- Live search in the student table
- Modern and responsive UI design
- Protection against SQLi, XSS, CSRF, IDOR, and Sensitive Data Exposure

## Project Structure

    student_manager/
    ├── assets/
    │   └── style.css       # Global CSS styles
    ├── sql/
    │   └── database.sql    # Database creation script
    ├── logs/
    │   └── errors.log      # Private error logs
    ├── db.php              # PDO database connection
    ├── login.php           # Login page
    ├── logout.php          # Session logout
    ├── index.php           # Dashboard + student list
    ├── create.php          # Add a student
    ├── edit.php            # Edit a student
    ├── delete.php          # Delete a student
    ├── search.php          # Advanced search with filters
    └── csrf_attack.html    # CSRF attack demonstration

## Installation

1. Clone the repository :

        git clone https://github.com/tasnim-osghir/student-manager.git

2. Copy to `C:\wamp64\www\`
3. Import `sql/database.sql` in phpMyAdmin
4. Open `http://localhost/student_manager/login.php`
5. Login with :
   - Email : `admin@student.com`
   - Password : `admin123`

## Branches

| Branch | Description |
|--------|-------------|
| `main` | Secure, styled and fully functional code |
| `vulnerable` | Code with injected flaws for ZAP testing |

## Security Testing

The following vulnerabilities were intentionally injected
on the `vulnerable` branch and tested with OWASP ZAP :

| # | Vulnerability | File | Risk Level | Fix |
|---|--------------|------|------------|-----|
| V1 | SQL Injection | search.php | High | PDO prepared statements |
| V2 | Cross-Site Scripting (XSS) | index.php | Medium | htmlspecialchars() |
| V3 | Cross-Site Request Forgery (CSRF) | delete.php | Medium | CSRF token |
| V4 | Insecure Direct Object Reference (IDOR) | edit.php | Medium | ID validation |
| V5 | Sensitive Data Exposure | db.php | Low | Generic error messages |

## What I Learned

- Building a full-stack web application with PHP and MySQL
- Using PDO for secure database connections
- Implementing session-based authentication
- Building dynamic SQL queries with multiple filters
- Version control with Git and GitHub (branches, commits)
- Understanding OWASP Top 10 vulnerabilities
- Using OWASP ZAP for automated penetration testing
- Applying web security best practices