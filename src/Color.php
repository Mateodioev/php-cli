<?php

namespace Mateodioev\PhpEasyCli;

use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;
use PHP_Parallel_Lint\PhpConsoleColor\InvalidStyleException;

/**
 * Color decorator
 * @see https://packagist.org/packages/php-parallel-lint/php-console-color
 */
class Color
{
    protected static ?ConsoleColor $consoleColor = null;

    private static function getInstance(): ConsoleColor
    {
        if (!self::$consoleColor instanceof ConsoleColor) {
            self::$consoleColor = new ConsoleColor();
        }

        return self::$consoleColor;
    }

    /**
     * @throws InvalidStyleException
     */
    public static function apply(string $style, string $text): string
    {
        return self::getInstance()->apply($style, $text);
    }

    /**
     * Background color
     * @param int $colorCode 0 - 255
     * @throws InvalidStyleException
     */
    public static function Bg(int $colorCode, string $text): string
    {
        return self::apply('bg_color_' . $colorCode, $text);
    }

    /**
     * Foreground color
     * @param int $colorCode 0 - 255
     * @throws InvalidStyleException
     */
    public static function Fg(int $colorCode, string $text): string
    {
        return self::apply('color_' . $colorCode, $text);
    }
}