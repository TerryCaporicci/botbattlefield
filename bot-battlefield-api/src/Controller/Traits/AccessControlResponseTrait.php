<?php

namespace Api\Controller\Traits;

trait AccessControlResponseTrait
{

    /**
     * @return Response
     */
    protected final function accessControlResponse(): self
    {
        $this->response
            ->addHeader("Access-Control-Allow-Origin", "*")
            ->addHeader("Access-Control-Allow-Headers", "Authorization, Content-Type")
            ->addHeader("Access-Control-Allow-Methods", "GET, POST");
        return $this;
    }

}
