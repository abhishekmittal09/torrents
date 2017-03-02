<?php

namespace abhishekmittal09\torrents;

class App
{
    public static function init()
    {
        define('ROOT_DIR', realpath('..'));
        define('ACTIVE_DIR', ROOT_DIR . '/files/active');
        define('UPLOAD_DIR', ROOT_DIR . '/files/uploads');
    }
}