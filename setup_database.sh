#!/bin/bash

# Database Setup Script for Construction Management System
# This script creates the database and populates it with initial data

echo "=== Construction Management System Database Setup ==="
echo

# Configuration
DB_HOST="localhost"
DB_NAME="construccion_db"
DB_USER="root"
DB_PASS=""

# Check if MySQL is available
if ! command -v mysql &> /dev/null; then
    echo "Error: MySQL is not installed or not in PATH"
    exit 1
fi

echo "Creating database and tables..."

# Execute main schema
mysql -h "$DB_HOST" -u "$DB_USER" ${DB_PASS:+-p"$DB_PASS"} < migrations/001_create_tables.sql

if [ $? -eq 0 ]; then
    echo "✓ Database schema created successfully"
else
    echo "✗ Error creating database schema"
    exit 1
fi

echo "Inserting sample data..."

# Execute sample data
mysql -h "$DB_HOST" -u "$DB_USER" ${DB_PASS:+-p"$DB_PASS"} "$DB_NAME" < migrations/002_sample_data.sql

if [ $? -eq 0 ]; then
    echo "✓ Sample data inserted successfully"
else
    echo "✗ Error inserting sample data"
    exit 1
fi

echo
echo "=== Database setup completed successfully! ==="
echo
echo "You can now access the system with these test users:"
echo "- Admin: admin@construccion.com / password"
echo "- Analyst: analista@construccion.com / password"  
echo "- Visitor: visitante@construccion.com / password"
echo
echo "Please remember to:"
echo "1. Update the .env file with your database credentials"
echo "2. Change default passwords in production"
echo "3. Configure your web server to point to the public/ directory"
echo