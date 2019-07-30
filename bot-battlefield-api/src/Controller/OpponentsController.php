<?php

namespace Api\Controller;

use Api\Entity\Opponent;
use Api\Entity\Player;
use Api\Http\Response;

final class OpponentsController extends Controller
{

    /**
     * @return \Api\Http\Response
     */
    public function create(): Response
    {
        $data = new \stdClass();
        return $this
            ->accessControlResponse()
            ->jsonResponse($data);
    }

}
