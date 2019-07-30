<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Game;
use App\Service\Sender;
use Ratchet\ConnectionInterface;

/**
 * Class Opponent
 * @package App\Service
 */
final class Opponent
{
    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function createOpponent(Client $clientOne, Client $clientTwo)
    {
        $opponent = (new \App\Entity\Opponent())->setPlayerOne($clientOne->getPlayer())->setPlayerTwo($clientTwo->getPlayer());
        $clientOne->setOpponent($opponent);
        $clientTwo->setOpponent($opponent);

        $this->sender->sendOpponent($clientTwo->getConnection(), $clientTwo->getOpponent());
    }

    public function createGame(Client $clientOne) {
        $game = new Game();
        $clientOne->getOpponent()->setGame($game);
        $this->sender->sendOpponent($clientOne->getConnection(), $clientOne->getOpponent());
    }
}
