<?php

namespace App\Controller\Ratchetable;

use App\Service\Client as ClientService;
use App\Entity\Client;
use App\Entity\Game;
use mysql_xdevapi\Exception;
use stdClass;
use Ratchet\ConnectionInterface;
use App\Service\Player;
use App\Service\Sender;
use App\Service\Serializator;
use App\Entity\Opponent;
use App\Service\Opponent as OpponentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class OpponentController extends AbstractController implements RatchetableInterface
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
        $player,
        /**
         * @var Player
         */
        $opponent;

    /**
     * OpponentController constructor.
     * @param Serializator $serializator
     * @param Sender $sender
     * @param Player $player
     * @param OpponentService $opponent
     */
    public function __construct(
        Serializator $serializator,
        Sender $sender,
        Player $player,
        OpponentService $opponent,
        ClientService $client)
    {

        $this->serializator = $serializator;
        $this->sender = $sender;
        $this->player = $player;
        $this->opponent = $opponent;
        $this->client = $client;
    }

    /**
     * @param array $clients
     * @param ConnectionInterface $from
     */
    private function remove(array $clients, ConnectionInterface $from)
    {
        foreach ($clients as $client) {
            if ($from !== $client->getConnection()) {
                continue;
            }
            $client->setOpponent(null);
            $this->close($clients, $from);
            return;
        }
    }

    /**
     * @param array $clients
     * @param ConnectionInterface $from
     * @param stdClass $object
     *
     * @throws \RuntimeException
     */
    private function create(array $clients, ConnectionInterface $from, stdClass $object)
    {
        $clientOne =  $this->client->getClientByPlayer($clients, $object->playerOne);
        $clientTwo = $this->client->getClientByPlayer($clients, $object->playerTwo);
        if (!$clientOne->getOpponent()
            && !$clientTwo->getOpponent()
            && $this->client->verifyToken($clientOne, $object->playerOne)
            && $clientOne->getConnection() === $from) {
            return  $this->opponent->createOpponent($clientOne, $clientTwo);
        }
        if ($clientOne->getOpponent()
        && $clientTwo->getOpponent()
        && $clientOne->getOpponent() === $clientTwo->getOpponent()
        && $clientTwo === $from);
        return $this->opponent->createGame($clientOne);
    }

        /**
     * @param array $clients
     * @param ConnectionInterface $from
     * @param stdClass $object
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function message(array $clients, ConnectionInterface $from, stdClass $object): void
    {
        !$object->playerOne || !$object->playerTwo
            ? $this->remove($clients, $from)
            : $this->create($clients, $from, $object);
        $this->sender->send(
            $clients,
            $this->serializator->serialize($this->player->getPlayers($clients), "players", ["public"])
        );
    }

    /**
     * @param array $clients
     * @param ConnectionInterface $from
     * @return mixed
     */
    public function close(array $clients, ConnectionInterface $from): void
    {
        foreach ($clients as $clientToUnsetOpponent) {
            if (!$clientToUnsetOpponent->getOpponent()) {
                continue;
            }
            try {
                foreach ($clients as $client) {
                    if ($client->getOpponent()
                        && $clientToUnsetOpponent->getPlayer()->getId() !== $client->getPlayer()->getId()
                        && $clientToUnsetOpponent->getOpponent() === $client->getOpponent()) {
                        throw new \LogicException();
                    }
                }
                $clientToUnsetOpponent
                    ->setOpponent(null)
                    ->getConnection()->send(
                        $this->serializator->serialize(new Opponent(), "opponent", ["public"])
                    );
            } catch (\LogicException $e) {
            }
        }
    }

}
