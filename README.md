# Student Score Management System

> **Backend Intern Technical Test Submission**

This project is a Student Score Management System built with **Laravel** and **Docker**. The system is engineered with a focus on performance optimization and maintainability, employing techniques such as database indexing, caching strategies, and a strict separation of business logic.

---

## 📌 Overview

The system is designed to handle student data efficiently with the following key features:

- **Performance Optimization:**
  - **Indexing:** Student score data is properly indexed to optimize query performance.
  - **Caching:** Caching mechanisms are applied to frequently accessed data to reduce database load.
  - **Pre-calculation:** A dedicated result table stores calculated statistics (Total Score, Average Score, Classification) to minimize repeated computations and improve response times.
- **Architecture:**
  - Follows **Object-Oriented Programming (OOP)** principles.
  - Implements a clear separation of concerns using **MVC** and **Service Layers** (Models, Services, Controllers).

## 🛠️ Tech Stack

- **Language:** PHP 8.2
- **Framework:** Laravel 10
- **Admin Panel:** Filament 3.2
- **Database:** MySQL 8.0
- **Environment:** Docker & Docker Compose
- **Web Server:** Nginx

## 📂 Project Structure

Key directories and files in the project:

```text
student-score/
├── app/
│   ├── Models/             # Eloquent Models
│   ├── Http/Controllers/   # Controllers
│   └── Services/           # Business Logic Layer (Score processing)
├── database/
│   ├── migrations/         # Database Schema
│   ├── seeders/            # Seeders
│   └── data/students.json  # Initial data for seeding
├── docker/
│   ├── nginx/              # Nginx configuration
│   └── php/                # PHP configuration
├── docker-compose.yml      # Docker services configuration
├── Dockerfile              # Application build file
├── .env.example            # Environment variables example
└── README.md

## ⚙️ Requirements

Ensure you have the following installed on your machine:

- Docker
- Docker Compose
- Git

👉 **Note:** You do not need to install PHP, Composer, or MySQL locally. Everything runs within Docker containers.

---

## 🚀 Setup & Installation

Follow these steps to set up the project:

### 1️⃣ Clone the repository
```bash
git clone [https://github.com/TeeNoiz04/GoldenOwlAsia--TestIntern.git](https://github.com/TeeNoiz04/GoldenOwlAsia--TestIntern.git)
cd student-score

### 2️⃣ Configure Environment

Create the `.env` file from the example:

```bash
cp .env.example .env

Update the Database credentials in .env to match the Docker configuration:
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=student_score
DB_USERNAME=app_user
DB_PASSWORD=secret123

3️⃣ Build & Start ContainersBashdocker
  compose up -d --build
⏳ The first build may take 3–5 minutes.
4️⃣ Install DependenciesBashdocker 
  compose exec app composer install
5️⃣ Generate Application KeyBashdocker 
  compose exec app php artisan key:generate
6️⃣ Run Migrations & Seed DataBashdocker 
  compose exec app php artisan migrate --seed

✔ This command will:Create necessary database tables.
Import student data from database/data/students.json.
🌐 Access the ApplicationOnce the setup is complete, you can access the admin panel at:
👉 Filament Admin: http://localhost:8000/admin
📊 Business LogicThe system automatically calculates scores and classifies students based on the following rules:
Score CalculationTotal Score = Math + Physics + ChemistryAverage Score = Total Score / 3
Classification Rules
Average Score   Classification
≥ 8.0   Excellent
≥ 6.5   Good
≥ 5.0   Average
< 5.0   Poor
🧪 Useful CommandsBash# Check running containers
docker compose ps

# View application logs
docker compose logs app

# View database logs
docker compose logs db

# Access the Laravel application container shell
docker compose exec app bash

# Run Laravel Tinker
docker compose exec app php artisan tinker

🧑‍💻 AuthorThành Được
Backend Intern Candidate

✅ NotesThe project adheres to MVC architecture.Complex business logic is handled in the Service Layer.The environment is fully Dockerized to ensure consistency across different machines.