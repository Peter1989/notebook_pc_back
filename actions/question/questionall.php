<?php

class Action_QuestionAll extends Question_Base_ApiBaseAction{
    public function init(){}

    public function checkParams($arrInput){
        $uid = $arrInput['uid'];

        if(empty($uid)){
            return array('success' => false, 'nologin' => true);
        }
        return array('success' => true);
    }

    public function myExecute($arrInput)
    {
        $questionAll = new Service_Page_Question_QuestionAll();
        $data = $questionAll->execute($arrInput);
        return $data;
    }
}
