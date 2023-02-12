<?php

use Mateodioev\PhpEasyCli\{App, Color, Context, Printer};

require  __DIR__ . '/vendor/autoload.php';

$app = new App($argv);

$app->register('help', function(Context $ctx, Printer $printer) {
    $printer->display('Default command is help');
});

$app->register('color', function(Context $ctx, Printer $printer) {
    $code = (int) $ctx->get('code', true, 'Color code');

    $printer->display(Color::Fg($code, 'Hello world with color'));
});

$app->register('name', function(Context $ctx, Printer $printer) use ($app) {
    $name = $printer->read('What is your name?: ');
    $pass = $printer->readPassword('Write your password: ', true);

    $printer->clear()
        ->display(Color::Fg(82, 'Hello ' . $name . ' your password is: ' . $pass));
});

$app->run('help', function (Context $ctx, Printer $printer) {
    $printer->display('Example of callback function when command not found');
});
