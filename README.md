# Laravel 12 + Redis Student Management System

![Laravel](https://img.shields.io/badge/Laravel-12-red) ![PHP](https://img.shields.io/badge/PHP-8.2-blue) ![Redis](https://img.shields.io/badge/Redis-6-orange)

## 🚀 Overview

This is a **Student Management System** built with **Laravel 12** and **Redis** as the primary database.  

It demonstrates:
- CRUD operations using Redis hashes  
- Field-level updates and numeric increments  
- Maintaining a set of all student IDs  
- Switching Redis databases for environment separation  

This project showcases **modern Laravel development, Redis expertise, and backend engineering skills**.

---

## 🧰 Tech Stack

- PHP 8.2  
- Laravel 12  
- Redis 6+  
- Blade Templates (for UI)  
- Redis Facade (for database operations)  

---

## 📂 Features

- **CRUD Operations:** Add, view, edit, delete students  
- **Field Updates:** Update single fields without overwriting the entire record  
- **Increment Fields:** Age or other numeric values can be incremented programmatically  
- **Redis Sets:** Track all student IDs efficiently  
- **Database Selection:** Demonstrates using a specific Redis database for separation  
- **API-ready Endpoints:** Prepared for frontend integration  

---

## ⚙️ Installation

1. Clone the repo:  
```bash
git clone https://github.com/YOUR_USERNAME/laravel-redis-student-crud.git
cd laravel-redis-student-crud
```

2. Install PHP dependencies:  
```bash
composer install
```

3. Install Node dependencies (optional for frontend):  
```bash
npm install
npm run dev
```

4. Configure `.env` file:
```dotenv
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:GENERATED_KEY
APP_DEBUG=true
APP_URL=http://localhost

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=2
```

5. Start the Laravel server:  
```bash
php artisan serve
```

6. Access the app at: `http://localhost:8000/students`

---

## 🗂 Project Structure

- `app/Http/Controllers/StudentsController.php` – Main CRUD and Redis logic  
- `app/Http/Controllers/RedisController.php` – Redis command examples  
- `resources/views/students/` – Blade templates (index, show, edit)  
- `routes/web.php` – Application routes  

---

## 📸 Screenshots

*(Replace with actual screenshots)*

![Students Index](screenshots/students-index.png)  
![Student Details](screenshots/student-show.png)  

---

## 💡 Why This Project

- **Redis as a primary database** – not just caching  
- **Laravel 12 best practices** – validation, routing, controllers, Blade templates  
- Shows **modern PHP development skills**  
- Great **portfolio piece for backend & Redis expertise**

---

## 🔮 Future Improvements

- Use **UUIDs** instead of timestamps for student IDs  
- Implement **authentication** with Laravel Breeze or Jetstream  
- Add **Redis pipelines** for batch operations  
- Expose a **REST API** for frontend frameworks  
- Add **unit tests** for controllers and Redis logic  