<?php

class Service_Page_Question_GroundAll{
    private $dsQuestion = null;

    public function __construct(){
        $this->dsQuestion = new Service_data_Question_Item();
    }

    public function execute($arrInput){
        $page = $arrInput['page'];
        $size = $arrInput['size'];
        $questionList = $this->dsQuestion->groundAll($page, $size);
        $questionAmount = $this->dsQuestion->groundAmount();
        $res = array(
            'list' => $questionList,
            'amount' => $questionAmount,
        );
        return $res;
    }
}