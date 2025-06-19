<p align="center">
  <img src="https://laravel.com/img/logomark.min.svg" width="100" alt="Laravel logo">
</p>

<h1 align="center">🎯 Lucky REST-API-TEST ID-GROW</h1>

<p align="center">
  Test ID-GROW by PT. Clavata Extra Sukses. REST-API menggunakan Laravel 12, Sanctum, dan dokumentasi Postman.
</p>

---

## 🚀 Cara Menjalankan Proyek

### 1. Clone Repositori

```bash
git clone https://github.com/luckyauars/rest-api-lucky-ID-GROW.git
cd rest-api-lucky-ID-GROW
```

### 2. Install Dependensi

```bash
composer install
```

### 3. Konfigurasi File .env

Buat file .env dengan salin dari .env.example atau gunakan konfigurasi ini:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:4ziY7bRtMvhdXMAhkPlBUD/24RYgz9pEP2BqVs4K3M8=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_lucky
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan:

```bash
php artisan key:generate
```

### 4. Migrasi Database

```bash
php artisan migrate
```

### 5. Jalankan Server Lokal

```bash
php artisan serve
```

Akses di browser:

```
http://localhost:8000
```

---

## 🔐 Autentikasi API dengan Laravel Sanctum

### 📥 Registrasi

- Endpoint: POST /api/register
- Contoh payload:

```json
{
  "name": "Contoh",
  "email": "contoh@gmail.com",
  "password": "contoh",
  "password_confirmation": "contoh"
}
```

### 🔑 Login

- Endpoint: POST /api/login
- Contoh:

```json
{
  "email": "contoh@gmail.com",
  "password": "contoh"
}
```

- Response:

```json
{
  "access_token": "1|yourapitoken",
  "token_type": "Bearer"
}
```

Gunakan token tersebut dalam header:

```
Authorization: Bearer yourapitoken
```

---

## 📚 Dokumentasi API

📩 Koleksi Postman: [Lucky-REST-API.postman.collection.json](https://github.com/luckyauars/rest-api-lucky-ID-GROW/blob/main/lucky.postman-ID-GROW%20by%20PT.%20Clavata%20Extra%20Sukses.json)

📄 Dokumentasi Lengkap (PDF): [REST-API_Dokumentasi_Laravel](https://drive.google.com/file/d/1ygcpMbgCtZOmo2Hb6vikE2NaAtxJe9JW/view?usp=sharing)

---

## 🐳 Menjalankan dengan Docker (Opsional)

```bash
docker build -t laravel-inventory .
docker run -p 8000:8000 laravel-inventory
```

---

## 👨‍💻 Developer

| Nama | Email | GitHub |
|------|-------|--------|
| Lucky test | luckytest@gmail.com | [@luckyauars](https://github.com/luckyauars) |

---

## 👨‍💻 Pengembang & Dokumentasi Tambahan

Untuk dokumentasi tambahan dan file-file pendukung lainnya, silakan akses melalui tautan Google Drive berikut:

- 📂 [Folder Dokumentasi Project (Google Drive)](https://drive.google.com/drive/folders/1WLzC6AdkOGgffdrvLLl3W61DQB5n7UGr?usp=sharing)
