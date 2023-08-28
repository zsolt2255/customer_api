#!/bin/bash
WORKING_DIR="/var/www"

echo "Setup entrypoint"
chown -R www-data:www-data $WORKING_DIR/storage

if [ -d $WORKING_DIR ]; then

  cd $WORKING_DIR || exit

  if ! [ -d ./vendor ];  then
    echo "Vendor does not exist. Composer install..."
    composer install --no-scripts
    php artisan key:generate
  fi

  echo "Setup storage directory tree"
  mkdir -p storage/framework/sessions
  mkdir -p storage/framework/views
  mkdir -p storage/framework/cache
  composer dump-autoload
  chmod -R 777 $WORKING_DIR/storage

  echo "Cache clear"
  php artisan optimize

  php -S 0.0.0.0:8000 -t /var/www/public

else
  printf "Error: '%s' directory not found!" $WORKING_DIR
  exit 1
fi
