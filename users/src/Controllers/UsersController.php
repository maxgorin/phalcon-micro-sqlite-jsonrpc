<?php

namespace Users\Controllers;


use Phalcon\Filter;
use Phalcon\Mvc\Controller;
use Phalcon\Security;
use Users\Models\Users;

class UsersController extends Controller {

    /**
     * @throws \Datto\JsonRpc\Exceptions\ArgumentException
     */
    public function authorization(): bool {

        $params = $this->application->getRequest()->getParams();

        if (!isset($params['login'], $params['password'])) {
            throw new \Datto\JsonRpc\Exceptions\ArgumentException();
        }

        $login = (new Filter)->sanitize($params['login'], ['string', 'trim']);
        $password = (new Filter)->sanitize($params['password'], ['string', 'trim']);

        /**
         * @var Users $user
         */
        $user = Users::findFirstByLogin($login);

        if ($user) {
            if ((new Security())->checkHash($password, $user->password)) {
                return true;
            }
        }

        return false;
    }

}