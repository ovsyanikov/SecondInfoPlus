<?php
require_once './model/entity/global_news.php';
require_once './model/service/GlobalService.php';
require_once './model/entity/district.php';
require_once './util/MySQL.php';

use model\entity\global_news;
use model\entity\district;
use model\service\GlobalService;

\util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');

