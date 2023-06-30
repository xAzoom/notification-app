## Instalacja

1. Stwórz folder var `mkdir var`
2. Zbuduj obrazy przy pomocy `./docker-build.sh` lub `USER_ID=$(id -u) GROUP_ID=$(id -g) USER_NAME=$(whoami) docker-compose build`
3. Uruchom kontenery `docker-compose up -d`
4. Załaduj dana `docker-compose run --rm php bin/console doctrine:fixtures:load -n -q`
5. Gotowe (przykładowy endpoint https://127.0.0.1:9500/api/accounts)

## Testy
1. `docker-compose exec php bash`
2. `composer test-db`
3. `bin/phpunit`