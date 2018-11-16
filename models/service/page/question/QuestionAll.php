<?php

class Service_Page_Question_QuestionAll{
    private $dsQuestion = null;

    public function __construct(){
        $this->dsQuestion = new Service_data_Question_Item();
    }

    public function execute($arrInput){
        $uid = $arrInput['uid'];
        $page = $arrInput['page'];
        $size = $arrInput['size'];
        $tag = isset($arrInput['tag']) ? $arrInput['tag'] : 'all';
        $marked = $arrInput['marked'] == 'true' ? $arrInput['marked'] : 'false';
        $questionList = $this->dsQuestion->questionAll($uid, $page, $size, $tag, $marked);
        $questionAmount = $this->dsQuestion->questionAmount($uid, $tag);
        $res = array(
            'list' => $questionList,
            'amount' => $questionAmount,
        );
        return $res;
    }
}
