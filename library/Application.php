<?php

class Application {

    public function __construct() {
        // register custom autoload method
        spl_autoload_register(array('Application', 'autoloadClass'));

        // set all encodings to utf-8
        setlocale(LC_ALL, 'zh_CN.utf-8');
        iconv_set_encoding('internal_encoding', 'UTF-8');
        mb_internal_encoding('UTF-8');

        // define the default timezone used by the date functions
        date_default_timezone_set('Asia/Shanghai');

        // decide how to show errors
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();

        session_start();

        // route request
        $this->routeRequest();
    }

    // decide how to show errors
    public function setReporting() {
        if (DEVELOPMENT_ENVIRONMENT == true) {
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT . DS . 'tmp' . DS . 'error.log');
        }
    }

    // check for magic quotes and remove them
    public function stripSlashesDeep($value) {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
        return $value;
    }

    // check for magic quotes and remove them
    public function removeMagicQuotes() {
        if (get_magic_quotes_gpc()) {
            $_GET = stripSlashesDeep($_GET);
            $_POST = stripSlashesDeep($_POST);
            $_COOKIE = stripSlashesDeep($_COOKIE);
        }
    }

    // check for register globals and remove them
    public function unregisterGlobals() {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    // autoload class file when required
    public function autoloadClass($class) {
        if (file_exists(ROOT . DS . 'library' . DS . $class . '.php')) {
            require_once(ROOT . DS . 'library' . DS . $class . '.php');
        } else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . $class . '.php')) {
            require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . $class . '.php');
        } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . $class . '.php')) {
            require_once(ROOT . DS . 'application' . DS . 'models' . DS . $class . '.php');
        } else {
            Controller::showMsg('404');
        }
    }

    // parse request uri and route request
    public function routeRequest() {
        global $default;
        global $route;
        $params = array();

        if (!$route) {
            $controller = $default['controller'];
            $action = $default['action'];
        } else {
            $routeArray = explode('/', $route);
            $controller = $routeArray[0];
            array_shift($routeArray);
            if (isset($routeArray[0])) {
                $action = $routeArray[0];
                array_shift($routeArray);
            } else {
                $action = 'index'; // set default action if not specified
            }
            $params = $routeArray;
        }
        $this->performAction($controller, $action, $params);
    }

    public function performAction($controller, $action, $params=array()) {
        $controllerName = ucfirst($controller) . 'Controller';
        $dispatch = new $controllerName($controller, $action);
        if (method_exists($dispatch, $action)) {
            call_user_func_array(array($dispatch, 'beforeAction'), $params);
            call_user_func_array(array($dispatch, $action), $params);
            call_user_func_array(array($dispatch, 'afterAction'), $params);
        } else {
            Controller::showMsg('404');
        }
    }

}