#!/bin/bash
set -e

# Run composer install
cd /var/www/html
composer install

# Set up Node.js in the main /var/www/html directory
echo "Setting up Node.js in the /var/www/html directory..."

# Create a .npmrc file to configure npm
echo "Creating .npmrc file in /var/www/html..."
cat > .npmrc << EOF
# NPM configuration for main directory
cache=/var/www/html/.npm-cache
prefer-offline=true
fund=false
EOF

# Check if package.json exists in the main directory
if [ -f "package.json" ]; then
    echo "Installing npm dependencies in /var/www/html..."
    npm install
    
    # Build assets if needed
    if [ -f "vite.config.js" ] || [ -f "webpack.config.js" ]; then
        echo "Building assets in /var/www/html..."
        npm run build
    fi
    
    echo "Node.js setup complete in /var/www/html directory."
    echo "You can now run npm commands directly in the /var/www/html directory using the PHP container."
    echo "Example: docker-compose exec php bash -c \"cd /var/www/html && npm run dev\""
fi

# Check if Laravel is installed and install it if not
if [ ! -d "/var/www/html/laravel" ]; then
    echo "Laravel not found. Installing Laravel..."
    composer create-project --prefer-dist laravel/laravel laravel
    
    # Set proper permissions
    chown -R www-data:www-data /var/www/html/laravel
    chmod -R 775 /var/www/html/laravel/storage /var/www/html/laravel/bootstrap/cache
    
    echo "Laravel installed successfully!"
fi

# Set up Node.js in the Laravel directory
cd /var/www/html/laravel

# Check if package.json exists
if [ -f "package.json" ]; then
    echo "Setting up Node.js in the Laravel directory..."
    
    # Create a .npmrc file to configure npm
    echo "Creating .npmrc file..."
    cat > .npmrc << EOF
# NPM configuration for Laravel
cache=/var/www/html/laravel/.npm-cache
prefer-offline=true
fund=false
EOF
    
    # Install npm dependencies
    echo "Installing npm dependencies for Laravel..."
    npm install
    
    # Build assets if needed
    if [ -f "vite.config.js" ]; then
        echo "Building Laravel assets with Vite..."
        npm run build
    fi
    
    echo "Node.js setup complete in Laravel directory."
    echo "You can now run npm commands directly in the Laravel directory using the PHP container."
    echo "Example: docker-compose exec php bash -c \"cd /var/www/html/laravel && npm run dev\""
fi

# Return to the original directory
cd /var/www/html

# Start php-fpm
exec php-fpm