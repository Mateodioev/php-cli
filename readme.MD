# Cli apps

## Installation

```bash
composer require mateodioev/php-easy-cli
```

## Usage

```php
$app = new \Mateodioev\PhpEasyCli\App();

$app->register('help', function() use ($app) {
    $app->getPrinter()->display('Default command is help!!');
});

$app->run($argv, 'help');
```