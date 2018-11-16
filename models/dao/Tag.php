<?php

class Dao_Tag{

    private $table = 'tag';

    public $mysql;
    public $redis;

    public function __construct(){
        $this->mysql = mysql::get_instance();
        $this->redis = RedisLib::get_instance();
    }

    public function fetchNameById($id){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT tagname FROM {$this->table} WHERE id = $id";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_assoc($res);
        return $res['tagname'];
    }

    public function fetchTagidByName($uid, $tagName, $currclasstwoid){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT id FROM {$this->table} WHERE uid = $uid AND tagname = \"$tagName\" AND level = 3 AND uplevelid = $currclasstwoid";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_assoc($res);
        return $res;
    }

    public function addTagOne($uid, $tagName){
        $time = time();
        $this->mysql->query("set character set 'utf8mb4'");
        $tagName = $this->mysql->real_escape_string($tagName);
        $sql = "INSERT INTO {$this->table} (uid, tagname, level, timestamp) VALUES ($uid, \"$tagName\", 1, $time)";
        $res = $this->mysql->query($sql);
        return $res;
    }

    public function addTagTwo($uid, $tagName, $upLevelId){
        $time = time();
        $this->mysql->query("set character set 'utf8mb4'");
        $tagName = $this->mysql->real_escape_string($tagName);
        $sql = "INSERT INTO {$this->table} (uid, tagname, level, timestamp, uplevelid) VALUES ($uid, \"$tagName\", 2, $time, $upLevelId)";
        $res = $this->mysql->query($sql);
        return $res;
    }

    public function addTagThree($uid, $tagName, $upLevelId){
        $time = time();
        $this->mysql->query("set character set 'utf8mb4'");
        $tagName = $this->mysql->real_escape_string($tagName);
        $sql = "INSERT INTO {$this->table} (uid, tagname, level, timestamp, uplevelid) VALUES ($uid, \"$tagName\", 3, $time, $upLevelId)";
        $res = $this->mysql->query($sql);
        return $res;
    }

    public function getTagsOne($uid){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT id, tagname FROM {$this->table} WHERE uid = $uid AND level = 1 AND deleted = 0";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $res;
    }

    public function getTagsTwo($uid){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT id, tagname, uplevelid FROM {$this->table} WHERE uid = $uid AND level = 2 AND deleted = 0";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $res;
    }

    public function getTagsThree($uid){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT id, tagname, uplevelid FROM {$this->table} WHERE uid = $uid AND deleted = 0 AND level = 3";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $res;
    }

    public function getTagsByUplevelid($uid, $uplevelid){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT id, tagname, uplevelid FROM {$this->table} WHERE uid = $uid AND deleted = 0 AND uplevelid = $uplevelid";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $res;
    }

    public function ifHasTagOne($uid, $tagName){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT COUNT(1) AS num FROM {$this->table} WHERE uid = $uid AND tagname = \"$tagName\" AND deleted = 0 AND level = 1";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_assoc($res);
        return $res;
    }

    public function ifHasTagTwo($uid, $tagName, $uplevelid){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT COUNT(1) AS num FROM {$this->table} WHERE uid = $uid AND tagname = \"$tagName\" AND deleted = 0 AND uplevelid = $uplevelid AND level = 2";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_assoc($res);
        return $res;
    }

    public function ifHasTagThree($uid, $tagName, $uplevelid){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT COUNT(1) AS num FROM {$this->table} WHERE uid = $uid AND tagname = \"$tagName\" AND deleted = 0 AND uplevelid = $uplevelid AND level = 3";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_assoc($res);
        return $res;
    }

    public function getUperTag($tag){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "SELECT uplevelid FROM {$this->table} WHERE id = $tag";
        $res = $this->mysql->query($sql);
        $res = mysqli_fetch_assoc($res);
        return $res['uplevelid'];
    }

    public function editTagOne($uid, $id, $tagName){
        $this->mysql->query("set character set 'utf8mb4'");
        $tagName = $this->mysql->real_escape_string($tagName);
        $sql = "UPDATE {$this->table} SET `tagname` = \"$tagName\" WHERE `uid` = $uid AND `id` = $id";
        $res = $this->mysql->query($sql);
        return $res;
    }

    public function editTagTwo($uid, $id, $tagName, $uplevelid){
        $this->mysql->query("set character set 'utf8mb4'");
        $tagName = $this->mysql->real_escape_string($tagName);
        $sql = "UPDATE {$this->table} SET `tagname` = \"$tagName\", `uplevelid` = $uplevelid WHERE `uid` = $uid AND `id` = $id";
        $res = $this->mysql->query($sql);
        return $res;
    }

    public function deleteTag($id, $uid){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "UPDATE {$this->table} SET deleted = 1 WHERE `uid` = $uid AND `id` = $id";
        $res = $this->mysql->query($sql);
        return $res;
    }

    public function deleteTagByUplevelid($id, $uid){
        $this->mysql->query("set character set 'utf8mb4'");
        $sql = "UPDATE {$this->table} SET deleted = 1 WHERE `uid` = $uid AND `uplevelid` = $id";
        $res = $this->mysql->query($sql);
        return $res;
    }
}