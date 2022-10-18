#!/bin/bash

# Start the docker environment.
echo 'Starting docker environment'
docker-compose up -d
echo $'Docker environment started\n'
sleep 3

# Composer install for all providers
echo $'Running composer install for each supplier'
for d in providers/*; do
composer install --working-dir=$d
echo $'Finished composer install for $d\n'
sleep 1
done

# Composer install for consumer
echo $'Running composer install for consumer'
composer install --working-dir=consumer
echo $'Finished composer install for consumer\n'
sleep 2

echo 'Starting providers'
# Execute all providers, and log output to logfile.
for FILE in providers/provider_*/provide.php; do
  LOGFILE="output.log"
  echo "New providers run" > $LOGFILE
  php $FILE >> $LOGFILE &
done
echo $'Providers started\n'
sleep 2

echo "Starting consumer"
sleep 2
# Start consume.php in attach mode.
php consumer/consume.php
