# Construction Project Management System

Sistem Manajemen Proyek Konstruksi berbasis web yang dirancang untuk membantu perusahaan dalam mengelola proyek konstruksi secara lebih terstruktur, transparan, dan efisien. Sistem ini dikembangkan sebagai bagian dari tugas akhir dengan menggunakan metode **Prototype**.

---

## 📖 Tentang Proyek

Construction Project Management System merupakan aplikasi berbasis web yang mendukung proses pengelolaan proyek mulai dari manajemen klien, administrasi proyek, monitoring progres pekerjaan, dokumentasi lapangan, hingga pengelolaan pengguna dalam satu platform terintegrasi.

Sistem ini dibangun untuk mengatasi permasalahan koordinasi proyek yang masih dilakukan secara manual sehingga informasi sering terlambat, sulit dipantau, dan tidak terdokumentasi dengan baik.

---

## ✨ Fitur

### Owner

- Dashboard
- Client Management
- Project Management
- Project Administration
- Project Monitoring
- User Management
- Profile Management

### Mandor

- Dashboard
- My Projects
- Work Progress
- Photo Documentation
- Daily Reports
- Profile Management

### Worker

- Dashboard
- My Tasks
- Documentation Upload
- Worker Reports
- Profile Management

---

## 🛠 Tech Stack

### Backend

- Laravel 13
- PHP 8.4+
- Livewire 3
- Laravel Breeze
- Spatie Laravel Permission

### Frontend

- Tailwind CSS 4
- Alpine.js
- Blade Components

### Database

- MySQL

### Development Tools

- Composer
- NPM
- Vite
- Git
- GitHub

---

## 📂 Project Structure

```
app/
├── Livewire/
│   ├── Owner/
│   ├── Mandor/
│   └── Worker/
│
resources/
├── views/
│   ├── components/
│   ├── layouts/
│   └── livewire/
│
database/
├── migrations/
├── seeders/
└── factories/
```

---

## 👥 User Roles

| Role | Description |
|------|-------------|
| Owner | Mengelola seluruh sistem dan proyek |
| Mandor | Mengelola pekerjaan proyek di lapangan |
| Worker | Melaksanakan tugas dan melaporkan progres pekerjaan |

---

## 📋 Main Modules

- Authentication
- Authorization (Role & Permission)
- Client Management
- Project Management
- Project Monitoring
- Daily Reports
- Photo Documentation
- Invoice Management
- User Management
- Profile Management

---

## 🚀 Installation

Clone repository

```bash
git clone https://github.com/username/project-management.git
```

Masuk ke folder project

```bash
cd project-management
```

Install dependency

```bash
composer install
```

Install frontend dependency

```bash
npm install
```

Salin file environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Konfigurasi database pada file `.env`

Jalankan migration

```bash
php artisan migrate --seed
```

Build asset

```bash
npm run dev
```

Jalankan server

```bash
php artisan serve
```

---

## 📸 Screenshot

Coming Soon...

---

## 📅 Development Status

- [x] Authentication
- [x] Role & Permission
- [x] Dashboard UI
- [x] Client Management UI
- [x] User Management UI
- [x] Project Management UI
- [x] Project Monitoring UI
- [ ] Backend Logic
- [ ] Testing
- [ ] Deployment

---

## 🎯 Future Development

- Gantt Chart
- Project Timeline
- Export PDF
- Export Excel
- Notification System
- Email Notification
- Activity Log
- Real-Time Monitoring
- Mobile Responsive Improvement

---

## 📄 License

This project is developed for educational purposes as part of a bachelor's thesis and portfolio.

---

## 👨‍💻 Author

**Ahmad Afrizal**

Information Systems Student

GitHub : https://github.com/username