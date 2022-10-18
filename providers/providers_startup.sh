#!/bin/bash

for FILE in provider_*/provide.php; do
  LOGFILE="output.log"
  echo "Starting new run" > $LOGFILE
  php $FILE >> $LOGFILE &
done
