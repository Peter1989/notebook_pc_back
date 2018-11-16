<?php

class Dao_User{

    private $table = 'user';
    
    public $mysql;
    public $redis;

    public function __construct(){
        $this->mysql = mysql::get_instance();
        $this->redis = RedisLib::get_instance();
    }

    public function signup($username, $password, $phone){
        $time = time();
        $this->mysql->query("set names 'utf8mb4'");
        $res = $this->mysql->query("INSERT INTO {$this->table} (username, password, createtime, lastlogin, phone) VALUES (\"$username\", \"$password\", $time, $time, \"$phone\")");
        if($res == false){
            return false;
        }
        $uid = $this->mysql->query("SELECT LAST_INSERT_ID()");
        $uid = mysqli_fetch_array($uid, MYSQLI_ASSOC);
        return $uid['LAST_INSERT_ID()'];
    }

    public function isUsernameAvail($username){
        $this->mysql->query("set names 'utf8mb4'");
        $res = $this->mysql->query("SELECT COUNT(1) as num FROM {$this->table} WHERE `username` = \"$username\"");
        $num = mysqli_fetch_array($res, MYSQLI_ASSOC)['num'];
        if($num > 0){
            return false;
        }else{
            return true;
        }
    }

    //用于在发送验证码的时候检查是否过频
    public function codesend($phone){
        $key = sprintf(Question_CacheConf::$UserSignUpCodeFrequency, $phone);
        $code = $this->redis->get($key);
        return $code;
    }

    public function codestored($phone){
        $key = sprintf(Question_CacheConf::$UserSignUpCode, $phone);
        $code = $this->redis->get($key);
        return $code;
    }

    public function storeCode($phone, $code){
        $key = sprintf(Question_CacheConf::$UserSignUpCode, $phone);
        $this->redis->set($key, $code);
        $resCode = $this->redis->expire($key , 10*60);

        $key = sprintf(Question_CacheConf::$UserSignUpCodeFrequency, $phone);
        $this->redis->set($key, $code);
        $resFrequency = $this->redis->expire($key, 60);

        if($resCode && $resFrequency){
            return true;
        }
    }

    public function deleteCode($phone){
        $key = sprintf(Question_CacheConf::$UserSignUpCode, $phone);
        $this->redis->del($key);

        $key = sprintf(Question_CacheConf::$UserSignUpCodeFrequency, $phone);
        $this->redis->del($key);
    }

    public function fetchPassByPhone($phone){
        $this->mysql->query("set names 'utf8mb4'");
        $res = is_numeric($phone);

        if($res == false){
            return false;
        }

        $res = $this->mysql->query("SELECT password, id as uid FROM {$this->table} WHERE phone = $phone");
        $res = mysqli_fetch_array($res, MYSQLI_ASSOC);

        if(is_null($res)){
            return false;
        }else{
            return $res;
        }
    }

    public function fetchPassByUsername($username){
        $this->mysql->query("set names 'utf8mb4'");
        $res = $this->mysql->query("SELECT password, id as uid FROM {$this->table} WHERE `username` = \"$username\"");
        $res = mysqli_fetch_array($res, MYSQLI_ASSOC);

        if(is_null($res)){
            return false;
        }else{
            return $res;
        }
    }

    public function fetchUids(){
        $this->mysql->query("set names 'utf8mb4'");
        $res = $this->mysql->query("SELECT id FROM {$this->table}");
        $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $res;
    }

    public function fetchNameById($uid){
        $this->mysql->query("set name 'utf8mb4'");
        $res = $this->mysql->query("SELECT username FROM {$this->table} WHERE id = $uid");
        $res = mysqli_fetch_assoc($res);
        return $res['username'];
    }
}
