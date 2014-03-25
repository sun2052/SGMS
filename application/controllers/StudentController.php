<?php

class StudentController extends Controller {

    public function index() {
        $this->_model->requireAuthentication(ADMIN);
        $this->render('', $this->_model->index());
    }

    public function add() {
        $this->_model->requireAuthentication(ADMIN);
        $this->_model->add();
        Controller::showMsg('添加学生成功。');
    }

    public function delete($params) {
        $this->_model->requireAuthentication(ADMIN);
        $this->_model->delete($params);
        Controller::showMsg('删除学生成功。');
    }

}

