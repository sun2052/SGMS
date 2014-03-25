<?php

class Controller {

    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_data = array();

    public function __construct($controller, $action) {
        $this->_controller = $controller;
        $this->_action = $action;

        $model = ucfirst($controller);
        $this->_model = new $model();
    }

    public function beforeAction() {
        
    }

    public function set($name, $value) {
        $this->_data[$name] = $value;
    }

    public function render($view=null, $data=array()) {
        if (!$view) {
            $view = $this->_action;
        }

        if (!$data) {
            $data = $this->_data;
        }

        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';

        if (!$isAjax) {
            if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'header.php')) {
                require_once (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'header.php');
            } else {
                require_once (ROOT . DS . 'application' . DS . 'views' . DS . 'site' . DS . 'header.php');
            }
        }

        if (!$isAjax) {
            if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'nav.php')) {
                require_once (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'nav.php');
            } else {
                require_once (ROOT . DS . 'application' . DS . 'views' . DS . 'site' . DS . 'nav.php');
            }
        }

        if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $view . '.php')) {
            include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $view . '.php');
        } else {
            require_once (ROOT . DS . 'application' . DS . 'views' . DS . 'site' . DS . $view . '.php');
        }

        if (!$isAjax) {
            if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'footer.php')) {
                require_once (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'footer.php');
            } else {
                require_once (ROOT . DS . 'application' . DS . 'views' . DS . 'site' . DS . 'footer.php');
            }
        }
    }

    public function afterAction() {
        
    }

    public static function redirect($uri=null) {
        header('Location: ' . WEB_FOLDER . $uri);
        exit();
    }

    public static function showMsg($msg=null) {
        require_once (ROOT . DS . 'application' . DS . 'views' . DS . 'site' . DS . 'header.php');
        if ($msg == '404') {
            require_once (ROOT . DS . 'application' . DS . 'views' . DS . 'site' . DS . '404.php');
        } else {
            require_once (ROOT . DS . 'application' . DS . 'views' . DS . 'site' . DS . 'msg.php');
        }
        require_once (ROOT . DS . 'application' . DS . 'views' . DS . 'site' . DS . 'footer.php');
        exit();
    }

}