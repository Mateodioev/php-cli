<?php

use Mateodioev\PhpEasyCli\{App, Color};

require  __DIR__ . '/vendor/autoload.php';

$app = new App();

$app->register('help', function() use ($app) {
    $app->getPrinter()->display('Default command is help!!');
});

$app->register('name', function() use ($app) {
    $name = $app->getPrinter()->read('What is your name?: ');
    $app->getPrinter()->clear()
        ->display(Color::Fg(82, 'Hello ' . $name));
});
$app->run($argv, 'help');
