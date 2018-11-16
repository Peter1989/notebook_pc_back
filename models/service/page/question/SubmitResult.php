<?php

class Service_Page_Question_SubmitResult{
    private $dsQuestion = null;

    public function __construct(){
        $this->dsQuestion = new Service_Data_Question_Item();
        $this->daoQuestion = new Dao_Question();
    }

    public function execute($arrInput){
        $uid = $arrInput['uid'];
        $id = $arrInput['id'];
        $result = $arrInput['result'];
        $this->daoQuestion->updateTmpResult($uid, $id, $result);
    }
}
