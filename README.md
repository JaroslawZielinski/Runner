# Runner

in [packagist](https://packagist.org/packages/jaroslawzielinski/runner)

[!["Buy Me A Coffee"](https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png)](https://www.buymeacoffee.com/jaroslawzielinski)

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
