## Setup and install

Requirements include:
- Updated version of PHP (8.2.12v+)
- composer

## Installation using Composer

To setup the ENS backend:

```bash
$ rename all .dist files in autoload ( just remove .dist )
```

```bash
$ composer install
```

## If a new Entity is created in the DATABASE LOCAL

```bash
$ php vendor/bin/doctrine-module orm:clear-cache:metadata
```

```bash
$ php vendor/bin/doctrine-module orm:schema-tool:update --force --complete
```