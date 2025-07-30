FROM composer:latest

# Add bash for better scripting support
RUN apk add --no-cache bash

# Set working directory
WORKDIR /var/www/html

# Create entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set entrypoint
ENTRYPOINT ["docker-entrypoint.sh"]

# Default command (can be overridden)
CMD ["install"]