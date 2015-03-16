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

$db_name = \util\MySQL::GetDbName();
$db_user = \util\MySQL::GetUserName();
$db_user_password = \util\MySQL::GetUserPassword();

 \util\MySQL::$db = new \PDO("mysql:host=localhost;dbname=$db_name", $db_user, $db_user_password);

$request = new Request();
$offset = $request->getCookieValue('offset');
$offset = ( intval($offset) + 10 );
$request->setCookiesWithKey('offset', $offset);

$global_service = new GlobalService();

$news = $global_service->GetGlobalNews($offset, 10);

$news_to_return = json_encode($news);
echo $news_to_return;

