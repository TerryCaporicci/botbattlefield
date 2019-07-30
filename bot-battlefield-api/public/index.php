<?php

use Api\Http\Request;
use Api\Controller\ErrorController;

require __DIR__ . "/../vendor/autoload.php";

$request = new Request();

try {
    foreach (json_decode(file_get_contents(__DIR__ . "/../config/routes.json")) as $value) {
        if (!preg_match(
            "/^" . str_replace("/", "\/", $value->path) . "$/u",
            $request->getUri(),
            $match
        )) {
            continue;
        }
        if (!in_array($request->getMethod(), $value->methods)) {
            continue;
        }
        array_shift($match);
        $action = explode("::", $value->action);
        $response = (new $action[0]($request))->{$action[1]}(... $match);
        throw new LogicException();
    }
    throw new OutOfRangeException();
} catch (OutOfRangeException $e) {
    $response = (new ErrorController($request))->notFound($e);
} catch (BadMethodCallException $e) {
    $response = (new ErrorController($request))->methodNotAllowed($e);
} catch (LogicException $e) {
} catch (Throwable $e) {
    $response = (new ErrorController($request))->show($e);
}

header($response->getVersionStatus());
foreach ($response->getHeaders()->getHeaders() as $key => $value) {
    header($key . ": " . $value);
}
echo $response;
