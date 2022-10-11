# Grundlæggende setup for brug af RabbitMQ med PHP.

Klon projektet ned:
```
git clone https://github.com/MichaelAggerholm/PHP_RabbitMQ.git
```

### Terminal 1
Åben terminal og start rabbitMQ fra det officielle docker image:
```
docker run -it --rm --name rabbitmq -p 5672:5672 -p 15672:15672 rabbitmq:3.10-management
```

## Åben to terminaler:
Til kørsel af provider / consumer er det nemmest med to terminaler

### Terminal 2
Gå til directory, installer composer pakker og kør consume.php
```
cd Consumer
composer install
php consume.php
```
Nu er vores consumer klar til at tage imod beskeder fra broker.

### Terminal 3
Gå til directory, installer composer pakker og kør provide.php
```
cd Provider
composer install
php provide.php
```
Nu sendes beskeder fra provider og skulle gerne modtages af consumer

## Message queue
For at se nuværende message queue, kan vi fra vores rocker container bruge rabbitmqctl.

### Terminal 4
```
docker exec -it rabbitmq bash
rabbitmqctl list_queues
```
En nem måde at se queuen på, er at stoppe consumeren, starte provideren, se queue og først derefter lade consumeren hente beskeder igen. 