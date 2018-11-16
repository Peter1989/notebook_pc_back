<?php

class Service_Page_Question_AddQuestion{
    private $dsQuestion = null;

    public function __construct(){
        $this->dsQuestion = new Service_Data_Question_Item(); 
    }

    public function execute($arrInput){
        $question = $arrInput['question'];
        $answer = $arrInput['answer'];
        $isprivate = $arrInput['isprivate'];
        $uid = $arrInput['uid'];
        $tag = $arrInput['tag'];
        $data = array(
            'isprivate' => $isprivate,
            'question' => $question,
            'answer' => $answer,
            'uid' => $uid,
            'tag' => $tag,
        );
        $this->dsQuestion->addQuestion($data);
    }
}
