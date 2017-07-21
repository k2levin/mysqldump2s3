<?php

require __DIR__.'/../vendor/autoload.php';

date_default_timezone_set('Asia/Singapore');
set_time_limit(0);

$app = new Lib\App;
$app->main();
