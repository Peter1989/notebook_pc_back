<?php

class Service_Page_User_SignUp{
    private $dsUser = null;
    private $daoUser = null;

    public function __construct(){
        $this->dsUser = new Service_Data_User_User();
        $this->daoUser = new Dao_User();
    }

    public function execute($arrInput){
        $username = $arrInput['username'];
        $password = $arrInput['password'];
        $phone = $arrInput['phone'];
        $code = $arrInput['code'];

        $res = $this->dsUser->checkCode($phone, $code);
        if(isset($res['success']) && $res['success'] === false){
            return $res;
        }

        $res = $this->dsUser->signup($username, $password, $phone);
        if($res == false){
            return array('success' => false, 'datarepeat' => true);
        }else{
            $logArr = array('ef' => $res);
            $logStr = json_encode($logArr);
            $logCookie = base64_encode($logStr);
            setcookie("token",$logCookie,time() + 30 * 24 * 86400,'/');

            $this->daoUser->deleteCode($phone);
            return array('success' => true);
        }
    }
}