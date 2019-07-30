<?php

namespace App\Controller;

use App\Entity\Client;
use App\Socket\ClientInterface;
use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use App\Socket\SocketController;
use App\Controller\Ratchetable\OpponentController;
use App\Controller\Ratchetable\PlayerController;
use App\Controller\Ratchetable\RatchetableInterface;

/**
 * Class FrontController
 * @package App\Controller
 */
final class FrontController extends SocketController
{

    private
        /**
         * @var array
         */
        $controllers;

    /**
     * FrontController constructor.
     * @param LoggerInterface $logger
     * @param PlayerController $playerController
     * @param OpponentController $opponentController
     */
    public function __construct(
        LoggerInterface $logger,
        PlayerController $playerController,
        OpponentController $opponentController
    )
    {
        parent::__construct($logger);
        $this->controllers = [];
        $this
            ->addController(OpponentController::class, $opponentController)
            ->addController(PlayerController::class, $playerController);
    }

    /**
     * @return ClientInterface
     */
    protected function createClient(): ClientInterface
    {
        return new Client();
    }

    /**
     * @param string $key
     * @param RatchetableInterface $controller
     * @return $this
     */
    public function addController(string $key, RatchetableInterface $controller): self
    {
        $this->controllers[$key] = $controller;
        return $this;
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     *
     * @throws \Exception
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        try {
            if (($object = json_decode($msg)) && JSON_ERROR_NONE !== json_last_error()) {
                throw new \Exception("Invalid JSON: " . $msg);
            }
            if (property_exists($object, "playerOne")
                && property_exists($object, "playerTwo")) {
                $this->controllers[OpponentController::class]->message($this->getClients(), $from, $object);
                return;
            }
            if (property_exists($object, "id")
                && property_exists($object, "name")
                && property_exists($object, "token")) {
                $this->controllers[PlayerController::class]->message($this->getClients(), $from, $object);
                return;
            }
            throw new \Exception("Controller Not Found: " . $msg);
        } catch (\Throwable $e) {
            $this->onError($from, new \Exception((string)$e));
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        parent::onClose($conn);
        foreach ($this->controllers as $controller) {
            $controller->close($this->getClients(), $conn);
        }
    }

}
