# Student Manager

PHP MySQL CRUD project with intentional vulnerabilities: SQLi, XSS, CSRF, IDOR — tested with OWASP ZAP

## Description

A web-based student management system built with PHP and MySQL.
This project implements full CRUD operations and includes a
security testing phase using OWASP ZAP to identify and fix
common web vulnerabilities.

## Tech Stack

- PHP 8.3 + PDO
- MySQL 8.4
- WAMP64 (local server)
- Git & GitHub
- OWASP ZAP 2.17.0

## Project Structure

    student_manager/
    ├── assets/
    ├── sql/
    │   └── database.sql
    ├── logs/
    ├── db.php          # PDO database connection
    ├── index.php       # List students (READ)
    ├── create.php      # Add student (CREATE)
    ├── edit.php        # Edit student (UPDATE)
    ├── delete.php      # Delete student (DELETE)
    ├── search.php      # Search students
    └── csrf_attack.html # CSRF attack demo

## Installation

1. Clone the repository :

        git clone https://github.com/tasnim-osghir/student-manager.git

2. Copy to `C:\wamp64\www\`
3. Import `sql/database.sql` in phpMyAdmin
4. Open `http://localhost/student_manager/`

## Branches

| Branch | Description |
|--------|-------------|
| `main` | Secure and fixed code |
| `vulnerable` | Code with injected flaws for ZAP testing |

## Security Testing

The following vulnerabilities were intentionally injected
on the `vulnerable` branch and tested with OWASP ZAP :

| # | Vulnerability | File | Risk Level |
|---|--------------|------|------------|
| V1 | SQL Injection | search.php | High |
| V2 | Cross-Site Scripting (XSS) | index.php | Medium |
| V3 | Cross-Site Request Forgery (CSRF) | delete.php | Medium |
| V4 | Insecure Direct Object Reference (IDOR) | edit.php | Medium |
| V5 | Sensitive Data Exposure | db.php | Low |

## What I Learned

- Building a full CRUD application with PHP and MySQL
- Using PDO for secure database connections
- Version control with Git and GitHub (branches, commits)
- Understanding OWASP Top 10 vulnerabilities
- Using OWASP ZAP for automated penetration testing
- Applying web security best practices