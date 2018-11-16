<?php


class Question_Const{

    const TAG_OTHER = 0;
    const TAG_CS_MYSQL = 100;
    const TAG_CS_PHP = 101;
    const TAG_CS_NGINX = 102;
    const TAG_CS_REDIS = 103;
    const TAG_CS_HTML = 200;
    const TAG_CS_JAVASCRIPT = 201;
    const TAG_CS_CSS = 202;
    const TAG_CS_NODE = 203;
    const TAG_CS_VUE = 204;
    const TAG_CS_WEBPACK = 205;
    const TAG_CS_KOA = 206;
    const TAG_CS_ECHARTS = 207;
    const TAG_CS_PYTHON = 300;
    const TAG_TOOL_GIT = 400;
    const TAG_TOOL_SHELL = 401;
    const TAG_TOOL_LINUX = 402;
    const TAG_TOOL_SHORTCUT = 403;
    const TAG_TOOL_MATH = 600;
    const TAG_LIFE_EBOOK = 1100;
    const TAG_LIFE_SONG = 1101;
    const TAG_LIFE_KNOWPERSON = 1200;
    const TAG_LIFE_MODE = 1201;
    const TAG_LIFE_YUEYU = 1300;
    const TAG_LIFE_HOLIDAY = 1400;
    const TAG_WORK_BACKUP = 2100;
    const TAG_NO_TYPE = 90000;

    const TAG_MAP = array(
        self::TAG_OTHER => '其它',
        self::TAG_CS_MYSQL => 'mysql',
        self::TAG_CS_PHP => 'php',
        self::TAG_CS_NGINX => 'nginx',
        self::TAG_CS_REDIS => 'redis',
        self::TAG_CS_HTML => 'html',
        self::TAG_CS_JAVASCRIPT => 'javascript',
        self::TAG_CS_CSS => 'css',
        self::TAG_CS_NODE => 'node',
        self::TAG_CS_VUE => 'vue',
        self::TAG_CS_WEBPACK => 'webpack',
        self::TAG_CS_KOA => 'koa',
        self::TAG_CS_ECHARTS => 'echarts',
        self::TAG_CS_PYTHON => 'python',
        self::TAG_TOOL_GIT => 'git',
        self::TAG_TOOL_SHELL => 'shell',
        self::TAG_TOOL_LINUX => 'linux',
        self::TAG_TOOL_SHORTCUT => '常用快捷键',
        self::TAG_TOOL_MATH => '数量',
        self::TAG_LIFE_EBOOK => '电子书',
        self::TAG_LIFE_SONG => '歌曲',
        self::TAG_LIFE_KNOWPERSON => '识人',
        self::TAG_LIFE_MODE => '感悟',
        self::TAG_LIFE_YUEYU => '粤语发音',
        self::TAG_LIFE_HOLIDAY => '假期安排',
        self::TAG_WORK_BACKUP => '工作备忘',
        self::TAG_NO_TYPE => '无分类',
    );
}
