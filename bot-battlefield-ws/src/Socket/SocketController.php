<?php

namespace App\Socket;

use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class SocketController extends AbstractController implements MessageComponentInterface
{

    private
        /**
         * @var array
         */
        $clients,
        /**
         * @var LoggerInterface
         */
        $logger;

    /**
     * @return ClientInterface
     */
    abstract protected function createClient(): ClientInterface;

    /**
     * SocketController constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->clients = [];
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function getClients(): array
    {
        return $this->clients;
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients[] = $this->createClient()->setConnection($conn);
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        foreach ($this->clients as $key => $client) {
            if ($conn === $client->getConnection()) {
                unset($this->clients[$key]);
                return;
            }
        }
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->logger->error((string)$e);
        $conn->close();
    }

}
