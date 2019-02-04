# Runner

## First step - init project:
```ssh
git clone https://github.com/JaroslawZielinski/Runner.git
cd Runner
composer install
run/dockerized destroy
run/dockerized build
run/dockerized init
vendor/bin/phinx migrate -e development
run/dockerized serverOnly
```
## Useful commands after that:
```ssh
run/dockerized all
```