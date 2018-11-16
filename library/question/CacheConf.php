<?php

class Question_CacheConf{
    public static $QuestionTmpResult = "question:tmp:result:%d"; //每个uid对应的临时提交的问题回答结果
    public static $UserSignUpCodeFrequency = "user:signfreq:%d"; //用于判断用户发送验证码是否过频
    public static $UserSignUpCode = "user:%d";//用户注册是验证码的键
}
