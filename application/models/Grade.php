<?php

class Grade extends Model {

    public function index() {
        $result = array();
        $table = array();
        $courseName = array();
        $courseID = array();
        $studentName = array();
        $sql = 'select CourseID,CourseName from course order by CourseName';
        $this->query($sql);
        while ($row = mysql_fetch_assoc($this->_result)) {
            $courseID[] = array_shift($row);
            $courseName[] = array_shift($row);
        }
        $courseCount = count($courseName);
//        var_dump($courseID,$courseName);
        $sql = 'select s.StudentID, s.StudentNumber, s.StudentName, g.Grade, g.GradeID, c.CourseID, c.CourseName, c.CourseCredit from student as s join grade as g on s.StudentID = g.StudentID join course as c on g.CourseID = c.CourseID order by s.StudentNumber, c.CourseName';
        $this->query($sql);
        while ($row = mysql_fetch_assoc($this->_result)) {
            $table[] = $row;
        }
        //var_dump($table);
        if (!empty($table)) {
            $result[] = array(
                'StudentID' => $table[0]['StudentID'],
                'StudentNumber' => $table[0]['StudentNumber'],
                'StudentName' => $table[0]['StudentName'],
                'GradeID' => array($table[0]['GradeID']),
                'Grade' => array($table[0]['Grade']),
                'CourseID' => array($table[0]['CourseID']),
                'CourseName' => array($table[0]['CourseName']),
                'CourseCredit' => array($table[0]['CourseCredit'])
            );
            for ($i = 1; $i < count($table); $i++) {
                $row = $table[$i];
                if ($row['StudentNumber'] == $result[count($result) - 1]['StudentNumber']) {
                    $result[count($result) - 1]['GradeID'][] = $row['GradeID'];
                    $result[count($result) - 1]['Grade'][] = $row['Grade'];
                    $result[count($result) - 1]['CourseID'][] = $row['CourseID'];
                    $result[count($result) - 1]['CourseName'][] = $row['CourseName'];
                    $result[count($result) - 1]['CourseCredit'][] = $row['CourseCredit'];
                } else {
                    $result[] = array(
                        'StudentID' => $row['StudentID'],
                        'StudentNumber' => $row['StudentNumber'],
                        'StudentName' => $row['StudentName'],
                        'GradeID' => array($row['GradeID']),
                        'Grade' => array($row['Grade']),
                        'CourseID' => array($row['CourseID']),
                        'CourseName' => array($row['CourseName']),
                        'CourseCredit' => array($row['CourseCredit'])
                    );
                }
            }
            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['GradeID'] = array_pad($result[$i]['GradeID'], $courseCount, '-');
                $result[$i]['Grade'] = array_pad($result[$i]['Grade'], $courseCount, '-');
                $result[$i]['CourseID'] = $courseID;
                $result[$i]['CourseName'] = $courseName;
                $result[$i]['CourseCredit'] = array_pad($result[$i]['CourseCredit'], $courseCount, '-');
            }
        }

        $sql = 'select StudentNumber,StudentName,StudentID from student where StudentID not in (select StudentID from grade)';
        $this->query($sql);
        while ($row = mysql_fetch_assoc($this->_result)) {
            $name[] = array($row['StudentID'], $row['StudentNumber'] . ' - ' . $row['StudentName']);
        }

