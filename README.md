# 🎓 EduSearch-MY

Welcome to the **EduSearch-MY** project! Follow the steps below to set up and run the application locally.

---

## 🚀 Local Setup Guide

### 1️⃣ Initial Setup

Make sure all commands are executed in the root of your project directory:

```bash
cd C:/path/to/your/project
```

1. **Install dependencies** (if you haven't already):

    ```bash
    composer install
    npm install
    ```

2. **Environment Configuration**:
   Copy the example environment file to create your own configuration:
    ```bash
    cp .env.example .env
    ```
    _(After copying, make sure to run `php artisan key:generate` if this is a fresh clone 😁)_

---

### 2️⃣ Run the Application

You will need to run the following commands in parallel. **Open multiple terminal windows or tabs** (ensure you are in the project folder) and keep them running:

**Terminal 1: Database Setup**
Run the migrations and seed the database with initial data:

```bash
php artisan migrate --seed
```

**Terminal 2: Start the Backend Server**
Start the Laravel development server:

```bash
php artisan serve --port=8900
```

> 💡 _Note: You can change the port in your `.env` file if needed._

**Terminal 3: Start the Frontend Build Tool**
Start the Vite development server to compile your frontend assets:

```bash
npm run dev
```

---

### 🗄️ Viewing the Database (SQLite)

This project uses an SQLite database by default. To comfortably inspect your data:

1. **Install TablePlus** (recommended for simplicity).
2. Open TablePlus and create a new connection.
3. Select **SQLite** as the database type.
4. Browse and select the database file located at:
    ```text
    storage/database.sqlite
    ```

---

### ✅ You're All Set!

Your local environment is fully configured, and your project should now be running locally. Happy coding! 🎉
