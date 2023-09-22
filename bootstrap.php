<?php
define('_DIR_ROOT', __DIR__);

// Xu ly hhtp root

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] = 'on') {
    $web_root = 'https://'.$_SERVER['HTTP_HOST'];
}else {
    $web_root = 'http://'.$_SERVER['HTTP_HOST'];
}

$dirRoot = str_replace('\\', '/', _DIR_ROOT);

$documentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

$folder = str_replace(strtolower($documentRoot), '', strtolower($dirRoot));

$web_root = $web_root.$folder;

define('_WEB_ROOT', $web_root);

/*
 * Tự động load configs
 *
 * */
$configs_dir = scandir('configs');
if (!empty($configs_dir)){
    foreach ($configs_dir as $item){
        if ($item!='.' && $item!='..' && file_exists('configs/'.$item)){
            require_once 'configs/'.$item;
        }
    }
}

// Loai Service Provider
require_once 'core/ServiceProvider.php';

// Load view share
require_once 'core/View.php';

// Load
require_once 'core/Load.php';

// Middleware
require_once 'core/Middlewares.php';

require_once 'core/Route.php';



// Kiểm tra config và load Database
if (!empty($config['database'])){
    $db_config = array_filter($config['database']);

    if (!empty($db_config)){
        require_once 'core/Connection.php';
        require_once 'core/QueryBuilder.php';
        require_once 'core/Database.php';
        require_once 'core/DB.php';
    }
}

require_once 'core/Session.php';

require_once 'app/App.php';

// Load core helpers
require_once 'core/Helper.php';

// Load all helpers 
// Hàm scandir() trong PHP được sử dụng để liệt kê tất cả các tệp và thư mục có trong một đường dẫn cụ thể 
$allHelpers = scandir('app/helpers');
if (!empty($allHelpers)){
    foreach ($allHelpers as $item){
        if ($item!='.' && $item!='..' && file_exists('app/helpers/'.$item)){
            require_once 'app/helpers/'.$item;
        }
    }
}

require_once 'core/Model.php';
require_once 'core/Controller.php'; //Load base controller
require_once 'core/Request.php'; // Load request
require_once 'core/Response.php'; // Load response
