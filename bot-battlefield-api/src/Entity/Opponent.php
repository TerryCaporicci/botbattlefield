<?php

namespace Api\Entity;


class Opponent extends Entity implements \JsonSerializable
{

    private
        /**
         * @var int
         */
        $id,
        /**
         * @var Player
         */
        $player1,
        /**
         * @var Player
         */
        $player2;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Opponent
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer1(): Player
    {
        return $this->player1;
    }

    /**
     * @param Player $player1
     * @return Opponent
     */
    public function setPlayer1(Player $player1): self
    {
        $this->player1 = $player1;
        return $this;
    }

    /**
     * @return Player
     */
    public function getPlayer2(): Player
    {
        return $this->player2;
    }

    /**
     * @param Player $player2
     * @return Opponent
     */
    public function setPlayer2(Player $player2): self
    {
        $this->player2 = $player2;
        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "player_1" => $this->player1,
            "player_2" => $this->player2,
        ];
    }

}
