<?php

class Action_SubmitResult extends Question_Base_ApiBaseAction{
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
		$submitResult = new Service_Page_Question_SubmitResult();
        $data = $submitResult->execute($arrInput);
        return $data;
	}
}
