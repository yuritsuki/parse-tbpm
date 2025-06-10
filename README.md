# Laravel Zero Boilerplate

A custom Laravel Zero boilerplate for quickly building console applications with optional database support and Docker setup.

## Features

- Laravel Zero base
- Dockerized environment
- Optional database support
- Lightweight and customizable

## Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/yuritsuki/laravel-zero-boilerplate.git
cd laravel-zero-boilerplate
```

### 2. Fill .env (if database is needed)

```bash
cp .env.example .env
```

Update .env with your database settings:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=secret
```

### 3. Run Docker

```bash
docker-compose up -d
```

This will start the required containers (e.g., database).


