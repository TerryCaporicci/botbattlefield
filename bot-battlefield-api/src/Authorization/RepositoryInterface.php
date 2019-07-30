<?php

namespace Api\Authorization;

use Api\Entity\Entity;

interface RepositoryInterface
{

    /**
     * @param string $name
     * @param string $token
     *
     * @return Entity
     *
     * @throws InvalidArgumentException for existing player
     */
    public function findByAuthorization(string $name, string $token): Entity;

}
