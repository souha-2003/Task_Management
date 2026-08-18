# Task Management System

A robust, enterprise-grade **Task Management Application** built with **Laravel 12**, featuring complete task lifecycle management, multi-guard authentication, role-based authorization (RBAC), real-time push notifications via Firebase Cloud Messaging (FCM HTTP v1), multi-language support, and a secured RESTful API.

---

## Technologies & Libraries

### Authentication & Authorization Architecture
- **[Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)**: Comprehensive web authentication scaffolding (Login, Registration, Password Reset, Profile Management, Email Verification, and Session Security).
- **[Spatie Laravel-Permission (^6.25)](https://spatie.be/docs/laravel-permission)**: Fine-grained Role-Based Access Control (RBAC) supporting dynamic Roles, Permissions, Middleware guards, and Blade authorization directives (`@can`, `can:manage users`).
- **[Laravel Sanctum (^4.0)](https://laravel.com/docs/sanctum)**: Lightweight, secure API token issuance and SPA authentication with scoped capabilities and token revocation.

### Backend & Integrations
- **PHP ^8.2**
- **Laravel 12.x**: Core application framework.
- **[Google API Client (`google/apiclient: ^2.19`)](https://github.com/googleapis/google-api-php-client)**: Direct server-to-server integration with Firebase Cloud Messaging (FCM HTTP v1 API) using Google Service Account OAuth 2.0.
- **[Laravel Pail](https://github.com/laravel/pail)**: Real-time log tailing directly in your terminal.

### Frontend Stack
- **Blade Template Engine**: Modular server-rendered layouts with custom components.
- **Bootstrap 5**: Modern, responsive component-based styling.
- **Vite & Alpine.js**: Reactive UI micro-interactions and lightning-fast asset bundling.

### Architecture & Database
- **Database Support**: MySQL, PostgreSQL, SQLite through Eloquent ORM.
- **Service Layer Pattern**: Core domain logic isolated inside [`TaskService`](app/Services/TaskService.php) ensuring clean architecture and controllers.
- **Event-Driven & Observers**: [`TaskObserver`](app/Observers/TaskObserver.php) and [`TaskAssigned`](app/Events/TaskAssigned.php) event listeners orchestrating automated logging and multi-channel notification dispatches.

---

## Key Features

- **Dual Authentication & Authorization Engine**:
  - Web session authentication powered by **Laravel Breeze**.
  - Token-based API authentication powered by **Laravel Sanctum**.
  - Granular RBAC permissions (`Admin`, `Manager`, `User`) with custom access control matrices via **Spatie**.
- **Task Management**: Full CRUD operations, assignment to team members, priority levels (`Low`, `Medium`, `High`, `Urgent`), deadline tracking, and categories.
- **Instant Status Toggle**: Quick circular inline status toggle (`Pending` -> `In Progress` -> `Review` -> `Completed`).
- **Categorization**: Grouping and filtering tasks by project or category.
- **User Administration**: Dedicated admin portal to inspect user activity, manage roles, and customize permissions.
- **Dual Notification Channels**:
  - Database Notifications: Real-time in-app notification bell, notification history, mark-as-read, and bulk purge.
  - Push Notifications (Firebase FCM): Instant mobile/desktop push alerts dispatched when tasks are assigned.
- **Localization & Multilingual**: Dynamic runtime interface language switching (`/lang/{locale}`).
- **Enterprise RESTful API**: Production-ready API endpoints with rate limiting (`throttle:api`), structured JSON schemas via Laravel API Resources, and token management.

---

## Prerequisites

- **PHP** >= 8.2 (Extensions: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, cURL)
- **Composer** (v2+)
- **Node.js** (v18+) & **NPM**
- **MySQL** / MariaDB / PostgreSQL / SQLite

---

## Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/souha-2003/Task_Management.git
   cd Task_Management/task
   ```

2. **Install Backend & Frontend Dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment Variables:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set Database Credentials in `.env`:**
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
   > **Default Seeded Accounts:**
   > - **Admin User**: `admin@example.com` / `password` *(Has full system & role management permissions)*
   > - **Regular User**: `user@example.com` / `password` *(Standard user permissions)*

6. **Firebase Credentials Setup (Optional for Push Notifications):**
   - Place your Firebase service account JSON key file in `storage/app/firebase/` or configure the path in `.env`.

7. **Start Development Environment:**
   You can start the server, Vite compiler, queue listener, and log tailing simultaneously using the custom command:
   ```bash
   composer dev
   ```
   *Or run them manually:*
   ```bash
   php artisan serve
   php artisan queue:listen
   npm run dev
   ```
   Application will be available at: `http://127.0.0.1:8000`

---

## RESTful API Documentation & Endpoints

All API endpoints are prefixed with `/api` and throttled via `throttle:api` middleware.

### Authentication Endpoints

#### 1. Login (Generate API Token)
Authenticate using any seeded account (e.g. `admin@example.com` or `user@example.com`):

- **URL**: `POST /api/login`
- **Headers**: `Accept: application/json`
- **Body**:
  ```json
  {
    "email": "admin@example.com",
    "password": "password"
  }
  ```
- **Response** (`200 OK`):
  ```json
  {
    "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com"
    }
  }
  ```

#### 2. Logout (Revoke API Token)
- **URL**: `POST /api/logout`
- **Headers**: `Authorization: Bearer <TOKEN>`, `Accept: application/json`
- **Response** (`200 OK`):
  ```json
  {
    "message": "Token revoked successfully"
  }
  ```

---

### Resource Endpoints (Require `Bearer <TOKEN>`)

| Method | Endpoint | Description | Protected |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/user` | Fetch authenticated user profile & roles | Yes |
| `GET` | `/api/tasks` | Get paginated list of tasks (with filters) | Yes |
| `POST` | `/api/tasks` | Create a new task and trigger assign notifications | Yes |
| `GET` | `/api/tasks/{id}` | Retrieve specific task details | Yes |
| `PUT/PATCH` | `/api/tasks/{id}` | Update existing task or change status | Yes |
| `DELETE` | `/api/tasks/{id}` | Delete a task | Yes |
| `GET` | `/api/categories` | List all task categories | Yes |
| `POST` | `/api/categories` | Create a new category | Yes |
| `GET/PUT/DELETE` | `/api/categories/{id}` | Manage category details | Yes |
| `GET` | `/api/users` | List users for task assignment (Admin/Manager) | Yes |
| `PUT` | `/api/users/{id}` | Update user attributes / assigned roles | Yes |

---

## Testing

Run feature and unit test suites:
```bash
php artisan test
```

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
