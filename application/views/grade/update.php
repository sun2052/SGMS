<?php
$courseCount = intval(array_pop($data));
$data = $data[0];
//var_dump($courseCount,$data);
?>
<div id="content">
    <table  class="dataTable" summary="成绩管理">
        <caption>成绩管理</caption>
        <thead>
            <tr>
                <th rowspan="2">学号</th>
                <th rowspan="2">姓名</th>
                <?php for ($i = 0; $i < $courseCount; $i++): ?>
                    <th colspan="2"><?php echo $data['CourseName'][$i]; ?></th>
                <?php endfor; ?>
                <th rowspan="2">操作</th>
            </tr>

            <tr>
                <?php for ($i = 0; $i < $courseCount; $i++): ?>
                    <th colspan="2">成绩</th>
                <?php endfor; ?>
            </tr>

        </thead>
        <tbody>
            <tr>
        <form id="updategrade" method="post" action="<?php echo WEB_FOLDER; ?>grade/update/<?php echo $data['StudentID']; ?>" enctype="multipart/form-data">
            <td><?php echo $data['StudentNumber']; ?></td>
            <td><?php echo $data['StudentName']; ?></td>
            <?php for ($i = 0; $i < $courseCount; $i++): ?>
                <td colspan="2"><input id="course<?php echo $data['CourseID'][$i]; ?>" name="course<?php echo $data['CourseID'][$i]; ?>" type="input" value="<?php echo $data['Grade'][$i]; ?>" /></td>
                <?php endfor; ?>
            <td><input type="submit" value="保存" /></td>
        </form>
        </tr>
        </tbody>
    </table>
</div>