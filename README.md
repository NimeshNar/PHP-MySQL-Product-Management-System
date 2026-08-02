# PHP MySQL Product Management System

A full-stack web application built with PHP and MySQL that allows users to securely register, log in, and manage products using CRUD operations.

## 🚀 Features

- User Registration and Login
- Secure Password Hashing using `password_hash()`
- Password Verification using `password_verify()`
- Automatic migration of legacy plain-text passwords
- Product Create, Read, Update, and Delete (CRUD) operations
- Sequential Serial Number display
- CSRF Protection
- XSS Protection using `htmlspecialchars()`
- Server-side Input Validation
- Duplicate Username and Email Prevention
- Session Management and Session Fixation Protection
- Responsive User Interface
- Bootstrap 5 Styling
- MySQL Database Integration

## 🛠️ Technologies Used

- PHP
- MySQL
- HTML5
- CSS3
- Bootstrap 5
- JavaScript
- XAMPP

## 📂 Project Structure

```text
PHP-MySQL-Product-Management-System/
│
├── screenshots/
│   ├── login.png
│   ├── register.png
│   ├── home.png
│   ├── add-product.png
│   ├── update-product.png
│   └── delete-product.png
│
├── index.php
├── login.php
├── register.php
├── logout.php
├── home.php
├── insert.php
├── update.php
├── delete.php
├── connect.php
├── schema.sql
├── .htaccess
├── .gitignore
├── .env.example
└── README.md