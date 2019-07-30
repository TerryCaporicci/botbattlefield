<?php

namespace Api\Http;

class HeaderBag
{

    protected
        /**
         * @var array
         */
        $headers;

    /**
     * HeaderBag constructor.
     */
    public function __construct()
    {
        $this->headers = [];
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return HeaderBag
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return HeaderBag
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
        return $this;
    }

}
