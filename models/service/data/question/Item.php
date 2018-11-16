<?php

class Service_Data_Question_Item{

    private $daoQuestion;
    private $daoUser;
    private $daoTag;

    public function __construct(){
        $this->daoQuestion = new Dao_Question();
        $this->daoUser = new Dao_User();
        $this->daoTag = new Dao_Tag();
    }

    public function addQuestion($data){
        $isprivate = $data['isprivate'];
        $question_text = $data['question'];
        $answer_text = $data['answer'];
        $uid = $data['uid'];
        $tag_code = $data['tag'];
        $this->daoQuestion->addQuestion($question_text, $answer_text, $isprivate, $uid, $tag_code);
    }

    public function editQuestion($data){
        $isprivate = $data['isprivate'];
        $question_text = $data['question'];
        $answer_text = $data['answer'];
        $qid = $data['qid'];
        $tag = $data['tag'];
        $res = $this->daoQuestion->editQuestion($question_text, $answer_text, $isprivate, $qid, $tag);
        return $res;
    }

    public function deleteQuestion($data){
        $qid = $data['qid'];
        $this->daoQuestion->deleteQuestion($qid);
    }

    public function questionList($uid, $page, $size){
        $questionList = $this->daoQuestion->questionList($uid, $page, $size);
        $tmpResult = $this->daoQuestion->getTmpResult($uid);

        foreach($questionList as $index => $value){
            $qid = $value['id'];
            if(isset($tmpResult[$qid])){
                $tmp = $tmpResult[$qid];
                $questionList[$index]['result'] = $tmp;
            }else {
                $questionList[$index]['result'] = '2';
            }

            $tagname = $this->daoTag->fetchNameById($value['tag']);
            $questionList[$index]['tag'] = $tagname;
        }
        return $questionList;
    }

    public function questionRememberAmount($uid){
        $questionAmount = $this->daoQuestion->questionRememberAmount($uid);
        return $questionAmount;
    }

    //crontab脚本所用方法，由于是静态方法，所以不能用到实例化语法。

    public static function insertQuestions(){
        $daoQuestion = new Dao_Question();
        $daoUser = new Dao_User();

        $uidArr = $daoUser->fetchUids();
        foreach($uidArr as $key => $value) {
            $uid = $value['id'];
            $qids = $daoQuestion->getQuesToRemind($uid);
            foreach ($qids as $uid => $qid) {
                $daoQuestion->setToRememberNoRestart($qid);
            }
        }
    }

    public function questionAll($uid, $page, $size, $tag, $marked){
        $questionAll = $this->daoQuestion->questionAll($uid, $page, $size, $tag, $marked);

        foreach($questionAll as $index => $value){

            $tagname = $this->daoTag->fetchNameById($value['tag']);
            $questionAll[$index]['tag'] = $tagname;
        }

        return $questionAll;
    }

    public function questionAmount($uid, $tag){
        $questionAmount = $this->daoQuestion->questionAmount($uid, $tag);
        return $questionAmount;
    }

    public function groundAll($page, $size){
        $groundquestions = $this->daoQuestion->groundAll($page, $size);
        foreach($groundquestions as $index => $value){
            $name = $this->daoUser->fetchNameById($value['uid']);
            $groundquestions[$index]['username'] = $name;
            unset($groundquestions[$index]['uid']);

            $tag = Question_Const::TAG_MAP[$value['tag']];
            $groundquestions[$index]['tag_code'] = $value['tag'];
            $groundquestions[$index]['tag'] = $tag;
        }
        return $groundquestions;
    }

    public function groundAmount(){
        $groundAmount = $this->daoQuestion->groundAmount();
        return $groundAmount;
    }

    public function restartQuestion($qid){
        $this->daoQuestion->restartQuestion($qid);
        $this->daoQuestion->unSetFromRemember($qid);
    }

    public function updateQuesList($uid){
        $resultArr = $this->daoQuestion->getTmpResult($uid);
        foreach($resultArr as $qid => $result){
            if($result == '1'){
                $this->daoQuestion->unSetFromRemember($qid);
            }else{
                $this->daoQuestion->setToRestart($qid);
            }
        }
        $this->daoQuestion->delTmpResult($uid);
    }
}
