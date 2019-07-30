<?php

namespace App\Entity;

use App\Socket\ClientInterface;
use Doctrine\ORM\Mapping as ORM;
use Ratchet\ConnectionInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client implements ClientInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player")
     */
    private $player;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Opponent")
     */
    private $opponent;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * @param ConnectionInterface $connection
     * @return ClientInterface
     */
    public function setConnection(ConnectionInterface $connection): ClientInterface
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return Player|null
     */
    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    /**
     * @param Player $player
     * @return Client
     */
    public function setPlayer(Player $player): self
    {
        $this->player = $player;
        return $this;
    }

    /**
     * @return Opponent|null
     */
    public function getOpponent(): ?Opponent
    {
        return $this->opponent;
    }

    /**
     * @param Opponent|null $opponent
     * @return Client
     */
    public function setOpponent(?Opponent $opponent): self
    {
        $this->opponent = $opponent;

        return $this;
    }

}
