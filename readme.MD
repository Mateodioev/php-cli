# Cli apps

## Installation

```bash
composer require mateodioev/php-easy-cli
```

## Usage

```php
use Mateodioev\PhpEasyCli\{App, Color, Context, Printer};

$app = new App($argv);

$app->register('help', function(Context $ctx, Printer $printer) {
    $printer->display('Default command is help!!');
});

$app->register('hello', function(Context $ctx, Printer $printer) {
    $printer->display('Hello ' . $ctx->get('name', true, 'User name'));
});

$app->run();
```

```bash
php script.php hello --name=Mateo
```