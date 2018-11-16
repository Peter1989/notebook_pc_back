<?php

abstract class Question_Base_ApiBaseAction extends Yaf_Action_Abstract{
    protected $startTime = 0;
    protected $endTime = 0;
    public $request;
    protected $validater = null;

    public function init(){}

    public function checkParams($arrInput){}

    public abstract function myExecute($arrInput);

    public function execute(){
        $arrParams = file_get_contents("php://input");
        $inputData = json_decode($arrParams, true);

        if(empty($inputData)){
            $inputData = $_REQUEST;
        }

        $token = $_COOKIE['token'];
        $token = base64_decode($token);
        $token = json_decode($token, true);

        if(empty($token)) {
            $inputData['uid'] = '';
        }else{
            $inputData['uid'] = $token['ef'];
        }

        $checkParams = $this->checkParams($inputData);

        if($checkParams['success'] === false){
            echo json_encode($checkParams);
            return;
        }

        $data = $this->myExecute($inputData);
        echo json_encode($data);

    }
}
