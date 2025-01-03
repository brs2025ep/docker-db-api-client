## Docker-Project
Description : PHP Client with Node+Express API and MYSQL DATABASE. Nodejs gets data from MySQL and PHP Client retrieves the data with API.

Requiriments:
- DOCKER

 >>>>>>>>> TUTORIAL <<<<<<<<


************************
MYSQL DATABASE
## Container MySql Docker construído com Dockerfile na pasta /api

1 - /api/db/Dockerfile
```
FROM mysql 
ENV MYSQL_ROOT_PASSWORD=root
```

2- SQL Script to generate db 'store' with table 'products'
 /api/db/script.sql : 
```
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


## A1 - Build mysql in container. 
>>  Point your terminal to the root project folder and run the command:
```docker build -t mysql-image -f api/db/Dockerfile .```

## A2 - Run mysql container 

>> Use comand a for Windows Powershell users or b for UNIX/Linux users.
a - Terminal Windows Powershell
```docker run -d -v "$(Get-Location)/api/db/data:/var/lib/mysql" --rm --name mysql-container mysql-image```

b - For UNIX/ Linux
```docker run -d -v $(pwd)/api/db/data:/var/lib/mysql --rm --name mysql-container mysql-image```

## A3 - Run sql script

a - Terminal Linux
```docker exec -i mysql-container mysql -uroot -proot < api/db/script.sql```
b - Terminal Windows Powershell
```Get-Content api/db/script.sql | docker exec -i mysql-container mysql -uroot -proot```


************************
NODE JS + Express API

# Container Nodejs Docker built with Dockerfile in folder /api #
- /api/db/Dockerfile
```
FROM node:16-alpine
WORKDIR /home/node/app
CMD ["npm", "start"]
```

- /api/db/package.json
- /api/db/package-lock.json


## B1 - Build Node Container
```docker build -t node-image -f api/db/Dockerfile .```


## B2 - Run Node with data volume and listen to port 9001. Command a for Windows and b for UNIX/Linux

a - Windows Powershel
```docker run -d -v "$(Get-Location)/api:/home/node/app" -p 9001:9001 --rm --name node-container node-image```

b - Linux / UNIX
```docker run -d -v $(pwd)/api:/home/node/app -p 9001:9001 --rm --name node-container node-image```



***********

PHP CLIENT
## Container PHP construído com imagem php-apache de Dockerfile na pasta /client

- client/Dockerfile 
```
FROM php:7.2-apache

WORKDIR /var/www/html
```

## C1 - Build image of container PHP with Apache
>> ```docker build -t php-image -f client/Dockerfile .```

## C2 -Run container linked to node-container
>> Windows Powershell
```docker run -d -v "$(Get-Location)/client:/var/www/html" -p 8888:80 --link node-container --rm --name php-container php-image```

>> Terminal UNIX
```docker run -d -v $(pwd)/client:/var/www/html -p 8888:80 --link node-container --rm --name php-container php-image```




Additional commands
 - docker ps : show running containers
 - docker stop sample-container : stops the target-container