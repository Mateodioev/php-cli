<?php

namespace Mateodioev\PhpEasyCli;

class Context
{
    /**
     * @param array<string,mixed> $args
     */
    public function __construct(
        private array $args
    ) {
        $this->parseArguments($this->args);
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * Return and argument
     * Example: `php script.php --help`
     * @param string $key Key to find, example: `help`
     * @param bool $forced Pass true to throw an exception when key not found
     * @return mixed
     */
    public function get(string $key, bool $forced = false, ?string $description = null): mixed
    {
        if (!array_key_exists($key, $this->args) && $forced) {
            throw new \InvalidArgumentException($this->buildErrorMessage($key, $description));
        }

        return $this->args[$key] ?? null;
    }

    private function parseArguments(): void
    {
        $args = [];

        foreach ($this->args as $argument) {
            // match --argument=value
            if (preg_match('/--([^=]+)=(.*)/',$argument,$reg)) {
                $args[$reg[1]] = $reg[2];
                // match --argument
            } elseif (preg_match('/^--([a-zA-Z0-9]+)/', $argument, $reg)) {
                $args[$reg[1]] = true;

                // match -o
            } elseif(preg_match('/^-([a-zA-Z0-9])/',$argument,$reg)) {
                $args[$reg[1]] = true;
                // Other
            } else {
                $args['input'][] = $argument;

            }
        }

        $this->args = $args;
    }
    private function buildErrorMessage(string $key, ?string $description = null): string
    {
        if ($description !== null) {
            return 'Missing argument: ' . $key . ' - ' . $description;
        } else {
            return 'Missing argument: ' . $key;
        }
    }
}