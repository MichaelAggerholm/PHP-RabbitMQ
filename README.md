# Datahåndtering med PHP, RabbitMQ og CouchDB.

## Projekt kørsel

### Klon projektet ned:
```
git clone https://github.com/MichaelAggerholm/PHP_RabbitMQ.git
```

### Start projektet op:
```
cd PHP_RabbitMQ
./startup.sh
```

## Projekt forklaring

### Startup script
Startup script kører følgene steps igennem:
1. docker-composer up -d ( _Starter rabbitmq og couchdb fra officielle images_) 
2. composer install ( _Går ind og laver en composer install i alle consumer / provider directories_ )
3. Start alle provider php scripts og pipe alt output til output.log fil
4. Start consumer php script i attached mode

Nu sendes beskeder fra providers og modtages af consumer, heri bliver dataen håndteret, og gemt i CouchDB.<br />
Måden dataen håndteres er ved kun at beholde værdier af relevans, i dette tilfælde har jeg valgt alle værdier over 89.<br />

### Docker Containers

#### couchdb
port: 5984<br />
url: localhost:5984/_utils<br />
username: admin<br />
password: YOURPASSWORD

#### rabbitmq
port: 5672
##### commands:
docker exec -it rabbitmq bash<br />
rabbitmqctl list_queues<br />
_En nem måde at se queuen på, er at stoppe consumeren, starte provideren, se queue og først derefter lade consumeren hente beskeder igen._

## Hjælpe commands ved test kørsler

#### Stop og fjern containers + images:
```
docker stop $(docker ps -aq)
docker rm $(docker ps -aq)
docker rmi $(docker images -q)
```

#### Stop og fjern rabbitmq/couchdb containers:
```
docker stop rabbitmq couchdb
docker rm rabbitmq couchdb
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

#### Dræb alle php processer startet af script:
```
sudo killall php
```

#### Hvis der er problemer med "Rabbitmq already running" på trods af ingen containers kørende:
```
sudo systemctl stop rabbitmq-server.service
```
