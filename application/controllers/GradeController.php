<?php

class GradeController extends Controller {

    public function index() {
        $this->_model->requireAuthentication(ADMIN);
        $this->render('', $this->_model->index());
    }

    public function add() {
        $this->_model->requireAuthentication(ADMIN);
        $this->_model->add();
        Controller::showMsg('添加记录成功。');
    }

    public function delete($params) {
        $this->_model->requireAuthentication(ADMIN);
        $this->_model->delete($params);
        Controller::showMsg('删除记录成功。');
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

