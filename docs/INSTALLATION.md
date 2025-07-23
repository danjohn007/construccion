# Installation and Setup Guide

## 🚀 Quick Start (Demo Mode)

For a quick demonstration without MySQL setup, you can use the built-in PHP server:

```bash
# Clone the repository
git clone [repository-url]
cd construccion

# Start PHP development server
cd public
php -S localhost:8000

# Open your browser and go to:
# http://localhost:8000/login.php
```

**Demo Credentials:**
- **Admin:** admin@construccion.com / password
- **Analyst:** analista@construccion.com / password  
- **Visitor:** visitante@construccion.com / password

## 🗄️ Production Setup with MySQL

### Prerequisites
- PHP 7.4+ with PDO MySQL extension
- MySQL 5.7+ or MariaDB 10.3+
- Web server (Apache/Nginx)

### Step 1: Database Configuration

1. **Create MySQL database:**
```sql
CREATE DATABASE construccion_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **Configure environment variables:**
```bash
cp .env.example .env
nano .env
```

Update `.env` with your database credentials:
```
DB_HOST=localhost
DB_NAME=construccion_db
DB_USER=your_username
DB_PASS=your_password
```

### Step 2: Database Setup

**Option A: Automated Setup**
```bash
chmod +x setup_database.sh
./setup_database.sh
```

**Option B: Manual Setup**
```bash
mysql -u root -p construccion_db < migrations/001_create_tables.sql
mysql -u root -p construccion_db < migrations/002_sample_data.sql
```

### Step 3: Web Server Configuration

**Apache Virtual Host Example:**
```apache
<VirtualHost *:80>
    ServerName construccion.local
    DocumentRoot /path/to/construccion/public
    
    <Directory /path/to/construccion/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Nginx Configuration Example:**
```nginx
server {
    listen 80;
    server_name construccion.local;
    root /path/to/construccion/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🔧 Troubleshooting

### Common Issues

**1. Database Connection Error**
```
Connection failed: SQLSTATE[HY000] [2002] No such file or directory
```
- Check MySQL is running: `sudo service mysql start`
- Verify credentials in `.env` file
- Ensure database exists: `SHOW DATABASES;`

**2. Permission Errors**
```bash
# Set proper permissions
sudo chown -R www-data:www-data /path/to/construccion
sudo chmod -R 755 /path/to/construccion
```

**3. PHP Extensions Missing**
```bash
# Install required PHP extensions
sudo apt-get install php-mysql php-pdo php-mbstring
```

### Database Reset

To completely reset the database:
```bash
mysql -u root -p -e "DROP DATABASE IF EXISTS construccion_db;"
./setup_database.sh
```

## 📊 Sample Data

The system includes comprehensive sample data:

- **3 Test Users** (Admin, Analyst, Visitor)
- **4 Suppliers** (CEMEX, Aceros del Norte, etc.)
- **10 Materials** (Cement, steel, aggregates, etc.)
- **6 Labor Categories** (Mason, steelworker, etc.)
- **1 Sample Project** with 7 work concepts
- **Progress Tracking** data
- **Work Schedule** data

## 🔐 Security Considerations

### Production Security Checklist

- [ ] Change default passwords immediately
- [ ] Use strong, unique passwords
- [ ] Configure HTTPS/SSL
- [ ] Restrict database access
- [ ] Set proper file permissions
- [ ] Enable PHP security features
- [ ] Configure firewall rules
- [ ] Regular backups

### Recommended PHP Configuration

```ini
; php.ini security settings
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log
session.cookie_httponly = 1
session.cookie_secure = 1
upload_max_filesize = 10M
post_max_size = 10M
```

## 🚀 Performance Optimization

### Database Optimization

```sql
-- Add indexes for better performance
CREATE INDEX idx_obras_usuario ON obras(usuario_id);
CREATE INDEX idx_conceptos_obra_etapa ON conceptos(obra_id, etapa);
CREATE INDEX idx_avance_concepto_fecha ON avance_obra(concepto_id, fecha);
```

### Caching (Future Enhancement)

- Consider implementing Redis for session storage
- Use application-level caching for frequently accessed data
- Implement query result caching

## 📱 Mobile Support

The system is fully responsive and supports:
- Mobile browsers (iOS Safari, Android Chrome)
- Tablet devices (iPad, Android tablets)
- Touch navigation and gestures
- Mobile-optimized forms and tables

## 🔄 Backup and Recovery

### Automated Backup Script

```bash
#!/bin/bash
# backup_construction.sh
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u root -p construccion_db > backup_construccion_$DATE.sql
tar -czf backup_complete_$DATE.tar.gz backup_construccion_$DATE.sql /path/to/construccion/exports
```

### Recovery Process

```bash
# Restore database
mysql -u root -p construccion_db < backup_construccion_YYYYMMDD_HHMMSS.sql

# Restore files
tar -xzf backup_complete_YYYYMMDD_HHMMSS.tar.gz
```

## 📞 Support

For technical support:
1. Check this documentation
2. Review the troubleshooting section
3. Open an issue on GitHub
4. Include system information (PHP version, MySQL version, error logs)