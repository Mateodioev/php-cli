<?php

namespace Mateodioev\PhpEasyCli;

use function array_keys;

class App
{
    private Printer $printer;
    protected $register = [];

    public function __construct()
    {
        $this->printer = new Printer();
    }

    /**
     * @return Printer
     */
    public function getPrinter()
    {
        return $this->printer;
    }

    /**
     * Register new command
     */
    public function register(string $name, $callable): App
    {
        if (isset($this->register[$name])) {
            throw new \Exception('Duplicate command');
        }

        $this->register[$name] = $callable;
        return $this;
    }

    /**
     * Return all commands names
     */
    public function getAllCommands(): array
    {
        return array_keys($this->register);
    }

    /**
     * Return callable function if the command is registeres
     */
    public function getCommand(string $name)
    {
        return $this->register[$name] ?? null;
    }

    /**
     * @param array $argv
     * @param string $defaultCommand
     */
    public function run(array $argv, string $defaultCommand = "help")
    {
        $cmdName = $argv[1] ?? $defaultCommand;
        $command = $this->getCommand($cmdName);

        if ($command == null) {
            $this->getPrinter()->display(Color::Bg(150, Color::Fg(232, 'Command "' . $cmdName . '" not found')));
            exit();
        }

        call_user_func($command, $argv);
    }
}