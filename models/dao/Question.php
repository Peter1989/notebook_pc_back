<?php

class Dao_Question{

    private $table = 'question';
    
    public $mysql;
    public $redis;

    public function __construct(){
        $this->mysql = mysql::get_instance();
        $this->redis = RedisLib::get_instance(); 
    }

    public function addQuestion($question_text, $answer_text, $isprivate, $uid, $tag_code){
        if(empty($question_text) || empty($answer_text)){
            return false;
        }
        $time = time();
        $this->mysql->query("set names 'utf8mb4'");
        $question_text = $this->mysql->real_escape_string($question_text);
        $answer_text = $this->mysql->real_escape_string($answer_text);
        $sql = "INSERT INTO {$this->table} (uid, question_text, answer_text, timestamp,updatetime,  isprivate, tag) VALUES ($uid, \"$question_text\", \"$answer_text\", $time,$time, $isprivate, $tag_code)";
        $this->mysql->query($sql);
    }

    public function editQuestion($question_text, $answer_text, $isprivate, $qid, $tag){
        if(empty($question_text) || empty($answer_text) || empty($qid)){
            return false;
        }
        $question_text = $this->mysql->real_escape_string($question_text);
        $answer_text = $this->mysql->real_escape_string($answer_text);
        $this->mysql->query("set names 'utf8mb4'");
        $sql = "UPDATE {$this->table} SET `question_text` = \"$question_text\" , `answer_text` = \"$answer_text\" , `isprivate` = $isprivate";
        if($tag !== null){
            $sql .= " , `tag` = $tag";
        }
        $sql .= " WHERE id = $qid";
        $res = $this->mysql->query($sql);
        return $res;
    }

    public function deleteQuestion($qid){
        if(empty($qid)){
            return false;
        }
        $this->mysql->query("set names 'utf8mb4'");
        $this->mysql->query("DELETE FROM {$this->table} WHERE id = $qid");
    }

    public function questionList($uid, $page, $size){
        $start = ($page - 1) * $size;
        $this->mysql->query("set character set 'utf8mb4'");
        $res = $this->mysql->query("SELECT id, question_text, answer_text, date, restart_date, has_restart , tag, mark FROM question WHERE uid = $uid AND toremember = 1  ORDER BY timestamp DESC LIMIT $start, $size");

        while($ques = mysqli_fetch_array($res, MYSQLI_ASSOC)){
            $quesListArr[] = $ques;
        }
        return $quesListArr;
    } 

    public function questionRememberAmount($uid){
        $this->mysql->query("set character set 'utf8mb4'");
        $res = $this->mysql->query("SELECT COUNT(1) AS num FROM question WHERE uid = $uid AND toremember = 1");
        $num = mysqli_fetch_array($res, MYSQLI_ASSOC);
        return (int)$num['num'];
    }

    public function getQuesToRemind($uid){
        $qids = array();
        $nowDate = date("Y-m-d");
        $qidsOri = $this->mysql->query("SELECT id FROM question  WHERE uid = $uid AND has_restart = 0 AND TIMESTAMPDIFF(DAY, date, \"$nowDate\") % 2 = 0");
        while($qid = mysqli_fetch_array($qidsOri, MYSQLI_ASSOC)){
            $qids[] = $qid['id'];  
        } 
        $qidsRestart = $this->mysql->query("SELECT id FROM question  WHERE uid = $uid AND has_restart = 1 AND TIMESTAMPDIFF(DAY, restart_date, \"$nowDate\") % 2 = 0");
        while($qid = mysqli_fetch_array($qidsRestart, MYSQLI_ASSOC)){
            $qids[] = $qid['id'];
        }
        return $qids; 
    }

    public function questionAll($uid, $page, $size, $tag, $marked){
        $start = ($page - 1)*$size;
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT id, question_text, answer_text, isprivate , tag , mark FROM question WHERE uid = $uid";

        if($tag != 'all'){
            $sql .= ' AND tag = '.$tag;
        }

        if($marked != 'false'){
            $sql .= ' AND mark = 1';
        }

        $sql .= " ORDER BY timestamp DESC LIMIT $start, $size";
        $questions = $this->mysql->query($sql);
        while($question = mysqli_fetch_array($questions, MYSQLI_ASSOC)){
            $data[] = $question;
        }
        return $data;
    }

    public function groundAll($page, $size){
        $start = ($page - 1)*$size;
        $this->mysql->query("set character set 'utf8mb4'");
        $questions = $this->mysql->query("SELECT id, question_text, answer_text, date, uid, tag FROM question WHERE isprivate = 0 ORDER BY timestamp DESC LIMIT $start, $size");
        while($question = mysqli_fetch_array($questions, MYSQLI_ASSOC)){
            $data[] = $question;
        }
        return $data;
    }

    public function groundAmount(){
        $this->mysql->query("set character set 'utf8mb4'");
        $questionAmount = $this->mysql->query("SELECT COUNT(1) as num FROM question WHERE isprivate = 0");
        $num = mysqli_fetch_array($questionAmount, MYSQLI_ASSOC);
        return (int)$num['num'];
    }

    public function questionAmount($uid, $tag){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT COUNT(1) as num FROM question WHERE uid = $uid";
        if($tag != 'all'){
            $sql .= " AND tag = $tag";
        }
        $questionAmount = $this->mysql->query($sql);
        $num = mysqli_fetch_array($questionAmount, MYSQLI_ASSOC);
        return (int)$num['num'];
    }

    public function setToRestart($qid){
        $nowDate = date("Y-m-d");
        $this->mysql->query("set character set 'utf8mb4'");
        $this->mysql->query("UPDATE {$this->table} SET toremember = 0 , restart_date = \"$nowDate\", has_restart = 1 WHERE id=$qid");
    }

    public function setToRememberNoRestart($qid){
        $this->mysql->query("set character set 'utf8mb4'");
        $this->mysql->query("UPDATE {$this->table} SET toremember = 1 WHERE id=$qid");
    }

    public function unSetFromRemember($qid){
        $this->mysql->query("set character set 'utf8mb4'");
        $this->mysql->query("UPDATE {$this->table} SET toremember = 0 WHERE id=$qid");
    }

    public function restartQuestion($qid){
        $nowDate = date("Y-m-d");
        $res = $this->mysql->query("UPDATE {$this->table} SET restart_date=\"$nowDate\", has_restart=1 WHERE id=$qid");
        $this->unSetFromRemember($qid);
    }

    public function updateTmpResult($uid, $qid, $result){
        $questionTmpResult = sprintf(Question_CacheConf::$QuestionTmpResult, $uid);
        $this->redis->HSET($questionTmpResult, $qid, $result);
        $this->redis->expire($questionTmpResult, 24 * 3600);
    }

    public function submitMark($uid, $qid, $mark){
        $markfield = $mark == true ? 1 : 0;
        $res = $this->mysql->query("UPDATE {$this->table} SET mark=$markfield WHERE id=$qid");
    }

    public function getTmpResult($uid){
        $questionTmpResult = sprintf(Question_CacheConf::$QuestionTmpResult, $uid);
        $tmpResults = $this->redis->HGETALL($questionTmpResult);
        return $tmpResults;
    }

    public function delTmpResult($uid){
        $questionTmpResult = sprintf(Question_CacheConf::$QuestionTmpResult, $uid);
        $this->redis->DEL($questionTmpResult);
    }
}
