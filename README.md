# Task Management

### This is a simple task management system that allows you to create, read, update, delete and reorder (drag and drop) tasks. Created with Laravel 10 and Vue 3 (Composition API)

## Installation

### Step 1 : Clone the repository

```bash
git clone https://github.com/task-mgt.git
```

### Step 2 : Switch to the repo folder

```bash
cd task-mgt
```

### Step 3 : Copy the example env file and make the required configuration changes in the .env file

```bash
cp .env.example .env
```

### Step 4 : Create an empty database for our application

``
Create a database
then update the .env file with the database name, username and password
``

## Composer, Artisan and NPM commands

### Install dependencies

```bash
composer install
```

### Generate a new application key

```bash
php artisan key:generate
```

### Migrate the database

```bash
php artisan migrate
```

### Install node modules

```bash
npm install
```

### Build assets

```bash
npm run build
```

### Start the local development server

```bash
php artisan serve
```

### To test the application (Laravel Part)

```bash
php artisan test
```

## Or use `make` commands (if you have make installed)

### Install dependencies (after step 4)

```bash
make
```

### You can now access the server at http://localhost:8000

### You can read the make commands in the Makefile
