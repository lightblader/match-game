<?php

namespace MatchGame\Controllers;

use ColoredOutput;
use MatchGame\Exceptions\UserRequestedExitException;
use UserInteraction;

class MatchGame
{
    const MIN_NUMBER_OF_MATCHES = 1;
    const MAX_NUMBER_OF_MATCHES = 100;
    const MIN_MATCHES_REMOVED_PER_TURN = 1;
    const MAX_MATCHES_REMOVED_PER_TURN = 3;

    protected $currentNumberOfMatches;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function __construct()
    {
        try {
            UserInteraction::displayGameHeader();
            $this->currentNumberOfMatches = UserInteraction::getNumberOfMatches();
            $userWantsToStart = UserInteraction::userWantsToStartGame();
            $this->handleMove($userWantsToStart);
        } catch (UserRequestedExitException $e) {
            echo 'Good Bye';
        }
    }

    private function handleMove($userMove = false)
    {
        UserInteraction::printGameState($this->currentNumberOfMatches);
        if ($userMove) {
            $numberOfMatchesTaken = UserInteraction::getNumberOfMatches(
                // 'How many matches do you want to take?',
                // self::MIN_MATCHES_REMOVED_PER_TURN,
                // min(self::MAX_MATCHES_REMOVED_PER_TURN, $this->currentNumberOfMatches)
            );
            $this->currentNumberOfMatches -= $numberOfMatchesTaken;
        } else {
            $this->handleComputerMove();
        }
        if ($this->continueGame($userMove)) {
            return $this->handleMove(!$userMove);
        }
    }

    private function continueGame($userMove)
    {
        if ($this->currentNumberOfMatches < self::MIN_NUMBER_OF_MATCHES) {
            echo sprintf('%s won the game', $userMove ? 'You have' : 'The computer has');
            return false;
        }
        return true;
    }

    private function handleComputerMove()
    {
        $desiredRemainingMatches = self::MAX_MATCHES_REMOVED_PER_TURN + 1;
        $matchesToRemove = $this->currentNumberOfMatches % $desiredRemainingMatches;
        if ($matchesToRemove < self::MIN_MATCHES_REMOVED_PER_TURN) {
            $matchesToRemove = self::MIN_MATCHES_REMOVED_PER_TURN;
        }
        echo sprintf('Computer removes %d matches', $matchesToRemove);
        $this->currentNumberOfMatches -= $matchesToRemove;
    }
}
