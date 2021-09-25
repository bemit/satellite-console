# Orbiter: Satellite Console

[![Latest Stable Version](https://poser.pugx.org/orbiter/satellite-console/version.svg)](https://packagist.org/packages/orbiter/satellite-console)
[![Latest Unstable Version](https://poser.pugx.org/orbiter/satellite-console/v/unstable.svg)](https://packagist.org/packages/orbiter/satellite-console)
[![codecov](https://codecov.io/gh/bemit/satellite-console/branch/master/graph/badge.svg?token=FH1Q48P68T)](https://codecov.io/gh/bemit/satellite-console)
[![Total Downloads](https://poser.pugx.org/orbiter/satellite-console/downloads.svg)](https://packagist.org/packages/orbiter/satellite-console)
[![Github actions Build](https://github.com/bemit/satellite-console/actions/workflows/blank.yml/badge.svg)](https://github.com/bemit/satellite-console/actions)
[![PHP Version Require](http://poser.pugx.org/orbiter/satellite-console/require/php)](https://packagist.org/packages/orbiter/satellite-console)

Binding for [GetOpt](https://github.com/getopt-php/getopt-php) to use with [PSR-11 Container](https://www.php-fig.org/psr/psr-11/) and [PSR-3 Logger](https://www.php-fig.org/psr/psr-3/), support for annotating commands using Doctrine Annotations and [Orbiter\AnnotationUtil](https://github.com/bemit/orbiter-annotations-util),

```
composer require orbiter/satellite-console
```

## Dev Notices

Commands to set up and run e.g. tests:

```bash
# on windows:
docker run -it --rm -v %cd%:/app composer require --dev phpunit/phpunit

docker run -it --rm -v %cd%:/var/www/html php:8.0-cli-alpine sh

docker run --rm -v %cd%:/var/www/html php:8.0-cli-alpine sh -c "cd /var/www/html && ./vendor/bin/phpunit --testdox -c phpunit-ci.xml --bootstrap vendor/autoload.php"

# on unix:
docker run -it --rm -v `pwd`:/app composer install

docker run -it --rm -v `pwd`:/var/www/html php:8.0-cli-alpine sh

docker run --rm -v `pwd`:/var/www/html php:8.0-cli-alpine sh -c "cd /var/www/html && ./vendor/bin/phpunit --testdox -c phpunit-ci.xml --bootstrap vendor/autoload.php"
```

## Versions

This project adheres to [semver](https://semver.org/), **until `1.0.0`** and beginning with `0.1.0`: all `0.x.0` releases are like MAJOR releases and all `0.0.x` like MINOR or PATCH, modules below `0.1.0` should be considered experimental.

## License

This project is free software distributed under the [**MIT LICENSE**](LICENSE).

### Contributors

By committing your code to the code repository you agree to release the code under the MIT License attached to the repository.

***

Maintained by [Michael Becker](https://mlbr.xyz)
