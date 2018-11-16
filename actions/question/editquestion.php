<?php

class Action_EditQuestion extends Question_Base_ApiBaseAction{
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
		$editQuestion = new Service_Page_Question_EditQuestion();
        $data = $editQuestion->execute($arrInput);
        return $data;
	}
}
