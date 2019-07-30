<?php

namespace Api\Controller;

use Api\Http\Response;

final class AccessControlController extends Controller
{

    /**
     * @return Response
     */
    public function accessControl(): Response
    {
        return $this->accessControlResponse()->response;
    }

}
