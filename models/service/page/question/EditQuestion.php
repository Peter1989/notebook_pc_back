<?php

class Service_Page_Question_EditQuestion{
    private $dsQuestion = null;

    public function __construct(){
        $this->dsQuestion = new Service_Data_Question_Item();
    }

    public function execute($arrInput){
        $qid = $arrInput['qid'];
        $question = $arrInput['question'];
        $isprivate = $arrInput['isprivate'];
        $answer = $arrInput['answer'];
        $tag = $arrInput['tag'];
        $data = array(
                'isprivate' => $isprivate,
                'question' => $question,
                'answer' => $answer,
                'qid' => $qid,
                'tag' => $tag,
                );
        $this->dsQuestion->editQuestion($data);
    }
}
