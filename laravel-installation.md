# Automatic Laravel Installation

This document explains how Laravel is automatically installed in the Docker environment and provides instructions for working with Laravel.

## Automatic Installation Process

The Docker environment is configured to automatically install Laravel when the containers are started. Here's how it works:

1. When the PHP container starts, the entrypoint script checks if Laravel is already installed in the `/var/www/html/laravel` directory.
2. If Laravel is not found, the script uses Composer to create a new Laravel project in that directory.
3. The script sets proper permissions on Laravel directories that need to be writable (storage and bootstrap/cache).
4. If Laravel has a package.json file, npm dependencies are installed automatically.
5. If Laravel uses Vite (detected by the presence of vite.config.js), assets are built automatically.

This means that you don't need to manually install Laravel - it's done automatically when you start the Docker environment with `docker-compose up -d`.

## Accessing Laravel

Once the Docker environment is running, you can access the Laravel application at:

```
http://localhost
```

The Nginx server is configured to serve the Laravel application from its public directory.

## Working with Laravel

### Running Artisan Commands

You can run Laravel Artisan commands using the PHP container:

```bash
docker-compose exec php php /var/www/html/laravel/artisan <command>
```

For example, to list all available commands:

```bash
docker-compose exec php php /var/www/html/laravel/artisan list
```

To create a new controller:

```bash
docker-compose exec php php /var/www/html/laravel/artisan make:controller UserController
```

### Database Configuration

Laravel is configured to use the MySQL database included in the Docker environment. The default database configuration in Laravel's `.env` file should be updated to match the Docker environment:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=app_db
DB_USERNAME=app_user
DB_PASSWORD=app_password
```

You can update this configuration by running:

```bash
docker-compose exec php bash -c "cd /var/www/html/laravel && sed -i 's/DB_HOST=127.0.0.1/DB_HOST=mysql/g' .env && sed -i 's/DB_DATABASE=laravel/DB_DATABASE=app_db/g' .env && sed -i 's/DB_USERNAME=root/DB_USERNAME=app_user/g' .env && sed -i 's/DB_PASSWORD=/DB_PASSWORD=app_password/g' .env"
```

### Running Migrations

After configuring the database, you can run Laravel migrations:

```bash
docker-compose exec php php /var/www/html/laravel/artisan migrate
```

### Frontend Development

Node.js is automatically installed in the Laravel directory when Laravel is installed. This means you can run npm commands directly using the PHP container. If you make changes to the frontend code, you can rebuild the assets by running:

```bash
docker-compose exec php bash -c "cd /var/www/html/laravel && npm run build"
```

For development with hot reloading, you can use:

```bash
docker-compose exec php bash -c "cd /var/www/html/laravel && npm run dev"
```

#### Using npm in the Laravel Directory

When you navigate to the Laravel directory on your host machine, npm commands won't work directly because npm is installed in the Docker container, not on your host machine. To use npm commands, you need to execute them through the PHP container:

```bash
# From the project root:
docker-compose exec php bash -c "cd /var/www/html/laravel && npm <command>"
```

For example:

```bash
# Install dependencies
docker-compose exec php bash -c "cd /var/www/html/laravel && npm install"

# Run development server
docker-compose exec php bash -c "cd /var/www/html/laravel && npm run dev"

# Build assets
docker-compose exec php bash -c "cd /var/www/html/laravel && npm run build"

# Check npm version
docker-compose exec php bash -c "cd /var/www/html/laravel && npm --version"
```

**Creating a Helper Script (Optional)**

If you find yourself frequently running npm commands, you might want to create a simple shell alias or function in your `.bashrc` or `.zshrc` file:

```bash
# Add this to your .bashrc or .zshrc file
laravel-npm() {
  docker-compose -f /path/to/project/docker-compose.yml exec php bash -c "cd /var/www/html/laravel && npm $*"
}
```

Then you can use it like this:

```bash
laravel-npm install
laravel-npm run dev
laravel-npm run build
```

### Installing Additional Packages

To install additional Composer packages:

```bash
docker-compose exec php bash -c "cd /var/www/html/laravel && composer require <package>"
```

To install additional npm packages:

```bash
docker-compose exec php bash -c "cd /var/www/html/laravel && npm install <package>"
```

For example, to install the lodash package:

```bash
docker-compose exec php bash -c "cd /var/www/html/laravel && npm install lodash"
```

If you created the helper function mentioned in the Frontend Development section, you can use it like this:

```bash
laravel-npm install lodash
```

## Customizing Laravel Installation

If you want to customize the Laravel installation process, you can modify the PHP container's entrypoint script at `docker/php/docker-entrypoint.sh`. For example, you might want to:

- Install a specific version of Laravel
- Apply specific configuration changes
- Install additional packages by default

After modifying the entrypoint script, rebuild and restart the containers:

```bash
docker-compose down
docker-compose up -d --build
```

## Troubleshooting

### Permission Issues

If you encounter permission issues with Laravel, you can fix them by running:

```bash
docker-compose exec php bash -c "chown -R www-data:www-data /var/www/html/laravel && chmod -R 775 /var/www/html/laravel/storage /var/www/html/laravel/bootstrap/cache"
```

### Laravel Not Installing

If Laravel doesn't install automatically, check the PHP container logs:

```bash
docker-compose logs php
```

Look for any error messages related to Composer or Laravel installation.

### Database Connection Issues

If Laravel can't connect to the database, make sure the database container is running and the Laravel `.env` file has the correct database configuration as described above.