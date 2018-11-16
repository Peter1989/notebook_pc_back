<?php

class Action_SendCode extends Question_Base_ApiBaseAction{
    public function init(){

    }

    public function checkParams($arrInput){

    }

    public function myExecute($arrInput){
        $sendcode = new Service_Page_User_SendCode();
        $data = $sendcode->execute($arrInput);
        return $data;
    }
}