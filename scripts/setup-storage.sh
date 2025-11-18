#!/bin/bash

# Script to setup storage for Railway deployment
# This ensures storage link exists and permissions are correct

echo "Setting up storage..."

# Create storage directories if they don't exist
mkdir -p storage/app/public/berita
mkdir -p storage/app/public/gallery
mkdir -p storage/framework/{sessions,views,cache,testing}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Create storage link if it doesn't exist
if [ ! -L public/storage ]; then
    echo "Creating storage link..."
    php artisan storage:link
else
    echo "Storage link already exists"
fi

echo "Storage setup complete!"

