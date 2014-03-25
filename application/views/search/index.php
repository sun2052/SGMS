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
    <table  class="dataTable" summary="成绩查询">
        <caption>成绩查询</caption>
        <thead>
            <tr>
                <th rowspan="2">学号</th>
                <th rowspan="2">姓名</th>
                <?php for ($i = 0; $i < $courseCount; $i++): ?>
                    <th colspan="2"><?php echo $data[0]['CourseName'][$i]; ?></th>
                <?php endfor; ?>
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>