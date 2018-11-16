<?php

class Service_Page_Question_QuestionList{
    private $dsQuestion = null;

    public function __construct(){
        $this->dsQuestion = new Service_Data_Question_Item(); 
    }

    public function execute($arrInput){
        $uid = $arrInput['uid'];
        $page = $arrInput['page'];
        $size = $arrInput['size'];
        $questionList = $this->dsQuestion->questionList($uid, $page, $size);
        $cacheAmount = $this->dsQuestion->questionRememberAmount($uid);
        $res = array(
            'list' => $questionList,
            'amount' => $cacheAmount,
        );
        return $res;
    }
}
