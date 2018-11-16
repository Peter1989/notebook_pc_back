<?php

class Action_SubmitMark extends Question_Base_ApiBaseAction{
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
		$submitMark = new Service_Page_Question_SubmitMark();
        $data = $submitMark->execute($arrInput);
        return $data;
	}
}
