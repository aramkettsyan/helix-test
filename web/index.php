<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);

require_once(__ROOT__.'db.php');
$db = new Db();
$link = $db->connect();

global $link;

require_once(__ROOT__.'routing.php');
$routing = new Routing();
$data = $routing->route();
if(empty($_POST) && empty($_FILES)){
    require_once __ROOT__.'view/layout/header.php';
}
if(file_exists(__ROOT__.'controller'.DIRECTORY_SEPARATOR.$data['controller'].'Controller.php')){
    $name = $data['controller'].'Controller';
    require(__ROOT__.'controller'.DIRECTORY_SEPARATOR.$name.'.php');

    $controller = new $name();
    if(method_exists($controller,$data['action'])){
        $content = $controller->$data['action']();
    }else{
        require_once(__ROOT__.'view'.DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.'error_404.php');
    }
}else{
    require_once(__ROOT__.'view'.DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.'error_404.php');
}
if(empty($_POST) && empty($_FILES)) {
    require_once __ROOT__ . 'view/layout/footer.php';
}