<?php

namespace Api\Controller;

use Api\Controller\Traits\AccessControlResponseTrait;
use Api\Controller\Traits\JsonResponseTrait;
use Api\Http\Request;
use Api\Http\Response;

abstract class Controller
{

    use JsonResponseTrait;
    use AccessControlResponseTrait;

    protected
        /**
         * @var Response
         */
        $response,
        /**
         * @var Request
         */
        $request;

    /**
     * Controller constructor.
     * @param Request $request
     */
    public final function __construct(Request $request)
    {
        $this->request = $request;
        $this->response = new Response();
    }

}
