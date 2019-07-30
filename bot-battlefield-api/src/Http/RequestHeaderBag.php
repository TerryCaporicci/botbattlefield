<?php

namespace Api\Http;

class RequestHeaderBag extends HeaderBag
{

    /**
     * RequestHeaderBag constructor.
     */
    public function __construct()
    {
        parent::__construct();
        foreach (filter_input_array(INPUT_SERVER) as $key => $value) {
            if ("HTTP_" === substr($key, 0, 5)) {
                $this->addHeader(
                    str_replace(
                        "_",
                        "-",
                        ucwords(strtolower(substr($key, 5)), "_")
                    ),
                    $value
                );
            }
        }
    }

}
