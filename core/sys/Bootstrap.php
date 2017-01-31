<?php

class Bootstrap {

    public static function run() {
       self::init();
       self::autoload();
       self::dispatch();
    }

    private static function init() {

        define("DS", DIRECTORY_SEPARATOR);

        define("ROOT", getcwd() . DS);

        define("APP_PATH", ROOT . 'app' . DS);

        define("CORE_PATH", ROOT . "core" . DS);

        define("PUBLIC_PATH", ROOT . "public" . DS);


        define("CONFIG_PATH", APP_PATH . "config" . DS);

        define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);

        define("MODEL_PATH", APP_PATH . "models" . DS);

        define("VIEW_PATH", APP_PATH . "views" . DS);

        define("SYS_PATH", CORE_PATH. "sys" . DS);

        define('DB_PATH', CORE_PATH . "database" . DS);

        define("LIB_PATH", CORE_PATH. "lib" . DS);

        define("HELPER_PATH", CORE_PATH . "helper" . DS);

        define("UPLOAD_PATH", PUBLIC_PATH . "upload" . DS);


        // Define platform, controller, action, for example:

        // index.php?p=admin&c=Goods&a=add

        define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');

        define("CONTROLLER", isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Index');

        define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');


        define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);

        define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);

        require_once SYS_PATH . "Controller.php";

        require_once SYS_PATH . "Model.php";

        require_once SYS_PATH . "Loader.php";

        $GLOBALS['config'] = include CONFIG_PATH . "config.php";
        session_start();
    }

    private static function autoload(){
        spl_autoload_register(array(__CLASS__,'load'));
    }

    private static function load($classname){
        if (substr($classname, -10) == "Controller" ){
            require_once  CURR_CONTROLLER_PATH . "$classname.php";
        } elseif (substr($classname, -5) == "Model"){
            require_once  MODEL_PATH . "$classname.php";
        }
    }

    private static function dispatch(){

        $controller_name = CONTROLLER . "Controller";

        $action_name = ACTION . "Action";

        $controller = new $controller_name;

        $controller->$action_name();

    }

}