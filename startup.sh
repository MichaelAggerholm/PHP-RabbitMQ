#!/bin/bash

# Start the docker environment.
echo 'Starting docker environment'
docker-compose up -d
echo $'Docker environment started\n'
sleep 3

# Composer install for providers and consumer
echo 'Running composer install'
composer install --working-dir=providers/provider_one
composer install --working-dir=providers/provider_two
composer install --working-dir=providers/provider_three
composer install --working-dir=providers/provider_four
composer install --working-dir=consumer
echo $'Finished composer install\n'
sleep 3

echo 'Starting providers'
# Execute all providers, and log output to logfile.
for FILE in providers/provider_*/provide.php; do
  LOGFILE="output.log"
  echo "New providers run" > $LOGFILE
  php $FILE >> $LOGFILE &
done
echo $'Providers started\n'
sleep 3

echo "Starting consumer"
# Start consume.php in attach mode.
php consumer/consume.php
