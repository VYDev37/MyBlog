<div align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  <br>
  <h1>✨ MyBlog Platform</h1>
  <p>A modern, serverless-ready blogging platform built with Laravel & Tailwind CSS.</p>

  [![PHP Version](https://img.shields.io/badge/PHP-8.3.0-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net/)
  [![Laravel Version](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com/)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.1-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
  [![Deployed on Vercel](https://img.shields.io/badge/Vercel-Deployed-000000?style=flat-square&logo=vercel&logoColor=white)](https://vercel.com/)
</div>

<hr>

## 🚀 Overview

**MyBlog** is a highly optimized, full-stack blogging application designed for speed, security, and developer experience. It features a rich-text editor for content creation, a custom Role-Based Access Control (RBAC) system for administrators, and is fully tailored to be deployed on **Vercel** as a serverless application.

### ✨ Detailed Feature Checklist
- [x] **Authentication System**: Full login, registration, email verification, and password reset flows (Laravel Breeze).
- [x] **Role-Based Access Control (RBAC)**: Custom middleware protecting admin and author routes.
- [x] **Post Management (CRUD)**: Create, read, update, and delete blog posts.
- [x] **Rich Text Editor**: Seamless writing experience built with **Tiptap** & **Highlight.js** for code block formatting.
- [x] **Image Uploads**: Cloud storage integration via **Cloudinary PHP**.
- [x] **Serverless Optimized**: Configured specifically to run flawlessly on Vercel's serverless PHP runtime (`vercel-php`).
- [x] **Modern UI/UX**: Fully responsive and animated interfaces built with vanilla Tailwind CSS.

---

## 🛠️ Tech Stack

## 🛠️ Tech Stack & Exact Versions

- **Backend**: Laravel `^13.8` (PHP `^8.3.0`)
- **Frontend**: Blade Templates, Alpine.js `^3.4.2`, Tailwind CSS `^3.1.0`
- **Editor Content**: Tiptap `^3.29.2`, Highlight.js `^11.11.1`
- **Security**: Mews HTML Purifier `^3.4`
- **Media Storage**: Cloudinary PHP `^3.1`
- **Database**: MySQL (Aiven Cloud / PlanetScale ready)
- **Deployment**: Vercel (Serverless Functions)
- **Email Service**: SMTP (Gmail / Resend compatible)

---

## 💻 Local Development

Follow these steps to set up the project on your local machine.

### Prerequisites
- PHP 8.3+
- Composer
- Node.js (v20+) & NPM
- MySQL or SQLite

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/VYDev37/MyBlog.git
   cd MyBlog
   ```

2. **Install PHP & Node dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Configure your `DB_CONNECTION` in `.env`. For local testing, you can use `sqlite`.*

4. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

5. **Start the Development Servers**
   You need two terminal windows:
   ```bash
   # Terminal 1: Vite for compiling Tailwind CSS
   npm run dev
   
   # Terminal 2: Laravel local server
   php artisan serve
   ```
   *Visit `http://localhost:8000` in your browser.*

---

## ☁️ Vercel Deployment Guide

This repository has been heavily customized to run on Vercel's Serverless environment. 

### 1. Vercel Project Setup
- Import this repository to Vercel.
- Set **Framework Preset** to `Other`.
- Set **Build Command** to `npm run build`.
- Set **Install Command** to `npm install`.

### 2. Environment Variables
Add the following crucial variables to your Vercel Dashboard:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-vercel-domain.vercel.app
APP_KEY=base64:your_app_key_here

# Force Laravel to use /tmp (Vercel is Read-Only)
VIEW_COMPILED_PATH=/tmp
SESSION_DRIVER=cookie
LOG_CHANNEL=stderr
QUEUE_CONNECTION=sync

# Database (e.g. Aiven Cloud)
DB_CONNECTION=mysql
DB_HOST=your-cloud-database-host
DB_PORT=your-port
DB_DATABASE=your-db-name
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

### 3. Database Migration
Since Vercel has no terminal, you must run migrations against your production database from your **local machine**:
```bash
# Set your local .env to your cloud DB credentials, then run:
php artisan migrate --force
```

---


<p align="center">Built with ❤️ for a modern web experience.</p>
