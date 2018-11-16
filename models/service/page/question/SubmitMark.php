<?php

class Service_Page_Question_SubmitMark{

    public function __construct(){
        $this->daoQuestion = new Dao_Question();
    }

    public function execute($arrInput){
        $uid = $arrInput['uid'];
        $id = $arrInput['id'];
        $mark = $arrInput['mark'];
        $this->daoQuestion->submitMark($uid, $id, $mark);
    }
}
