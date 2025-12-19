#!/bin/bash

# Script for deploying Laravel project to cPanel
# Usage: ./deploy.sh

DEPLOYPATH=/home/oopsszwf/public_html/

echo "Starting deployment..."

# Navigate to project directory (adjust if needed)
cd "$(dirname "$0")"

# Clear existing files (except important ones like .env if exists)
echo "Cleaning deployment directory..."
find $DEPLOYPATH -mindepth 1 -maxdepth 1 ! -name '.env' ! -name '.env.*' -exec rm -rf {} +

# Copy files excluding unnecessary ones
echo "Copying files..."
rsync -av \
  --exclude='.git' \
  --exclude='.gitignore' \
  --exclude='.gitattributes' \
  --exclude='node_modules' \
  --exclude='.env' \
  --exclude='.env.*' \
  --exclude='storage/logs/*' \
  --exclude='storage/framework/cache/*' \
  --exclude='storage/framework/sessions/*' \
  --exclude='storage/framework/views/*' \
  --exclude='.DS_Store' \
  --exclude='Thumbs.db' \
  --exclude='.idea' \
  --exclude='.vscode' \
  --exclude='*.log' \
  --exclude='deploy.sh' \
  ./ $DEPLOYPATH/

# Set permissions
echo "Setting permissions..."
chmod -R 755 $DEPLOYPATH/storage
chmod -R 755 $DEPLOYPATH/bootstrap/cache

# Create storage symlink
echo "Creating storage symlink..."
cd $DEPLOYPATH
php artisan storage:link || echo "Storage link already exists or failed"

# Cache configurations
echo "Caching configurations..."
php artisan config:cache || echo "Config cache failed"
php artisan route:cache || echo "Route cache failed"
php artisan view:cache || echo "View cache failed"

echo "Deployment completed!"

