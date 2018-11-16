<?php

class Action_GroundAll extends Question_Base_ApiBaseAction{
    public function init(){}

    public function checkParams($arrInput){
        return array('success' => true);
    }

    public function myExecute($arrInput)
    {
        $groundAll = new Service_Page_Question_GroundAll();
        $data = $groundAll->execute($arrInput);
        return $data;
    }
}