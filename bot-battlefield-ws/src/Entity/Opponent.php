<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OpponentRepository")
 */
class Opponent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"public"})
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player")
     * @ORM\JoinColumn(nullable=false, unique=true)
     * @Groups({"public"})
     */
    private $playerOne;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player")
     * @ORM\JoinColumn(nullable=false, unique=true)
     * @Groups({"public"})
     */
    private $playerTwo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Game")
     * @Groups({"public"})
     */
    private $game;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerOne(): ?Player
    {
        return $this->playerOne;
    }

    public function setPlayerOne(Player $playerOne): self
    {
        $this->playerOne = $playerOne;

        return $this;
    }

    public function getPlayerTwo(): ?Player
    {
        return $this->playerTwo;
    }

    public function setPlayerTwo(Player $playerTwo): self
    {
        $this->playerTwo = $playerTwo;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }
}
