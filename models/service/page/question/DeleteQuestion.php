<?php

class Service_Page_Question_DeleteQuestion{
    private $dsQuestion = null;
    public function __construct(){
       $this->dsQuestion = new Service_Data_Question_Item(); 
    }

    public function execute($arrInput){
        $qid = $arrInput['qid'];
        $data = array(
                'qid' => $qid,
                );
        $this->dsQuestion->deleteQuestion($data);
    }
}
