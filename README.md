# 📋 Task Management System

A robust and modern **Task Management Application** built with **Laravel 12**, featuring full task lifecycle tracking, role-based access control (RBAC), real-time push notifications via Firebase Cloud Messaging (FCM HTTP v1), multi-language localization, and a secured RESTful API with Laravel Sanctum.

---

## 🚀 Technologies & Libraries

### 🔹 Backend Stack
- **PHP ^8.2**
- **Laravel 12.x**: The core PHP web framework.
- **[Spatie Laravel-Permission (^6.25)](https://spatie.be/docs/laravel-permission)**: Fine-grained Role-Based Access Control (Roles & Permissions management).
- **[Laravel Sanctum (^4.0)](https://laravel.com/docs/sanctum)**: Token-based API authentication for mobile and third-party clients.
- **[Google API Client (`google/apiclient: ^2.19`)](https://github.com/googleapis/google-api-php-client)**: Direct integration with Firebase Cloud Messaging (FCM) via HTTP v1 API using OAuth 2.0 service account credentials.
- **Laravel Breeze**: Authentication scaffolding and session management.

### 🔹 Frontend Stack
- **Blade Template Engine**: Dynamic and modular server-rendered templates.
- **Tailwind CSS**: Modern utility-first CSS design system.
- **Vite & Alpine.js**: Fast asset bundling and reactive frontend interactions.

### 🔹 Architecture & Database
- **Database**: Compatible with MySQL, PostgreSQL, and SQLite via Eloquent ORM.
- **Service Layer Pattern**: Core business logic encapsulated in `TaskService` for maintainability and separation of concerns.
- **Event-Driven Architecture**: Model Observers (`TaskObserver`) and custom events (`TaskAssigned`) to trigger push and database notifications automatically.

---

## ✨ Key Features

- 📝 **Task Management**: Create, read, update, delete (CRUD), assign to users, set priority levels, due dates, and categories.
- ⚡ **Instant Status Toggle**: Quick inline completion status toggle (`Pending` / `Completed`).
- 🏷️ **Categories**: Organize tasks into structured categories.
- 👥 **User & Role Administration**: Admin dashboard to manage user accounts, assign roles (`Admin`, `Manager`, `User`), and inspect permissions.
- 🔔 **Dual Notification System**:
  - **In-App Database Notifications**: Notification drawer/history, mark as read, and bulk clear.
  - **Push Notifications (Firebase FCM)**: Real-time device notifications sent automatically to assigned users.
- 🌐 **Multi-Language Localization**: Instant interface language switching (`/lang/{locale}`).
- 📡 **Comprehensive RESTful API**: Fully structured API endpoints with rate limiting (`throttle:api`) and JSON API Resources.

---

## 🛠️ Prerequisites

- **PHP** >= 8.2 with required extensions (OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, cURL)
- **Composer** (v2+)
- **Node.js** (v18+) & **NPM**
- **MySQL** / MariaDB / PostgreSQL / SQLite

---

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/souha-2003/Task_Management.git
   cd Task_Management/task
   ```

2. **Install PHP and Node dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment Variables:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up Database Configuration in `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```

6. **Firebase Credentials Setup (Optional for Push Notifications):**
   - Place your Firebase service account JSON key file in `storage/app/firebase/` or configure the path in `.env`.

7. **Build Frontend Assets & Start Local Server:**
   ```bash
   npm run dev
   php artisan serve
   ```
   Access the app at: `http://127.0.0.1:8000`

---

## 📡 RESTful API Overview

All API routes are protected by rate limiting (`throttle:api`):

| Method | Endpoint | Description | Auth Required |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/login` | Authenticate user & issue Bearer Token | ❌ No |
| `GET` | `/api/user` | Fetch authenticated user profile | ✅ Yes (`Bearer Token`) |
| `POST` | `/api/logout` | Revoke active access token | ✅ Yes |
| `GET / POST` | `/api/tasks` | List or create tasks | ✅ Yes |
| `GET / PUT / DELETE` | `/api/tasks/{id}` | Retrieve, update or delete a task | ✅ Yes |
| `GET / POST` | `/api/categories` | List or create task categories | ✅ Yes |
| `GET / PUT / DELETE` | `/api/categories/{id}` | Manage single category | ✅ Yes |
| `GET` | `/api/users` | List users for assignment (Admin) | ✅ Yes |
| `PUT` | `/api/users/{id}` | Update user details/roles | ✅ Yes |

---

## 🧪 Testing

Run test suites using PHPUnit:
```bash
php artisan test
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
