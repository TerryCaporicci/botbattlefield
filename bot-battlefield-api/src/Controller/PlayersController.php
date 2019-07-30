<?php

namespace Api\Controller;

use Api\Authorization\Authorization;
use Api\Entity\Player;
use Api\Http\Response;
use Api\Repository\PlayerRepository;

final class PlayersController extends Controller
{

    /**
     * @return \Api\Http\Response
     */
    public function showAll(): Response
    {
        $repository = new PlayerRepository();
        $authorization = new Authorization($repository);
        if (!$authorization->authorize($this->response, $this->request)) {
            return $this->response;
        }
        $data = new \stdClass();
        $data->players = $repository->findAll();
        return $this
            ->accessControlResponse()
            ->jsonResponse($data);
    }

    /**
     * @param string $name
     * @return Response
     */
    public function showOneByName(string $name): Response
    {
        $data = new \stdClass();
        try {
            $data->player = (new PlayerRepository())->findOneByName($name);
        } catch (\InvalidArgumentException $e) {
            return $this->response->setStatus(404);
        }
        return $this
            ->accessControlResponse()
            ->jsonResponse($data);
    }

    /**
     * @return Response
     *
     * @throws \Exception see random-bytes
     */
    public function create(): Response
    {
        if (!array_key_exists("name", $this->request->getBody())) {
            return $this->response->setStatus(422);
        }
        if (!preg_match("/^[a-z@-Z\\d\\xC0-\\xFF_-]{3,16}$/u", $this->request->getBody()["name"])) {
            return $this->response->setStatus(412);
        }
        $data = new \stdClass();
        try {
            $data->player = (new PlayerRepository())->persist((new Player())
                ->setName($this->request->getBody()["name"])
                ->setReady(time())
                ->setToken(password_hash(bin2hex(random_bytes(15)), PASSWORD_DEFAULT))
            );
        } catch (\InvalidArgumentException $e) {
            return $this->response->setStatus(409);
        }
        return $this
            ->accessControlResponse()
            ->jsonResponse($data)
            ->setStatus(201);
    }

}
