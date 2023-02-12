<?php

namespace Mateodioev\PhpEasyCli;

use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;
use function array_keys;

class App
{
    private Printer $printer;
    private Context $context;

    /**
     * @var array<string,callable>
     */
    protected array $register = [];

    public function __construct(array $args)
    {
        $this->printer = new Printer();
        $this->context = new Context($args);
    }

    public function getPrinter(): Printer
    {
        return $this->printer;
    }

    /**
     * Register new command
     * @param string $name Command name
     * @param callable $callable Function to run when command is called. The function must receive Context and Printer as parameters
     *
     * @throws \Exception
     */
    public function register(string $name, callable $callable): App
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
     * @param string $defaultCommand
     * @param callable|null $callback Function to run when command not found
     * @throws InvalidStyleException
     */
    public function run(string $defaultCommand = 'help', ?callable $callback = null): void
    {
        $cmdName = $this->context->get('input')[1] ?? $defaultCommand;
        $command = $this->getCommand($cmdName);

        if ($command == null) {
            if ($callback != null) {
                $this->executeCommand($callback);
            } else {
                $this->getPrinter()->display(Color::Bg(150, Color::Fg(232, 'Command "' . $cmdName . '" not found')));
            }
            exit();
        }

        $this->executeCommand($command);
    }

    private function executeCommand(callable $command): void
    {
        try {
            call_user_func($command, $this->context, $this->printer);
        } catch (\InvalidArgumentException $e) {
            $this->getPrinter()->display(Color::Bg(150, Color::Fg(232, $e->getMessage())));
        }
    }
}