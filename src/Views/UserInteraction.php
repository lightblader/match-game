<?php

use MatchGame\Controllers\MatchGame;
use MatchGame\Exceptions\UserRequestedExitException;

class UserInteraction {
    public static function getNumberOfMatches()
    {
        return self::getNumberInput('How many matches should we use?');
    }

    public static function userWantsToStartGame()
    {
        ColoredOutput::green('Do you want to go first? [yes, no]: ');
        $userWantsToStart = readline();
        return ($userWantsToStart === 'yes');
    }

    private static function getNumberInput($message, $min = MatchGame::MIN_NUMBER_OF_MATCHES, $max = MatchGame::MAX_NUMBER_OF_MATCHES)
    {
        $inputIsValid = false;
        $inputValue = null;
        while (!$inputIsValid) {
            ColoredOutput::green(sprintf("%s (%d - %d | Enter \"exit\" to leave the game): ", $message, $min, $max));
            $inputValue = readline();
            if ($inputValue === 'exit') {
                throw new UserRequestedExitException();
            }
            $inputIsValid = self::validateInputBoundaries((int) $inputValue, $min, $max);
        }
        return (int) $inputValue;
    }

    private static function validateInputBoundaries($value, $min, $max)
    {
        if ($value < $min || $value > $max) {
            ColoredOutput::red(sprintf("The value has to be between %d and %d!\n", $min, $max));
            return false;
        }
        return true;
    }

    public static function displayGameHeader()
    {
        ColoredOutput::yellow("##############################\n#");
        ColoredOutput::blue(" Welcome to the Match Game! ");
        ColoredOutput::yellow("#\n##############################\n\n");
        ColoredOutput::blue("Let's play!\n");
    }

    public static function printGameState($numberOfMatches)
    {
        ColoredOutput::white(sprintf("There are %d matches left.\n", $numberOfMatches));
        ColoredOutput::yellow(sprintf("%s\n", str_repeat('| ', $numberOfMatches)));
    }
}