<?php

namespace App\Controller\Ratchetable;

use Ratchet\ConnectionInterface;
use stdClass;

interface RatchetableInterface
{

    /**
     * @param array $clients
     * @param ConnectionInterface $from
     * @param stdClass $object
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function message(array $clients, ConnectionInterface $from, stdClass $object): void;

    /**
     * @param array $clients
     * @param ConnectionInterface $from
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function close(array $clients, ConnectionInterface $from): void;

}
