# Grundlæggende setup for brug af RabbitMQ med PHP.

#### Klon projektet ned:
```
git clone https://github.com/MichaelAggerholm/PHP_RabbitMQ.git
```

### Terminal 1
#### Åben terminal og start docker miljø op:
```
cd PHP_RabbitMQ
sudo docker-compose up -d
```
Dette starter to docker containers op fra deres officielle docker images:
##### couchdb
port: 5984
url: localhost:5984/_utils
username: admin
password: YOURPASSWORD

##### rabbitmq
port: 5672
###### commands:
docker exec -it rabbitmq bash
rabbitmqctl list_queues
_En nem måde at se queuen på, er at stoppe consumeren, starte provideren, se queue og først derefter lade consumeren hente beskeder igen._

## Åben hver provider i hver sin terminal:
Til kørsel af provider / consumer er det nemmest med én terminal for consumer og én terminal per provider

### Terminal 2
#### Gå til consumer directory, installer composer pakker og kør consume.php:
```
cd consumer
composer install
php consume.php
```
Nu er vores consumer klar til at tage imod beskeder fra RabbitMQ queue.

### Terminal 3
#### Gå til providers/provider_one directory, installer composer pakker og kør provide.php:
```
cd providers/provider_one
composer install
php provide.php
```

### Terminal 4
#### Gå til providers/provider_two directory, installer composer pakker og kør provide.php:
```
cd providers/provider_two
composer install
php provide.php
```

### Terminal 5
#### Gå til providers/provider_three directory, installer composer pakker og kør provide.php:
```
cd providers/provider_three
composer install
php provide.php
```
### Terminal 6
#### Gå til providers/provider_four directory, installer composer pakker og kør provide.php:
```
cd providers/provider_four
composer install
php provide.php
```

Nu sendes beskeder fra providers og modtages af consumer.

## Hjælpe commands ved test kørsler

#### Stop og fjern containers + images
```
docker stop $(docker ps -aq)
docker rm $(docker ps -aq)
docker rmi $(docker images -q)
```

#### Kill hvad end der bruger min nuværende port:
```
sudo netstat -lpn |grep :5672
sudo kill -9 5672
```

#### Giv ejerskab af mappen:
```
sudo chown -R $USER:$USER PHP_RabbitMQ/
```