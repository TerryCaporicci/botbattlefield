<?php

namespace Api\Authorization;

use Api\Http\Request;
use Api\Http\Response;

class Authorization
{

    private
        /**
         * @var RepositoryInterface
         */
        $repository;

    /**
     * Authorization constructor.
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Response $response
     * @param Request $request
     * @return bool
     */
    public function authorize(Response $response, Request $request): bool
    {
        if (!array_key_exists("Authorization", $request->getHeaders()->getHeaders())) {
            $response->setStatus(401);
            return false;
        }
        if (2 !== count(($credentials = explode(":", base64_decode(
                ltrim($request->getHeaders()->getHeaders()["Authorization"], "Basic ")
            ))))) {
            $response->setStatus(401);
            return false;
        }
        try {
            $this->repository->findByAuthorization(...$credentials);
        } catch (\InvalidArgumentException $e) {
            $response->setStatus(403);
            return false;
        }
        return true;
    }

}
