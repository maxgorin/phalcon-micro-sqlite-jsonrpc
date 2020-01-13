<?php

namespace Site\Controllers;


use Datto\JsonRpc\Http\Exceptions\HttpException;
use Phalcon\Mvc\Controller;
use Site\Forms\LoginForm;
use Site\Services\UsersClient;

class UsersController extends Controller {

    public function authorization() {

        $form = new LoginForm();

        $success = null;

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost())) {

                $login = $this->request->get('login', ['string', 'trim']);
                $password = $this->request->get('password', ['string', 'trim']);

                $client = new UsersClient();

                $client->authorization($login, $password, $success);

                try {

                    $client->send();

                } catch (HttpException $e) {

                    // TODO: LOG

                    $success = false;

                } catch (\ErrorException $e) {

                    // TODO: LOG

                    $success = false;

                }
            }
        }

        return $this->view->render('index', [
            'form' => $form,
            'success' => $success
        ]);

    }

}