<?php

class Action_QuestionList extends Question_Base_ApiBaseAction{
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
		$questionList = new Service_Page_Question_QuestionList();
        $data = $questionList->execute($arrInput);
        return $data;
	}
}
