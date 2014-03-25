<?php

class Search extends Model {

    public function index() {
        $result = array();
        $table = array();
        $courseName = array();
        $courseID = array();
        $name = array();
        $sql = 'select CourseID,CourseName from course';
        $this->query($sql);
        while ($row = mysql_fetch_assoc($this->_result)) {
            $courseID[] = array_shift($row);
            $courseName[] = array_shift($row);
        }
        $courseCount = count($courseName);
        $sql = 'select s.StudentID, s.StudentNumber, s.StudentName, g.Grade, g.GradeID, c.CourseID, c.CourseName, c.CourseCredit from student as s,grade as g,course as c where s.StudentID = g.StudentID and g.CourseID = c.CourseID order by s.StudentNumber';
        $this->query($sql);
        while ($row = mysql_fetch_assoc($this->_result)) {
            $table[] = $row;
        }
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
        $result[] = $name;
        $result[] = $courseCount;
        return $result;
    }

}

