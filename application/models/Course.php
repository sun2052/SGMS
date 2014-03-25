<?php

class Course extends Model {

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
            if (isset($_POST['coursename']) && $_POST['coursename'] != '') {
                $coursename = $_POST['coursename'];
            } else {
                $str.='<p class="error">课程名称不能为空</p>';
            }

            if (isset($_POST['coursecredit']) && $_POST['coursecredit'] != '') {
                $coursecredit = $_POST['coursecredit'];
            } else {
                $str.='<p class="error">课程学分不能为空</p>';
            }

            if (!empty($str)) {
                Controller::showMsg($str);
            } else {
                $this->retrieveOne('CourseName', $coursename);
                if ($this->getNumRows() != 0) {
                    Controller::showMsg('<p class="error">课程已存在，请重新输入</p>');
                }
                $salt = Model::generateToken();
                $sql = 'insert into `Course` (`CourseName`,`CourseCredit`) values (\'' . mysql_real_escape_string($coursename) . '\',\'' . mysql_real_escape_string($coursecredit) . '\')';
                $this->query($sql);
            }
        }
    }

    public function delete($params) {
        if (!empty($params)) {
            //删除课程
            $sql = 'delete from `course` where `CourseID`=' . mysql_real_escape_string($params);
            $this->query($sql);
            //删除该课程所有成绩记录
            $sql = 'delete from `grade` where `CourseID`=' . mysql_real_escape_string($params);
            $this->query($sql);
        } else {
            Controller::showMsg('<p class="error">参数错误，请重新输入</p>');
        }
    }

}

