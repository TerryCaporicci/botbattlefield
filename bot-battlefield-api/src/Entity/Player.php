<?php

namespace Api\Entity;


class Player extends Entity implements \JsonSerializable
{

    private
        /**
         * @var int
         */
        $id,
        /**
         * @var string
         */
        $name,
        /**
         * @var string
         */
        $token,
        /**
         * @var int
         */
        $ready;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Players
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Players
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Players
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return int
     */
    public function getReady(): int
    {
        return $this->ready;
    }

    /**
     * @param int $ready
     * @return Players
     */
    public function setReady(int $ready): self
    {
        $this->ready = $ready;
        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "token" => $this->token,
            "ready" => $this->ready,
        ];
    }

}
