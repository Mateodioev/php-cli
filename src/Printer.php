<?php

namespace Mateodioev\PhpEasyCli;

use function system;

class Printer
{
    public function out(string $text): Printer
    {
        echo $text;
        return $this;
    }

    public function newLine(): Printer
    {
        return $this->out(PHP_EOL);
    }

    public function clear(): Printer
    {
        if (PHP_OS == 'WINNT') {
            system('cls');
        } else {
            system('clear');
        }

        $this->out("\e[H\e[J");
        return $this;
    }

    public function display(string $message): Printer
    {
        return $this->newLine()
            ->out($message)
            ->newLine()
            ->newLine();
    }
}