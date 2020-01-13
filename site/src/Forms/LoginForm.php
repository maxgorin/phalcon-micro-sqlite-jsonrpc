<?php

namespace Site\Forms;


use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends Form {

    public function initialize() {

        $this->setEntity($this);

        $this->add(new Text('login'));
        $this->add(new Password('password'));
        $this->add(new Hidden('csrf'));

        $validation = new Validation();

        $validation->add('login', new PresenceOf());
        $validation->add('password', new PresenceOf());
        $validation->add('csrf', new PresenceOf());

        $this->setValidation($validation);
    }

    public function getCsrf() {
        return $this->security->getToken();
    }

}