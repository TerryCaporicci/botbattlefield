<?php

namespace App\Controller\Ratchetable;

use App\Service\Sender;
use stdClass;
use App\Service\Player;
use App\Service\Serializator;
use Ratchet\ConnectionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlayerController extends AbstractController implements RatchetableInterface
{

    private
        /**
         * @var Serializator
         */
        $serializator,
        /**
         * @var Serializator
         */
        $sender,
        /**
         * @var Player
         */
        $player;

    /**
     * PlayerController constructor.
     * @param Serializator $serializator
     * @param Sender $sender
     * @param Player $player
     */
    public function __construct(
        Serializator $serializator,
        Sender $sender,
        Player $player)
    {
        $this->serializator = $serializator;
        $this->sender = $sender;
        $this->player = $player;
    }

    /**
     * @param array $clients
     * @param ConnectionInterface $from
     * @param stdClass $object
     *
     * @throws \RuntimeException
     */
    public function message(array $clients, ConnectionInterface $from, stdClass $object): void
    {
        foreach ($clients as $client) {
            if ($client->getPlayer() || $from !== $client->getConnection()) {
                continue;
            }
            $client->setPlayer($this->player->getPlayer($object->token));
            $this->sender->send(
                $clients,
                $this->serializator->serialize($this->player->getPlayers($clients), "players", ["public"])
            );
        }
    }

    /**
     * @param array $clients
     * @param ConnectionInterface $from
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function close(array $clients, ConnectionInterface $from): void
    {
        $this->sender->send(
            $clients,
            $this->serializator->serialize($this->player->getPlayers($clients), "players", ["public"])
        );
    }

}
