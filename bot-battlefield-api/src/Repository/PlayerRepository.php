<?php

namespace Api\Repository;

use Api\Authorization\RepositoryInterface;
use Api\Database\Manager;
use Api\Entity\Entity;
use Api\Entity\Player;

class PlayerRepository implements RepositoryInterface
{

    /**
     * @return array of Player
     */
    public function findAll(): array
    {
        $sth = Manager::getConnection()->prepare("SELECT * FROM `player`");
        $sth->setFetchMode(\PDO::FETCH_CLASS, Player::class);
        $sth->execute();
        return $sth->fetchAll();
    }

    /**
     * @param string $name
     * @return Player
     *
     * @throws InvalidArgumentException for not found player
     */
    public function findOneByName(string $name): Player
    {
        $sth = Manager::getConnection()->prepare("SELECT * FROM `player` WHERE `name`=:name");
        $sth->bindValue(":name", $name);
        $sth->setFetchMode(\PDO::FETCH_CLASS, Player::class);
        $sth->execute();
        if (!($player = $sth->fetch())) {
            throw new \InvalidArgumentException();
        }
        return $player;
    }

    /**
     * @param Player $player
     * @return Player
     *
     * @throws InvalidArgumentException for existing player
     */
    public function persist(Player $player): Player
    {
        $sql = "INSERT INTO `player` (`name`, `token`, `ready`) VALUES (:name, :token, :ready)";
        try {
            $sth = Manager::getConnection()->prepare($sql);
            $sth->bindValue(":name", $player->getName());
            $sth->bindValue(":token", $player->getToken());
            $sth->bindValue(":ready", $player->getReady());
            $sth->execute();
            $player->setId(Manager::getConnection()->lastInsertId());
        } catch (\PDOException $e) {
            throw new \InvalidArgumentException();
        }
        return $player;
    }

    /**
     * @param string $name
     * @param string $token
     *
     * @return Entity
     *
     * @throws InvalidArgumentException for existing player
     */
    public function findByAuthorization(string $name, string $token): Entity
    {
        $sth = Manager::getConnection()->prepare("SELECT * FROM `player` WHERE `name`=:name AND `token`=:token");
        $sth->bindValue(":name", $name);
        $sth->bindValue(":token", $token);
        $sth->setFetchMode(\PDO::FETCH_CLASS, Player::class);
        $sth->execute();
        if (!($player = $sth->fetch())) {
            throw new \InvalidArgumentException();
        }
        return $player;
    }

}
