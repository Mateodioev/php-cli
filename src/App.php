<?php

namespace Mateodioev\PhpEasyCli;

use function array_keys;

class App
{
    private Printer $printer;
    /**
     * @var array<string,callable>
     */
    protected array $register = [];

    public function __construct()
    {
        $this->printer = new Printer();
    }

    public function getPrinter(): Printer
    {
        return $this->printer;
    }

    /**
     * Register new command
     * @throws \Exception
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
     * Return callable function if the command is registered
     */
    public function getCommand(string $name): ?callable
    {
        return $this->register[$name] ?? null;
    }

    /**
     * @param array $argv
     * @param string $defaultCommand
     * @param callable|null $callback Function to run when command not found
     */
    public function run(array $argv, string $defaultCommand = 'help', ?callable $callback = null)
    {
        $cmdName = $argv[1] ?? $defaultCommand;
        $command = $this->getCommand($cmdName);

        if ($command == null) {
            if ($callback != null) {
                call_user_func($callback);
            } else {
                $this->getPrinter()->display(Color::Bg(150, Color::Fg(232, 'Command "' . $cmdName . '" not found')));
            }
            exit();
        }

        call_user_func($command, $argv);
    }
}