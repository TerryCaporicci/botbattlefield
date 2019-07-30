<?php

namespace Api\Controller\Traits;

use Api\Http\Response;

trait JsonResponseTrait
{

    /**
     * @param \stdClass $data
     * @return Response
     */
    protected final function jsonResponse (\stdClass $data): Response
    {
        return $this->response
            ->addHeader("Content-Type", "application/json")
            ->setBody(json_encode($data));
    }

}
