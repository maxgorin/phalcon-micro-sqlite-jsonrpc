<?php

namespace Site\Services;


use Datto\JsonRpc\Http\Client;

class UsersClient extends Client {

    public function __construct(array $headers = null, array $options = null) {

        parent::__construct('http://php_users:8010', $headers, $options);

    }

    public function authorization($login, $password, &$result) {

        $this->query('authorization', ['login' => $login, 'password' => $password], $result);

    }

}