<?php

class Action_Checkuser extends Question_Base_ApiBaseAction{
    public function init(){

    }

    public function checkParams($arrInput){
    }

    public function myExecute($arrInput){
        $checkusername = new Service_Page_User_CheckUsername();
        $data = $checkusername->execute($arrInput);
        return $data;
    }
}