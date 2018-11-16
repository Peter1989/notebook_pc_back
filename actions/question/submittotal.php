<?php

class Action_SubmitTotal extends Question_Base_ApiBaseAction{
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
		$submitTotal = new Service_Page_Question_SubmitTotal();
        $data = $submitTotal->execute($arrInput);
        return $data;
	}
}
