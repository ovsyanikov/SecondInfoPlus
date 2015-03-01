<?php

require_once './model/Service/GlobalService.php';
require_once './model/Entity/stopword.php';
require_once './util/MySQL.php';

use model\service\GlobalService;
\util\MySQL::$db = new \PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');
$gs = new GlobalService();

$res = $gs->IsContainsStopWord("митинг");
if($res)
    echo "contains";
else {
    echo "not contains";
}