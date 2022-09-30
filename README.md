# Runner

## First step - init project:
```ssh
git clone https://github.com/JaroslawZielinski/Runner.git
cd Runner
composer install
cp .env.dist .env
run/dockerized destroy
run/dockerized build
run/dockerized init
docker exec -it runner_php_1 ash -c "source .env && vendor/bin/phinx migrate -e development"
run/dockerized serverOnly
```
## Useful commands after that:
```ssh
run/dockerized all
```
