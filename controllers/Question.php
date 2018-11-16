<?php

class Controller_Question extends Yaf_Controller_Abstract {
	public $actions = [
		'addquestion' => 'actions/question/addquestion.php',
        'questionlist' => 'actions/question/questionlist.php',
        'questionall' => 'actions/question/questionall.php',
		'groundall' => 'actions/question/groundall.php',
        'submitresult' => 'actions/question/submitresult.php',
		'submitmark' => 'actions/question/submitmark.php',
        'submittotal' => 'actions/question/submittotal.php',
        'editquestion' => 'actions/question/editquestion.php',
        'deletequestion' => 'actions/question/deletequestion.php',
	];
}
