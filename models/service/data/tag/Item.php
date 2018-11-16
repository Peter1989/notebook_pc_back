<?php

class Service_Data_Tag_Item{
    private $daoTag;
    private $daoQuestion;

    public function __construct(){
        $this->daoTag = new Dao_Tag();
        $this->daoQuestion = new Dao_Question();
    }

    public function addTag($uid, $tagName, $level, $uplevelid){
        $res = false;
        if($level === 'one'){
            //todo check if have this tagname, 限制数量
            $res = $this->daoTag->ifHasTagOne($uid, $tagName);
            if($res['num'] >= 1){
                return false;
            }
            $res = $this->daoTag->addTagOne($uid, $tagName);
        }elseif($level === 'two'){
            //todo check if have this tagname,限制数量
            $res = $this->daoTag->ifHasTagTwo($uid, $tagName, $uplevelid);
            if($res['num'] >= 1){
                return false;
            }
            $res = $this->daoTag->addTagTwo($uid, $tagName, $uplevelid);
        }elseif($level === 'three'){
            //todo check if have this tagname,限制数量
            $res = $this->daoTag->ifHasTagThree($uid, $tagName, $uplevelid);
            if($res['num'] >= 1){
                return false;
            }
            $res = $this->daoTag->addTagThree($uid, $tagName, $uplevelid);
        }
        return $res;
    }


    public function editTag($uid, $id, $tagName, $level, $uplevelid){
        if($level === 'one'){
            $res = $this->daoTag->editTagOne($uid, $id, $tagName);
        }elseif($level === 'two'){
            $res = $this->daoTag->editTagTwo($uid, $id, $tagName, $uplevelid);
        }elseif($level === 'three'){
            $res = $this->daoTag->editTagTwo($uid, $id, $tagName, $uplevelid);
        }

        return $res;
    }

    public function getTags($uid, $level){
        $tags = [];
        $tagsOne = $this->daoTag->getTagsOne($uid);
        $tags['tagsOne'] = $tagsOne;
        if($level === 'two'){
            $tagsTwo = $this->daoTag->getTagsTwo($uid);
            $tags['tagsTwo'] = $tagsTwo;
        }elseif($level === 'all'){
            $tagsTwo = $this->daoTag->getTagsTwo($uid);
            $tags['tagsTwo'] = $tagsTwo;
            $tagsThree = $this->daoTag->getTagsThree($uid);
            $tags['tagsThree'] = $tagsThree;
        }
        return $tags;
    }

    public function deleteTag($uid, $id, $level){
        if($level === 'three') {
            $restag = $this->daoTag->deleteTag($id, $uid);
            $resquestion = $this->daoQuestion->deleteQuestionTag($id, $uid);
            return $restag && $resquestion;
        }elseif($level === 'two'){
            $tagThreeArr = $this->daoTag->getTagsByUplevelid($uid, $id);
            $restag = $this->daoTag->deleteTag($id, $uid);
            $this->daoTag->deleteTagByUplevelid($id, $uid);
            foreach($tagThreeArr as $index => $value){
                $tagThreeId = $value['id'];
                $this->daoQuestion->deleteQuestionTag($tagThreeId, $uid);
            }
            return $restag;
        }elseif($level === 'one'){
            $tagTwoArr = $this->daoTag->getTagsByUplevelid($uid, $id);
            foreach($tagTwoArr as $index => $value){
                $tagTwoId = $value['id'];
                $tagThreeArr = $this->daoTag->getTagsByUplevelid($uid, $tagTwoId);
                foreach($tagThreeArr as $index => $value){
                    $tagThreeId = $value['id'];
                    $this->daoQuestion->deleteQuestionTag($tagThreeId, $uid);
                }
                $this->daoTag->deleteTag($tagTwoId, $uid);
                $this->daoTag->deleteTagByUplevelid($tagTwoId, $uid);
            }
            $restag = $this->daoTag->deleteTag($id, $uid);
            return $restag;
        }

    }
}