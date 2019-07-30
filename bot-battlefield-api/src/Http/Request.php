<?php

namespace Api\Http;

class Request
{

    private
        /**
         * @var string
         */
        $uri,
        /**
         * @var string
         */
        $method,
        /**
         * @var HeaderBag
         */
        $headers,
        /**
         * @var string
         */
        $body;


    public function __construct()
    {
        $this
            ->setUri((string)filter_input(INPUT_SERVER, "PATH_INFO"))
            ->setBody((array)filter_input_array(INPUT_GET) + (array)filter_input_array(INPUT_POST))
            ->setMethod((string)filter_input(INPUT_SERVER, "REQUEST_METHOD"))
            ->setHeaders(new RequestHeaderBag());
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
     * @return Request
     */
    public function setHeaders(HeaderBag $headers)
    {
        $this->headers = $headers;
        return $this;
    }


    /**
     * @param string $method
     * @return Request
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     * @return Request
     */
    public function setBody(array $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return Request
     */
    public function setUri(string $uri): self
    {
        if (!$uri) {
            $uri = "/";
        }
        $this->uri = $uri;
        return $this;
    }

}
