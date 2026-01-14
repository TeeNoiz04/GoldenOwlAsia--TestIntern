)
📌 Overview

This project is a Student Score Management System built with Laravel and Docker, developed as part of a Backend Intern technical test.

The system is designed with performance and maintainability in mind:

Student score data is properly indexed to optimize query performance.

Caching mechanisms are applied to frequently accessed data to reduce database load.

A dedicated result table is used to store calculated statistics (total score, average score, classification), minimizing repeated computations and improving response time.

The application follows Object-Oriented Programming (OOP) principles, with clear separation of concerns (Models, Services, Controllers).

🛠️ Tech Stack

PHP 8.2

Laravel 10

Filament 3.2

MySQL 8.0

Docker & Docker Compose

Nginx

📂 Project Structure (Important Parts)
student-score/
├── app/
│   ├── Models/
│   ├── Http/Controllers/
│   └── Services/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── data/students.json
├── docker/
│   ├── nginx/
│   └── php/
├── docker-compose.yml
├── Dockerfile
├── .env.example
└── README.md

⚙️ Requirements

Make sure you have installed:

Docker

Docker Compose

Git

👉 No need to install PHP, Composer, or MySQL locally.

🚀 Setup & Run Project
1️⃣ Clone repository
git clone https://github.com/TeeNoiz04/GoldenOwlAsia--TestIntern.git
cd student-score

2️⃣ Create environment file
cp .env.example .env

Update .env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=student_score
DB_USERNAME=app_user
DB_PASSWORD=secret123

3️⃣ Build & start Docker containers
docker compose up -d --build


⏳ First time may take 3–5 minutes

4️⃣ Install PHP dependencies
docker compose exec app composer install

5️⃣ Generate application key
docker compose exec app php artisan key:generate

6️⃣ Run migrations & seed data
docker compose exec app php artisan migrate --seed


✔ This will:

Create database tables

Import student data from database/data/students.json

🌐 Access Application

Filament Admin	http://localhost:8000/admin
📊 Business Logic
Student Score Calculation

Total Score = Math + Physics + Chemistry

Average Score = Total / 3

Classification Rule
Average Score	Classification
≥ 8.0	Excellent
≥ 6.5	Good
≥ 5.0	Average
< 5.0	Poor

🧪 Useful Commands
# Check running containers
docker compose ps

# View logs
docker compose logs app
docker compose logs db

# Access Laravel container
docker compose exec app bash

# Run tinker
docker compose exec app php artisan tinker

🧑‍💻 Author

Thành Được
Backend Intern Candidate

✅ Notes

The project follows MVC architecture

Business logic is separated into Service layer

Dockerized for easy setup and consistency across environments