FROM node:18-alpine

# Install dependencies
RUN apk add --no-cache \
    git \
    curl \
    bash

# Set working directory
WORKDIR /var/www/app

# Expose port 3001 for potential Node.js applications
EXPOSE 3001

# Command to keep container running
CMD ["tail", "-f", "/dev/null"]