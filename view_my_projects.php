<?php
require_once 'functions.php';
require_login();
if(!is_student()) die('Access denied');

$userId = $_SESSION['user']['id'];
$stmt = mysqli_prepare($conn,
  "SELECT id,title,submission_date,status,feedback,grade,file_path
   FROM projects
   WHERE student_id=?
   ORDER BY submission_date DESC"
);
mysqli_stmt_bind_param($stmt, 'i', $userId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result(
  $stmt, $id, $title, $dt, $status, $fb, $grade, $fp
);

include 'header.php';
?>

<h2>My Submissions</h2>
<table border="1" cellpadding="4">
  <tr>
    <th>Title</th>
    <th>Date</th>
    <th>Status</th>
    <th>Grade</th>
    <th>Feedback</th>
    <th>Attachment</th>
  </tr>
  <?php while(mysqli_stmt_fetch($stmt)): ?>
    <tr>
      <td><?=htmlspecialchars($title)?></td>
      <td><?=$dt?></td>
      <td><?=$status?></td>
      <td><?=htmlspecialchars($grade)?></td>
      <td><?=nl2br(htmlspecialchars($fb))?></td>
      <td>
        <?php if($fp): ?>
          <a href="<?=htmlspecialchars($fp)?>" target="_blank">Download</a>
        <?php else: ?>
          &mdash;
        <?php endif; ?>
      </td>
    </tr>
  <?php endwhile; ?>
</table>

<?php include 'footer.php'; ?>
