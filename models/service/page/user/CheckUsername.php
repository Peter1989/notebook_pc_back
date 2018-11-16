<?php

class Service_Page_User_CheckUsername{
    private $dsUser = null;

    public function __construct(){
        $this->dsUser = new Service_Data_User_User();
    }

    public function execute($arrInput){
        $username = $arrInput['username'];
        $res = $this->dsUser->checkUsername($username);
        return array('avail' => $res);
    }
}