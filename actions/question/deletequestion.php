<?php

class Action_DeleteQuestion extends Question_Base_ApiBaseAction{
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
		$deletequestion = new Service_Page_Question_DeleteQuestion();
        $data = $deletequestion->execute($arrInput);
        return $data;
	}
}
