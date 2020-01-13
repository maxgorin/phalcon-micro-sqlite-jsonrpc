<?php

namespace Users\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Users extends Model {

    public function initialize() {
        $this->addBehavior(new Timestampable([
            'beforeValidationOnCreate' => [
                'field'  => 'created_at',
                'format' => 'Y-m-d H:i:s',
            ],
            'beforeValidationOnUpdate' => [
                'field'  => 'updated_at',
                'format' => 'Y-m-d H:i:s',
            ]
        ]));
    }

    public $id;

    public $login;

    public $password;

    public $created_at;

    public $updated_at;


}