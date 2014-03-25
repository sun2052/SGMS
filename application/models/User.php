<?php

class User extends Model {

    public function index() {
        $data = array();
        $this->retrieveAll();
        while ($row = mysql_fetch_assoc($this->_result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function add() {
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
                if ($this->getNumRows() != 0) {
                    Controller::showMsg('<p class="error">用户名已存在，请重新输入</p>');
                }
                $salt = Model::generateToken();
                $sql = 'insert into `User` (`UserName`,`Password`,`Salt`,`Privilege`) values (\''
                        . mysql_real_escape_string($username) . '\',\''
                        . md5(mysql_real_escape_string($password) . $salt) . '\',\'' . $salt . '\',\''
                        . mysql_real_escape_string($_POST['privilege']) . '\')';
                $this->query($sql);
            }
        }
    }

    public function delete($params) {
        if (!empty($params)) {
            $sql = 'delete from `User` where `UserID`=' . mysql_real_escape_string($params);
            $this->query($sql);
        } else {
            Controller::showMsg('<p class="error">参数错误，请重新输入</p>');
        }
    }

    public function update($params) {
        if (!empty($params)) {
            $str = '';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if (isset($_POST['password']) && $_POST['password'] != '') {
                    $password = $_POST['password'];
                } else {
                    $str.='<p class="error">密码不能为空</p>';
                }
                if (!empty($str)) {
                    Controller::showMsg($str);
                }
                if (isset($_POST['repassword']) && $_POST['repassword'] != '') {
                    $repassword = $_POST['repassword'];
                } else {
                    $str.='<p class="error">确认密码不能为空</p>';
                }
                if (!empty($str)) {
                    Controller::showMsg($str);
                }
                if ($_POST['repassword'] == $_POST['password']) {
                    $password = $_POST['password'];
                } else {
                    $str.='<p class="error">两次输入的密码不一致，请重新输入</p>';
                }
                if (!empty($str)) {
                    Controller::showMsg($str);
                } else {
                    $this->retrieveOne('UserID', $params);
                    if ($this->getNumRows() == 0) {
                        Controller::showMsg('<p class="error">用户不存在，请重新输入</p>');
                    }
                    $salt = Model::generateToken();
                    $sql = 'update `user` set `Password`=\'' . md5(mysql_real_escape_string($password) . $salt)
                            . '\', `Salt`=\'' . mysql_real_escape_string($salt) . '\' where `UserID`=' . $params;
                    $this->query($sql);
                }
            } else {
                $this->retrieveOne('UserID', $params);
                if ($this->getNumRows() == 0) {
                    Controller::showMsg('<p class="error">用户不存在，请重新输入</p>');
                }
                $row = mysql_fetch_assoc($this->_result);
                return $row;
            }
        } else {
            Controller::showMsg('<p class="error">参数错误，请重新输入</p>');
        }
    }

}

