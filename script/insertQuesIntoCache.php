<?php
require('/home/dongyang/yaf/app/questionbook/Env.php');
$app = new Yaf_Application(CONF_PATH.'/application.ini');
$app->bootstrap()->execute(array('Service_Data_Question_Item', 'insertQuestions'));
