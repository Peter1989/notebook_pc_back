<?php

class Service_Page_Question_SubmitTotal{
    private $dsQuestion = null;

    public function __construct(){
        $this->dsQuestion = new Service_Data_Question_Item();
        $this->daoQuestion = new Dao_Question();
    }

    public function execute($arrInput){
        $uid = $arrInput['uid'];
        //用tmpcache更新remeberlist
        $this->dsQuestion->updateQuesList($uid);
    }
}
