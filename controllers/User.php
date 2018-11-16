<?php

class Controller_User extends Yaf_Controller_Abstract {
    public $actions = [
        'signup' => 'actions/user/signup.php',
        'checkuser' => 'actions/user/checkuser.php',
        'sendcode' => 'actions/user/sendcode.php',
        'login' => 'actions/user/login.php',
    ];
}