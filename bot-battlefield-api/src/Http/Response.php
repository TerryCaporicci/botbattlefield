<?php

namespace Api\Http;

class Response
{

    private
        /**
         * @var float
         */
        $version,
        /**
         * @var int
         */
        $statusCode,
        /**
         * @var string
         */
        $statusText,
        /**
         * @var HeaderBag
         */
        $headers,
        /**
         * @var string
         */
        $body,

        /**
         * @var array
         */
        $status = [
        200 => "OK",
        201 => "Created",
        400 => "Bad Request",
        401 => "Unauthorized",
        403 => "Forbidden",
        404 => "Not Found",
        405 => "Method Not Allowed",
        406 => "Not Acceptable",
        409 => "Conflict",
        412 => "Precondition Failed",
        422 => "Unprocessable entity",
        500 => "Internal Server Error ",
    ];

    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this
            ->setVersion(1.1)
            ->setStatusCode(200)
            ->setStatusText("OK")
            ->setHeaders(new HeaderBag())
            ->setBody("");
    }

    /**
     * @return float
     */
    public function getVersion(): float
    {
        return $this->version;
    }

    /**
     * @param float $version
     * @return Response
     */
    public function setVersion(float $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return Response
     */
    public function setStatus(int $statusCode): self
    {
        if (array_key_exists($statusCode, $this->status)) {
            $this->setStatusCode($statusCode);
            $this->setStatusText($this->status[$statusCode]);
        }
        return $this;
    }

    /**
     * @param int $statusCode
     * @return Response
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusText(): string
    {
        return $this->statusText;
    }

    /**
     * @param string $statusText
     * @return Response
     */
    public function setStatusText(string $statusText): self
    {
        $this->statusText = $statusText;
        return $this;
    }

    /**
     * @return HeaderBag
     */
    public function getHeaders(): HeaderBag
    {
        return $this->headers;
    }

    /**
     * @param HeaderBag $headers
     * @return Response
     */
    public function setHeaders(HeaderBag $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return Response
     */
    public function addHeader(string $key, string $value): self
    {
        $this->headers->addHeader($key, $value);
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Response
     */
    public function setBody(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersionStatus(): string
    {
        return "HTTP/"
            . $this->getVersion() . " "
            . $this->getStatusCode() . " "
            . $this->getStatusText();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getBody();
    }

}
