<?php

class Service_Data_User_User{

    private $daoUser;

    public function __construct(){
        $this->daoUser= new Dao_User();
    }

    public function signup($username, $password, $phone){
        $password = md5($password);
        $res = $this->daoUser->signup($username, $password, $phone);
        return $res;
    }

    public function setCookieUid($uid){
        setcookie("uid", $uid, time()+3600*24*30);
    }

    public function checkUsername($username){
        $res = $this->daoUser->isUsernameAvail($username);
        return $res;
    }

    public function hasSend($phone){
        $res = $this->daoUser->codeSend($phone);
        if($res == false){
            return false;
        }else{
            return true;
        }
    }

    public function storeCode($phone, $code){
        $res = $this->daoUser->storeCode($phone, $code);
        return $res;
    }

    public function checkCode($phone, $code){
        $res = $this->daoUser->codestored($phone);
        if($res == false){
            return array('success' => false, 'overtime' => true);
        }

        if($res === $code){
            return array('checkcode' => true);
        }else{
            return array('success' => false, 'codewrong' => true);
        }
    }

    public function fetchPassWordByAccount($account){

        $res = $this->daoUser->fetchPassByPhone($account);
        if($res != false){
            return $res;
        }

        $res = $this->daoUser->fetchPassByUsername($account);
        if($res != false){
            return $res;
        }

        return false;
    }
}
