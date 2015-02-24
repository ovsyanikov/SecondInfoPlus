<?php
    
    require_once './util/Request.php';
    require_once './util/MySQL.php';
    require_once './model/entity/global_news.php';
    require_once './model/Service/GlobalService.php';
    require_once './model/entity/district.php';
    
    \util\MySQL::$db = new PDO('mysql:host=localhost;dbname=u304199710_info', 'u304199710_alex', '1qaz2wsx');
    use util\Request;
    use model\entity\global_news;
    use model\service\GlobalService;
    use model\entity\district;
    
    $request = new Request();
    
    $district = $request->getPostValue('district');
    $title = $request->getPostValue('Title');
    $description = $request->getPostValue('Description');
    $source = $request->getPostValue('Source');
    $img = $request->getPostValue('img');
    
    $global_service = new GlobalService();
    $globat_district = $global_service->GetDistrictByName($district);
    
    $global_news = new global_news();
    $global_news->setDescription($description);
    $global_news->setTitle($title);
    $global_news->setImage($img);
    $global_news->setSource($source);
    $global_news->setDistrict($globat_district->getId());
    
    echo "{$global_service->AddGlobalNews($global_news)}";
    
    
    
    
    
    