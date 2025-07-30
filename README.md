# Docker Development Environment

This repository contains a Docker setup for a PHP development environment with MySQL, Nginx, PHP-FPM, Node.js, and Composer.

## Services

- **Nginx**: Web server running on port 80
- **PHP**: PHP-FPM 8.2 with common extensions
- **MySQL**: MySQL 8.0 database server running on port 3306
- **Node.js**: Node.js 18 environment running on port 3001
- **Composer**: For PHP dependency management

## Requirements

- Docker
- Docker Compose

## Getting Started

1. Clone this repository
2. Start the Docker containers:

```bash
docker-compose up -d
```

3. Access the application in your browser:

```
http://localhost
```

## Database Connection

The MySQL database is configured with the following credentials:

- **Host**: mysql
- **Database**: app_db
- **Username**: app_user
- **Password**: app_password
- **Root Password**: root_password

You can connect to the MySQL server from your host machine using:

```bash
docker-compose exec mysql mysql -u app_user -p app_db
```

## PHP and Composer

The PHP service includes Composer, which is used to install dependencies defined in `src/composer.json`. Dependencies are automatically installed when the PHP container starts.

### Using the Composer Container

The Composer container is configured to run Composer commands and remain running, allowing you to interact with it throughout your development session. When you start the Docker environment with `docker-compose up -d`, the Composer container will:

1. Execute the default `install` command to install dependencies
2. Remain running so you can execute additional Composer commands as needed

You can interact with the running Composer container in two ways:

#### Option 1: Execute commands in the running container

```bash
docker-compose exec composer composer [command]
```

Examples:

```bash
# Update dependencies
docker-compose exec composer composer update

# Add a new package
docker-compose exec composer composer require vendor/package

# Show installed packages
docker-compose exec composer composer show
```

#### Option 2: Run a one-time command in a new container

If you prefer the traditional approach, you can still run one-off commands:

```bash
docker-compose run --rm composer [command]
```

Examples:

```bash
# Install dependencies
docker-compose run --rm composer install

# Update dependencies
docker-compose run --rm composer update

# Run Composer with specific PHP version
docker-compose run --rm composer --ignore-platform-reqs install
```

### Automatic Composer Installation

The PHP container is configured to automatically run `composer install` when it starts, ensuring that dependencies are always installed and up-to-date.

## Node.js

### Node.js in the PHP Container

Node.js 18 is installed directly in the PHP container and is automatically set up in both the main `/var/www/html` directory and the Laravel directory (if Laravel is installed). This allows you to use Node.js and npm directly in your PHP projects without needing a separate container.

#### Using Node.js in the Main Directory

When you place a `package.json` file in the `/var/www/html` directory, the PHP container will automatically:
1. Create an optimized `.npmrc` configuration file
2. Install npm dependencies
3. Build assets if a build configuration file (vite.config.js or webpack.config.js) is detected

To run Node.js commands in the main directory:

```bash
docker-compose exec php bash -c "cd /var/www/html && node [command]"
```

To run npm commands in the main directory:

```bash
docker-compose exec php bash -c "cd /var/www/html && npm [command]"
```

Examples:

```bash
# Check Node.js version
docker-compose exec php bash -c "cd /var/www/html && node --version"

# Install dependencies
docker-compose exec php bash -c "cd /var/www/html && npm install"

# Run a development server
docker-compose exec php bash -c "cd /var/www/html && npm run dev"

# Build assets
docker-compose exec php bash -c "cd /var/www/html && npm run build"
```

#### Using Node.js in the Laravel Directory

Node.js is also automatically set up in the Laravel directory. For more information on using Node.js with Laravel, see the [laravel-installation.md](laravel-installation.md) documentation.

### Node.js Service (Optional)

The Docker Compose configuration also includes a separate Node.js service that provides a dedicated Node.js 18 environment. This service is optional and can be used for more complex Node.js applications or when you need a separate environment for frontend development.

To run Node.js commands using the Node.js service:

```bash
docker-compose exec node node [command]
```

For example, to check the Node.js version:

```bash
docker-compose exec node node --version
```

To run npm commands using the Node.js service:

```bash
docker-compose exec node npm [command]
```

For example, to install dependencies:

```bash
docker-compose exec node npm install
```

## Directory Structure

- `docker/`: Contains Docker configuration files
  - `nginx/`: Nginx configuration
  - `php/`: PHP Dockerfile and configuration
  - `mysql/`: MySQL initialization scripts
  - `node/`: Node.js Dockerfile and configuration
- `src/`: Application source code

## Customization

- Modify `docker-compose.yml` to adjust service configurations
- Update `docker/php/Dockerfile` to install additional PHP extensions
- Update `docker/node/Dockerfile` to install additional Node.js packages or tools
- Add or modify MySQL initialization scripts in `docker/mysql/init/`
- Update Nginx configuration in `docker/nginx/default.conf`