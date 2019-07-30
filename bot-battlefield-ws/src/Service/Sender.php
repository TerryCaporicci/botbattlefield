<?php

namespace App\Service;

use App\Entity\Opponent;
use Ratchet\ConnectionInterface;

/**
 * Class Sender
 * @package App\Service
 */
final class Sender
{

    public function __construct(Serializator $serializator)
    {
        $this->serializator = $serializator;
    }

    /**
     * @param array $clients
     * @param string $json
     */
    public function send(array $clients, string $json)
    {
        foreach ($clients as $client) {
            $client->getConnection()->send($json);
        }
    }

    public function sendOpponent(ConnectionInterface $from, Opponent $opponent) {
        $from->send(
            $this->serializator->serialize($opponent, "opponent", ["public"])
        );
    }

}