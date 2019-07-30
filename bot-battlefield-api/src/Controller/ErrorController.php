<?php

namespace Api\Controller;

use Api\Http\Response;

final class ErrorController extends Controller
{

    /**
     * @param \Throwable $e
     * @return Response
     */
    public function show(\Throwable $e): Response
    {
        $data = new \stdClass();
        $data->error = utf8_encode($e->getMessage());
        return $this
            ->jsonResponse($data)
            ->setStatus(500);
    }

    /**
     * @param \OutOfRangeException $e
     * @return Response
     */
    public function notFound(\OutOfRangeException $e): Response
    {
        $data = new \stdClass();
        $data->error = "Not Found";
        return $this
            ->jsonResponse($data)
            ->setStatus(404);
    }

    /**
     * @param \Throwable $e
     * @return Response
     */
    public function methodNotAllowed(\Throwable $e): Response
    {
        $data = new \stdClass();
        $data->error = "Method Not Allowed";
        return $this
            ->jsonResponse($data)
            ->setStatus(405);
    }

}
