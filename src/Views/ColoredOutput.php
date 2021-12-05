<?php

class ColoredOutput {
    const COLOR_CODE_RED = "\033[91m";
    const COLOR_CODE_GREEN = "\033[92m";
    const COLOR_CODE_BLUE = "\033[96m";
    const COLOR_CODE_YELLOW = "\033[93m";
    const COLOR_CODE_WHITE = "\033[0m";

    public static function red($text)
    {
        self::output($text, self::COLOR_CODE_RED);
    }

    public static function green($text)
    {
        self::output($text, self::COLOR_CODE_GREEN);
    }

    public static function blue($text)
    {
        self::output($text, self::COLOR_CODE_BLUE);
    }

    public static function yellow($text)
    {
        self::output($text, self::COLOR_CODE_YELLOW);
    }

    public static function white($text)
    {
        self::output($text, self::COLOR_CODE_WHITE);
    }

    private static function output($text, $color)
    {
        echo sprintf(
            '%s%s%s',
            $color,
            $text,
            self::COLOR_CODE_WHITE
        );
    }
}