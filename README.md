# PHP MySQL Product Management System

A secure and responsive Product Management System built using PHP and MySQL. The application provides user authentication and complete CRUD functionality for managing products.

## 📌 Overview

This project is a web-based product management application developed using PHP and MySQL. It includes a secure authentication system and allows authenticated users to create, view, update, and delete product records.

The project also implements several security practices including password hashing, CSRF protection, XSS protection, prepared statements, session management, and server-side input validation.

---

## ✨ Features

### 🔐 Authentication

- User Registration
- User Login and Logout
- Secure password hashing using `password_hash()`
- Password verification using `password_verify()`
- Session management
- Session ID regeneration after login
- Duplicate username and email prevention

### 📦 Product Management

- Add new products
- View all products
- Update existing products
- Delete products
- Sequential Serial Number display
- Product price and quantity validation

### 🛡️ Security

- Password hashing with PHP's `password_hash()`
- Secure password verification with `password_verify()`
- CSRF protection using secure tokens
- CSRF validation using `hash_equals()`
- SQL Injection prevention using prepared statements
- XSS protection using `htmlspecialchars()`
- Server-side input validation
- Session fixation protection
- Secure database error logging

### 🎨 User Interface

- Responsive design
- Bootstrap 5 styling
- Clean and user-friendly interface
- Mobile-friendly layout

---

## 🛠️ Technologies Used

| Technology | Purpose |
|---|---|
| PHP | Backend development |
| MySQL | Database management |
| HTML5 | Page structure |
| CSS3 | Styling |
| Bootstrap 5 | Responsive UI |
| JavaScript | Client-side functionality |
| XAMPP | Local development environment |

---

## 📸 Screenshots

### 🔐 Login

![Login Page](./screenshots/login.png)

---

### 📝 Registration

![Registration Page](./screenshots/register.png)

---

### 📊 Product Dashboard

![Product Dashboard](./screenshots/dashboard.png)

---

### ➕ Add Product

![Add Product](./screenshots/add-product.png)

---

### ✏️ Update Product

![Update Product](./screenshots/update-product.png)

---

### 🗑️ Delete Product

![Delete Product](./screenshots/delete-product.png)

---

## 📂 Project Structure

```text
PHP-MySQL-Product-Management-System/
│
├── screenshots/
│   ├── login.png
│   ├── register.png
│   ├── dashboard.png
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

---

## 🗄️ Database Setup

### 1. Start XAMPP

Start the following services:

- Apache
- MySQL

### 2. Open phpMyAdmin

Open:

```text
http://localhost/phpmyadmin/
