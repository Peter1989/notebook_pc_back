<?php

class Service_Page_Tag_GetTags{
    private $dsTag = null;

    public function __construct(){
        $this->dsTag = new Service_Data_Tag_Item();
    }

    public function execute($arrInput){
        $uid = $arrInput['uid'];
        $level = $arrInput['level'];
        $res = $this->dsTag->getTags($uid, $level);
        return $res;
    }
}