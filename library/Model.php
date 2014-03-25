<?php

class Model {

    protected $_dbHandle;
    protected $_result;
    protected $_model;
    protected $_table;

    public function __construct() {
        $this->_model = get_class($this);
        $this->_table = strtolower($this->_model);
        $this->connect();
        //set all to utf8
        $this->query('SET NAMES "UTF8"');
        $this->query('SET CHARACTER SET "UTF8"');
        $this->query('SET CHARACTER_SET_RESULTS="UTF8"');
    }

    public function connect() {
        $this->_dbHandle = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
        if ($this->_dbHandle && mysql_select_db(DB_NAME, $this->_dbHandle)) {
            return true;
        } else {
            return false;
        }
    }

    public function retrieveAll() {
        $sql = 'select * from `' . $this->_table . '`';
        $this->_result = mysql_query($sql, $this->_dbHandle);
    }

    public function retrieveOne($field, $value) {
        $sql = 'select * from `' . $this->_table . '` where `' . $field . '` = \'' . mysql_real_escape_string($value) . '\'';
        $this->_result = mysql_query($sql, $this->_dbHandle);
    }

    public function query($sql) {
        $this->_result = mysql_query($sql, $this->_dbHandle);
    }

    public function getNumRows() {
        return mysql_num_rows($this->_result);
    }

    public function getError() {
        return mysql_error($this->_dbHandle);
    }

    // generate a random 32 character MD5 token
    public static function generateToken() {
        return md5(str_shuffle(mt_rand() . uniqid()));
    }

    public function authenticate() {
        $str = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['username']) && $_POST['username'] != '') {
                $username = $_POST['username'];
            } else {
                $str.='<p class="error">用户名不能为空</p>';
            }

            if (isset($_POST['password']) && $_POST['password'] != '') {
                $password = $_POST['password'];
            } else {
                $str.='<p class="error">密码不能为空</p>';
            }

            if (!empty($str)) {
                Controller::showMsg($str);
            } else {
                $this->retrieveOne('UserName', $username);

                if ($this->getNumRows() == 0) {
                    Controller::showMsg('<p class="error">用户名或密码错误，请重新输入</p>');
                }
                $row = mysql_fetch_assoc($this->_result);
                if (md5($password . $row['Salt']) == $row['Password']) {
                    $_SESSION = $row;
                    $_SESSION['Authenticated'] = true;
                } else {
                    $_SESSION = array();
                    $_SESSION['Authenticated'] = false;
                }
            }
        }
    }

    public function requireAuthentication($role=null) {
        if (!isset($_SESSION['Authenticated']) || $_SESSION['Authenticated'] == false) {
            Controller::redirect('user/login');
        } else if (isset($role) && $_SESSION['Privilege'] > $role) {
            Controller::showMsg('<p class="error">当前用户没有权限查看本页面，请退出后，使用管理员用户登录</p>');
        }
    }

    public function __destruct() {
//        if ($this->_result) {
//            mysql_free_result($this->_result);
//        }
//        if ($this->_dbHandle) {
//            mysql_close($this->_dbHandle);
//        }
    }

}