        foreach ($result as &$value) {
            foreach ($value['Grade'] as $key => &$value2) {
                if ($value2 != '-' && $value2 < 60) {
                    $value['CourseCredit'][$key] = 0;
                }
            }
        }
        unset($value);
        unset($value2);
//        var_dump($result);
//        exit;
        $result[] = $name;
        $result[] = $courseCount;
        return $result;
    }

    public function add() {
        $str = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_POST['studentlist']) || $_POST['studentlist'] == '') {
                $str.='<p class="error">请先添加学生</p>';
                Controller::showMsg($str);
            }
            foreach ($_POST as $key => $value) {
                if ($value == '') {
                    $str.='<p class="error">成绩必须填写完整，不能为空</p>';
                    break;
                }
            }

            if (!empty($str)) {
                Controller::showMsg($str);
            } else {
                $this->retrieveOne('StudentID', $_POST['studentlist']);
                if ($this->getNumRows() != 0) {
                    Controller::showMsg('<p class="error">记录已存在，请重新输入</p>');
                }
                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'course') === false) {
                        continue;
                    } else {
                        $courseID = intval(str_replace('course', '', $key));
                    }
                    $sql = 'insert into `grade` (`StudentID`,`CourseID`,`Grade`) values (\'' . mysql_real_escape_string($_POST['studentlist']) . '\',\'' . mysql_real_escape_string($courseID) . '\',\'' . mysql_real_escape_string($value) . '\')';
                    $this->query($sql);
                }
            }
        }
    }

    public function delete($params) {
        if (!empty($params)) {
            $sql = 'delete from `grade` where `StudentID`=' . mysql_real_escape_string($params);
            $this->query($sql);
        } else {
            Controller::showMsg('<p class="error">参数错误，请重新输入</p>');
        }
    }

    public function update($params) {
        if (!empty($params)) {
            $str = '';
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                foreach ($_POST as $key => $value) {
                    if ($value == '') {
                        $str.='<p class="error">成绩必须填写完整，不能留空</p>';
                        break;
                    }
                }
                if (!empty($str)) {
                    Controller::showMsg($str);
                } else {
                    $sql = 'delete from `grade` where `StudentID`=\'' . mysql_real_escape_string($params) . '\'';
                    $this->query($sql);
                    foreach ($_POST as $key => $value) {
                        if (strpos($key, 'course') === false) {
                            continue;
                        } else {
                            $courseID = intval(str_replace('course', '', $key));
                        }

                        $sql = 'insert into `grade` (`StudentID`,`CourseID`,`Grade`) values (\'' . mysql_real_escape_string($params) . '\',\'' . mysql_real_escape_string($courseID) . '\',\'' . mysql_real_escape_string($value) . '\')';
                        $this->query($sql);
                    }
                }
                //var_dump($sql);exit;
            } else {
                $sql = 'select CourseID,CourseName from course order by CourseName';
                $this->query($sql);
                while ($row = mysql_fetch_assoc($this->_result)) {
                    $courseID[] = array_shift($row);
                    $courseName[] = array_shift($row);
                }
                $courseCount = count($courseName);
                $sql = 'select s.StudentID, s.StudentNumber, s.StudentName, g.Grade, g.GradeID, c.CourseID, c.CourseName, c.CourseCredit from student as s,grade as g,course as c where s.StudentID = g.StudentID and g.CourseID = c.CourseID and g.StudentID=' . mysql_real_escape_string($params) . ' order by s.StudentNumber, c.CourseName';
                $this->query($sql);
                while ($row = mysql_fetch_assoc($this->_result)) {
                    $table[] = $row;
                }
//                var_dump($table);exit;

                if (!empty($table)) {
                    $result[] = array(
                        'StudentID' => $table[0]['StudentID'],
                        'StudentNumber' => $table[0]['StudentNumber'],
                        'StudentName' => $table[0]['StudentName'],
                        'GradeID' => array($table[0]['GradeID']),
                        'Grade' => array($table[0]['Grade']),
                        'CourseID' => array($table[0]['CourseID']),
                        'CourseName' => array($table[0]['CourseName']),
                        'CourseCredit' => array($table[0]['CourseCredit'])
                    );
                    for ($i = 1; $i < count($table); $i++) {
                        $row = $table[$i];
                        if ($row['StudentNumber'] == $result[count($result) - 1]['StudentNumber']) {
                            $result[count($result) - 1]['GradeID'][] = $row['GradeID'];
                            $result[count($result) - 1]['Grade'][] = $row['Grade'];
                            $result[count($result) - 1]['CourseID'][] = $row['CourseID'];
                            $result[count($result) - 1]['CourseName'][] = $row['CourseName'];
                            $result[count($result) - 1]['CourseCredit'][] = $row['CourseCredit'];
                        }
                    }
                    for ($i = 0; $i < count($result); $i++) {
                        $result[$i]['GradeID'] = array_pad($result[$i]['GradeID'], $courseCount, '');
                        $result[$i]['Grade'] = array_pad($result[$i]['Grade'], $courseCount, '');
                        $result[$i]['CourseID'] = $courseID;
                        $result[$i]['CourseName'] = $courseName;
                        $result[$i]['CourseCredit'] = array_pad($result[$i]['CourseCredit'], $courseCount, '');
                    }
                }
                $result[] = $courseCount;
//                var_dump($result);
//                exit;
                return $result;
            }
        } else {
            Controller::showMsg('<p class="error">参数错误，请重新输入</p>');
        }
    }

}

