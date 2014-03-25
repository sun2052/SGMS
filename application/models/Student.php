<?php

class Student extends Model {

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
            if (isset($_POST['studentnumber']) && $_POST['studentnumber'] != '') {
                $studentnumber = $_POST['studentnumber'];
            } else {
                $str.='<p class="error">学号不能为空</p>';
            }

            if (isset($_POST['studentname']) && $_POST['studentname'] != '') {
                $studentname = $_POST['studentname'];
            } else {
                $str.='<p class="error">姓名不能为空</p>';
            }

            if (!empty($str)) {
                Controller::showMsg($str);
            } else {
                $this->retrieveOne('StudentNumber', $studentnumber);
                if ($this->getNumRows() != 0) {
                    Controller::showMsg('<p class="error">学生已存在，请重新输入</p>');
                }
                $sql = 'insert into `Student` (`Gender`,`StudentName`,`StudentNumber`) values (\'' . mysql_real_escape_string($_POST['gender']) . '\',\'' . mysql_real_escape_string($studentname) . '\',\'' . mysql_real_escape_string($studentnumber) . '\')';
                $this->query($sql);
            }
        }
    }

    public function delete($params) {
        if (!empty($params)) {
            //删除学生
            $sql = 'delete from `student` where `StudentID`=' . mysql_real_escape_string($params);
            $this->query($sql);
            //删除该学生的所有成绩
            $sql = 'delete from `grade` where `StudentID`=' . mysql_real_escape_string($params);
            $this->query($sql);
        } else {
            Controller::showMsg('<p class="error">参数错误，请重新输入</p>');
        }
    }

}

