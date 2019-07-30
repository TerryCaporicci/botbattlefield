<?php

namespace App\Service;

use App\Repository\PlayerRepository;
use App\Entity\Player as PlayerEntity;

/**
 * Class Player
 * @package App\Service
 */
final class Player
{

    private
        /**
         * @var PlayerRepository
         */
        $repository;

    /**
     * Player constructor.
     * @param PlayerRepository $repository
     */
    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $token
     * @return PlayerEntity
     *
     * @throws \RuntimeException Can't process entity
     */
    public function getPlayer(string $token): PlayerEntity
    {
        if (!($player = $this->repository->findOneByToken($token))) {
            throw new \RuntimeException("Not Found: " . $token);
        }
        return $player;
    }

    /**
     * @param array $clients
     * @return array
     */
    public function getPlayers(array $clients): array
    {
        $players = [];
        foreach ($clients as $client) {
            if (!$client->getOpponent()) {
                $players[] = $client->getPlayer();
            }
        }
        return $players;
    }

}