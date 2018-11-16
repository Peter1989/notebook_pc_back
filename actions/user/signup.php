<?php

class Action_SignUp extends Question_Base_ApiBaseAction{
    public function init(){

    }

    public function checkParams($arrInput){

    }

    public function myExecute($arrInput){
        $signup = new Service_Page_User_SignUp();
        $data = $signup->execute($arrInput);
        return $data;
    }
}