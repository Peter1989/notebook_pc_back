<?php

class Action_AddQuestion extends Question_Base_ApiBaseAction{
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
		$addQuestion = new Service_Page_Question_AddQuestion();
        $data = $addQuestion->execute($arrInput);
        return $data;
	}
}
