<?php

class Action_Login extends Question_Base_ApiBaseAction{
    public function init(){

    }

    public function checkParams($arrInput){

    }

    public function myExecute($arrInput){
        $login = new Service_Page_User_Login();
        $data = $login->execute($arrInput);
        return $data;
    }
}