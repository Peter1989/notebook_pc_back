<?php

class Action_GetTags extends Question_Base_ApiBaseAction{
    public function init(){

    }

    public function checkParams($arrInput){
        $uid = $arrInput['uid'];
        if(empty($uid)){
            return array('success' => false, 'nologin' => true);
        }
        return array('success' => true);
    }

    public function myExecute($arrInput){

        $addTag = new Service_Page_Tag_GetTags();
        $data = $addTag->execute($arrInput);
        return $data;
    }
}