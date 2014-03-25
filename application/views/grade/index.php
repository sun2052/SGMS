<?php
$courseCount = intval(array_pop($data));
$studentlist = array_pop($data);
if (count($data) > 1) {
    $recordCount = count($data);
} else {
    $recordCount = 0;
}
?>
<div id="content">
    <table  class="dataTable" summary="成绩管理">
        <caption>成绩管理</caption>
        <thead>
            <tr>
                <th rowspan="2">学号</th>
                <th rowspan="2">姓名</th>
                <?php for ($i = 0; $i < $courseCount; $i++): ?>
                    <th colspan="2"><?php echo $data[0]['CourseName'][$i]; ?></th>
                <?php endfor; ?>
                <th rowspan="2">操作</th>
            </tr>

            <tr>
                <?php for ($i = 0; $i < $courseCount; $i++): ?>
                    <th>成绩</th>
                    <th>学分</th>
                <?php endfor; ?>
            </tr>

        </thead>
        <tbody>
            <?php foreach ($data as $record): ?>
                <tr>
                    <td><?php echo $record['StudentNumber']; ?></td>
                    <td><?php echo $record['StudentName']; ?></td>
                    <?php for ($i = 0; $i < $courseCount; $i++): ?>
                        <td<?php echo $record['CourseCredit'][$i] === 0 ? ' class="failed"' : ''; ?>><?php echo $record['Grade'][$i]; ?></td>
                        <td<?php echo $record['CourseCredit'][$i] === 0 ? ' class="failed"' : ''; ?>><?php echo $record['CourseCredit'][$i]; ?></td>
                    <?php endfor; ?>
                    <td><a href="<?php echo WEB_FOLDER; ?>grade/update/<?php echo $record['StudentID']; ?>">修改</a>|<a href="<?php echo WEB_FOLDER; ?>grade/delete/<?php echo $record['StudentID']; ?>">删除</a></td>
                </tr>
            <?php endforeach; ?>
            <tr>
        <form id="addGrade" method="post" action="<?php echo WEB_FOLDER; ?>grade/add" enctype="multipart/form-data">
            <td colspan="2"><select id="studentlist" name="studentlist">
                    <?php foreach ($studentlist as $value): ?>
                        <option value="<?php echo $value[0]; ?>"><?php echo $value[1]; ?></option>
                    <?php endforeach; ?>
                </select></td>
            <?php for ($i = 0; $i < $courseCount; $i++): ?>
                <td colspan="2"><input id="course<?php echo $data[0]['CourseID'][$i]; ?>" name="course<?php echo $data[0]['CourseID'][$i]; ?>" type="input" /></td>
                <?php endfor; ?>
            <td><input type="submit" value="添加" /></td>
        </form>
        </tr>
        </tbody>
    </table>
</div>