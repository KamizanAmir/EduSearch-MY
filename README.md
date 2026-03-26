🚀 Local Setup Guide

Follow the steps below to run this project locally.

📁 Project Path

Make sure all commands are executed in the same project directory:

C:/path/to/your/project
Copy the .env.example to .env first before proceed to the next step 😁
⚙️ Run the Application

Open multiple terminals (in the same project folder) and run the following commands:

1️⃣ Run Database Migration & Seeder
php artisan migrate --seed
2️⃣ Start the Development Server
php artisan serve --port=8900

💡 You can change the port in your .env file if needed.

3️⃣ Start Frontend Build Tool
npm run dev
🗄️ Viewing the Database

To inspect the database structure:

Install TablePlus (recommended for simplicity)
Open TablePlus and select SQLite

Import the database file located at:

storage/database.sqlite
✅ You're All Set!

Your project should now be running locally 🎉
