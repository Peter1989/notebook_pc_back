<?php

class Controller_Tag extends Yaf_Controller_Abstract {
    public $actions = [
        'addtag' => 'actions/tag/addtag.php',
        'gettags' => 'actions/tag/gettags.php',
        'edittag' => 'actions/tag/edittag.php',
        'deletetag' => 'actions/tag/deletetag.php'
    ];
}