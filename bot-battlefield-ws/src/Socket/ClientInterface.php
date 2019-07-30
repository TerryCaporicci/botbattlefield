<?php

namespace App\Socket;

use Ratchet\ConnectionInterface;

/**
 * Interface ClientInterface
 * @package App\Socket
 */
interface ClientInterface
{

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface;

    /**
     * @param ConnectionInterface $connection
     * @return ClientInterface
     */
    public function setConnection(ConnectionInterface $connection): ClientInterface;

}
