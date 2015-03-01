<?php
require_once './model/entity/global_news.php';
require_once './model/service/GlobalService.php';
require_once './model/entity/district.php';
require_once './util/MySQL.php';
require_once './util/Request.php';

use model\entity\global_news;
use model\entity\district;
use model\service\GlobalService;
use util\Request;

\util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');

$request = new Request();
$offset = $request->getSessionValue('offset');
$offset = ( intval($offset) + 10 );
$request->setSessionValue('offset', $offset);

$global_service = new GlobalService();

$news = $global_service->GetGlobalNews($offset, 10);

$news_to_return = json_encode($news);

echo $news_to_return;
