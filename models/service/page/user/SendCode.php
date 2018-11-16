<?php

class Service_Page_User_SendCode{
    private $dsUser = null;

    public function __construct(){
        $this->dsUser = new Service_Data_User_User();
    }

    public function execute($arrInput){
        $phone = $arrInput['phone'];

        $res = preg_match('/^1[34578]\d{9}$/', $phone);
        if($res === 0){
            return array('success' => false, 'phonepatten' => true);
        }

        $hasSend = $this->dsUser->hasSend($phone);
        if($hasSend == true){
            return array('success' => false, 'overFrequency' => true);
        }

        $AppKey = '295e015006123d9f15f4446a2bc16906';
        //网易云信分配的账号，请替换你在管理后台应用下申请的appSecret
        $AppSecret = 'f0fc6e20863e';
        $p = new Question_SMS($AppKey,$AppSecret, 'curl');
        $res = $p->sendSmsCode('3129206', $phone,'','6');

        if($res['code'] == 200){
            $code = $res['obj'];
        }elseif($res['code'] == 416){
            return array('success' => false, 'overtimes' => true);
        }else{
            return array('success' => false, 'serverError' => true);
        }

        $sendCode = $this->dsUser->storeCode($phone, $code);
        if($sendCode == true){
            return array('success' => true);
        }
    }
}