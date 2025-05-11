> 📌 *Note: This README was formatted with the help of ChatGPT to enhance structure, consistency, and visual clarity (icons, layout, sections).  
> All project logic, architecture, and implementation decisions were fully developed independently.*

# 🧾 Laravel Order & Payment Management API ![GitHub repo size](https://img.shields.io/github/repo-size/Mahmoud-kamal12/tocaan?style=flat-square)

This project is a clean, extensible API built with **Laravel 12** following clean code, SOLID principles, and an extendable architecture using the **Strategy + Factory patterns** for payment gateways.

---

## 🚀 Features

### ✅ Authentication
- JWT-based user registration and login
- Secure routes using `auth:api` guard

### ✅ Order Management
- Create an order with multiple items
- Update and delete orders (only if no payments are linked)
- Filter orders by status (pending, confirmed, cancelled)
- Soft delete support for orders

### ✅ Payment Management
- Process payments for confirmed orders only
- Extendable architecture using `Strategy + Factory Pattern`
- Simulated payment handling with redirect-based flow
- Unified callback endpoint handling all gateways via Strategy
- Resource-based responses for all endpoints

---

## 🏗️ Tech Stack

- Laravel 12
- PHP 8.2+
- JWT Authentication
- Strategy Pattern for Payment Logic
- RESTful API Design with proper HTTP codes
- Postman Collection & Environment for easy testing

---

## 🔄 Payment Simulation Flow

This project simulates a redirect-based gateway flow similar to real-world platforms like **PayPal**, but in a simplified way.

> ✅ A fake checkout URL is returned  
> ✅ User clicks simulate success/failure  
> ✅ A unified callback updates the payment status

💡 The architecture allows easy integration with **real gateways** (e.g., PayPal Sandbox or Fawry) by replacing the mock strategy with an API-integrated handler.

---

## 📝 Notes on Scope

This implementation is simplified to match the scope of the task. The following were intentionally skipped:

- Real payment integration (though the architecture supports it)
- Product management table and stock validation
- Notification handling or webhooks

---

## 🔐 Authentication Flow

1. `POST /register` → Register user
2. `POST /login` → Get JWT token
3. Use token as `Authorization: Bearer {{token}}` in all requests

---

## 📦 Postman Files

- ✅ Collection: `Tocaan.postman_collection.json`
- ✅ Environment: `Tocaan.postman_collection.json`

---

## ⚙️ Setup Instructions

```bash
git clone http://github.com/Mahmoud-kamal12/tocaan.git
cd your-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan jwt:secret
php artisan serve
