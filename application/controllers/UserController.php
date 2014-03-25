<?php

class UserController extends Controller {

    public function login() {
        $this->_model->authenticate();
        if (isset($_SESSION['Authenticated']) && $_SESSION['Authenticated'] == true) {
            Controller::redirect();
        } else {
            $this->render();
        }
    }

    public function logout() {
        if (isset($_SESSION['Authenticated']) && $_SESSION['Authenticated'] == true) {
            $_SESSION['Authenticated'] = false;
            $this->render();
        } else {
            Controller::redirect();
        }
    }

    public function index() {
        $this->_model->requireAuthentication(ADMIN);
        $this->render('', $this->_model->index());
    }

    public function add() {
        $this->_model->requireAuthentication(ADMIN);
        $this->_model->add();
        Controller::showMsg('添加用户成功。');
    }

    public function delete($params) {
        $this->_model->requireAuthentication(ADMIN);
        $this->_model->delete($params);
        Controller::showMsg('删除用户成功。');
    }

    public function update($params) {
        $this->_model->requireAuthentication(ADMIN);
        $t = $this->_model->update($params);

        if ($t) {
            $this->render('', $t);
        } else {
            Controller::showMsg('修改用户成功。');
        }
    }

}

