# Docker-Project



## Requirements
- **Docker**

******

## MySQL Database Setup

### 1. Dockerfile for MySQL
Create a Dockerfile in `/api/db/Dockerfile`:
```dockerfile
FROM mysql 
ENV MYSQL_ROOT_PASSWORD=root
```

### 2. SQL Script to Generate Database
Create a SQL script at `/api/db/script.sql`:
```sql
CREATE DATABASE IF NOT EXISTS store;
USE store;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

INSERT INTO products (name, price)
VALUES
    ('Product 1', 45.00),
    ('Product 2', 21.00),
    ('Product 3', 30.00);
```

### 3. Build and Run MySQL Container

#### A1: Build MySQL Image
Run the following command from the root project folder:
```bash
docker build -t mysql-image -f api/db/Dockerfile .
```

#### A2: Run MySQL Container
- **Windows (PowerShell):**
```powershell
docker run -d -v "$(Get-Location)/api/db/data:/var/lib/mysql" --rm --name mysql-container mysql-image
```
- **Linux/Unix:**
```bash
docker run -d -v $(pwd)/api/db/data:/var/lib/mysql --rm --name mysql-container mysql-image
```

#### A3: Execute SQL Script
- **Windows (PowerShell):**
```powershell
Get-Content api/db/script.sql | docker exec -i mysql-container mysql -uroot -proot
```
- **Linux/Unix:**
```bash
docker exec -i mysql-container mysql -uroot -proot < api/db/script.sql
```

******

## Node.js + Express API Setup

### 1. Dockerfile for Node.js
Create a Dockerfile in `/api/Dockerfile`:
```dockerfile
FROM node:16-alpine
WORKDIR /home/node/app
CMD ["npm", "start"]
```

### 2. Build and Run Node.js Container

#### B1: Build Node.js Image
```bash
docker build -t node-image -f api/Dockerfile .
```

#### B2: Run Node.js Container
- **Windows (PowerShell):**
```powershell
docker run -d -v "$(Get-Location)/api:/home/node/app" -p 9001:9001 --rm --name node-container node-image
```
- **Linux/Unix:**
```bash
docker run -d -v $(pwd)/api:/home/node/app -p 9001:9001 --rm --name node-container node-image
```

******

## PHP Client Setup

### 1. Dockerfile for PHP with Apache
Create a Dockerfile in `/client/Dockerfile`:
```dockerfile
FROM php:7.2-apache
WORKDIR /var/www/html
```

### 2. Build and Run PHP Container

#### C1: Build PHP Image
```bash
docker build -t php-image -f client/Dockerfile .
```

#### C2: Run PHP Container Linked to Node.js
- **Windows (PowerShell):**
```powershell
docker run -d -v "$(Get-Location)/client:/var/www/html" -p 8888:80 --link node-container --rm --name php-container php-image
```
- **Linux/Unix:**
```bash
docker run -d -v $(pwd)/client:/var/www/html -p 8888:80 --link node-container --rm --name php-container php-image
```

******
## Additional Commands

- **List Running Containers:**
```bash
docker ps
```

- **Stop a Container:**
```bash
docker stop <container-name>
```

---

### Notes
- Ensure Docker is installed and running on your system.
- Adjust file paths and volume mappings as necessary for your environment.
