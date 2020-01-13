<?php

namespace Users\Application;


class JsonRpcRequest {

    protected $method;

    protected $params;

    public function __construct($method, $params) {

        $this->method = $method;
        $this->params = $params;

    }

    /**
     * @return array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

}