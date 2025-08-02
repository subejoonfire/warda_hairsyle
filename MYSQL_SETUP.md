# Setup MySQL untuk Wardati Hairstyle

## 🔄 Perubahan dari SQLite ke MySQL

Proyek ini telah diupdate untuk menggunakan MySQL sebagai database utama. Berikut adalah langkah-langkah setup:

## 📋 Prerequisites

1. **MySQL Server** - Pastikan MySQL server sudah terinstall dan berjalan
2. **PHP MySQL Extension** - Pastikan extension `mysqli` sudah terinstall
3. **Composer** - Untuk menginstall dependencies

## 🚀 Setup Database

### 1. Install MySQL (jika belum)

**Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install mysql-server
sudo systemctl start mysql
sudo systemctl enable mysql
```

**CentOS/RHEL:**
```bash
sudo yum install mysql-server
sudo systemctl start mysqld
sudo systemctl enable mysqld
```

**macOS:**
```bash
brew install mysql
brew services start mysql
```

### 2. Buat Database

```bash
# Login ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE wardati_hairstyle_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE wardati_hairstyle_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Atau gunakan script yang sudah disediakan
mysql -u root -p < setup_mysql.sql
```

### 3. Setup Environment

```bash
# Copy file environment
cp .env.example .env

# Edit file .env dan sesuaikan kredensial database
nano .env
```

**Contoh konfigurasi database di .env:**
```env
database.default.hostname = localhost
database.default.database = wardati_hairstyle_db
database.default.username = root
database.default.password = your_mysql_password
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 4. Jalankan Setup

```bash
# Install dependencies
composer install

# Jalankan setup script
php setup.php
```

## 🔧 Konfigurasi Tambahan

### MySQL User Permissions

Jika menggunakan user MySQL selain root, pastikan user memiliki permission yang cukup:

```sql
-- Buat user baru (opsional)
CREATE USER 'wardati_user'@'localhost' IDENTIFIED BY 'your_password';

-- Berikan permission
GRANT ALL PRIVILEGES ON wardati_hairstyle_db.* TO 'wardati_user'@'localhost';
GRANT ALL PRIVILEGES ON wardati_hairstyle_test.* TO 'wardati_user'@'localhost';

-- Apply changes
FLUSH PRIVILEGES;
```

### MySQL Configuration

Pastikan MySQL configuration mendukung:
- UTF8MB4 character set
- InnoDB storage engine
- Proper connection limits

**File my.cnf (Linux) atau my.ini (Windows):**
```ini
[mysqld]
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
default-storage-engine = InnoDB
max_connections = 200
```

## 🧪 Testing

Untuk menjalankan test dengan MySQL:

```bash
# Pastikan database test sudah dibuat
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS wardati_hairstyle_test;"

# Jalankan test
./vendor/bin/phpunit
```

## 🔍 Troubleshooting

### Error: "Access denied for user"
- Pastikan username dan password di `.env` benar
- Cek apakah user memiliki akses ke database
- Coba login manual: `mysql -u username -p`

### Error: "Can't connect to MySQL server"
- Pastikan MySQL server berjalan
- Cek port MySQL (default: 3306)
- Cek firewall settings

### Error: "Unknown database"
- Pastikan database sudah dibuat
- Jalankan: `mysql -u root -p < setup_mysql.sql`

### Error: "Table doesn't exist"
- Jalankan migration: `php spark migrate`
- Atau jalankan setup script: `php setup.php`

## 📊 Perbedaan SQLite vs MySQL

| Feature | SQLite | MySQL |
|---------|--------|-------|
| Server | File-based | Client-Server |
| Concurrent Users | Limited | High |
| Performance | Good for small apps | Better for production |
| Backup | File copy | mysqldump |
| Replication | No | Yes |
| ACID Compliance | Yes | Yes |

## 🎯 Keuntungan MySQL

1. **Scalability** - Mendukung aplikasi dengan traffic tinggi
2. **Concurrent Users** - Bisa handle multiple users bersamaan
3. **Backup & Recovery** - Tools backup yang powerful
4. **Replication** - Support master-slave replication
5. **Security** - User management dan permission yang lebih baik
6. **Monitoring** - Tools monitoring yang lebih lengkap

## 📞 Support

Jika mengalami masalah dengan setup MySQL:
1. Cek log MySQL: `/var/log/mysql/error.log`
2. Cek log aplikasi: `writable/logs/`
3. Pastikan semua prerequisites terpenuhi
4. Coba setup step by step sesuai dokumentasi

---

**Happy Coding! 🚀**