<?php

class Service_Page_User_Login{
    private $dsUser = null;
    private $daoUser = null;

    public function __construct(){
        $this->dsUser = new Service_Data_User_User();
        $this->daoUser = new Dao_User();
    }

    public function execute($arrInput){
        $account = $arrInput['account'];
        $password = $arrInput['password'];

        $res = $this->dsUser->fetchPassWordByAccount($account);

        if($res == false){
            return array('success' => false, 'noaccount' => true);
        }

        $passwordori = $res['password'];


        if(md5($password) != $passwordori){
            return array('success' => false, 'passwrong' => true);
        }

        $uid = $res['uid'];
        $logArr = array('ef' => $uid);
        $logStr = json_encode($logArr);
        $logCookie = base64_encode($logStr);
        setcookie("token",$logCookie,time() + 30 * 24 * 86400,'/');
        return array('success' => true);
    }
}