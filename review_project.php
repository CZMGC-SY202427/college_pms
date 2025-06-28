<?php
require_once 'functions.php';
require_login();
if(!is_teacher()) die('Access denied');

$gradeOptions = ['A+','A','A-','B+','B','B-','C+','C','C-','D','F'];

// 4.a) Process submitted feedback/grade
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $pid   = (int)$_POST['project_id'];
  $fb    = trim($_POST['feedback']);
  $grade = trim($_POST['grade']);

  $upd = mysqli_prepare($conn,
    "UPDATE projects
     SET feedback=?, status='reviewed', grade=?
     WHERE id=?"
  );
  mysqli_stmt_bind_param($upd, 'ssi', $fb, $grade, $pid);
  mysqli_stmt_execute($upd);

  // fetch student email (assuming you have an email column)
  $q = mysqli_prepare($conn,
    "SELECT u.username
     FROM projects p
     JOIN users u ON u.id = p.student_id
     WHERE p.id = ?"
  );
  mysqli_stmt_bind_param($q, 'i', $pid);
  mysqli_stmt_execute($q);
  mysqli_stmt_bind_result($q, $stu);
  mysqli_stmt_fetch($q);
  mysqli_stmt_close($q);

  $subject = "Your project #{$pid} has been reviewed";
  $message = "Hello {$stu},\n\nYour project has been reviewed.\nGrade: {$grade}\nFeedback:\n{$fb}\n\nRegards.";
  // mail() must be configured on your server
  @mail("{$stu}@example.com", $subject, $message);

  header('Location: review_project.php?' . $_SERVER['QUERY_STRING']);
  exit;
}

// 4.b) search & pagination
$search   = $_GET['search'] ?? '';
$page     = max(1, (int)($_GET['page'] ?? 1));
$perPage  = 10;
$offset   = ($page - 1) * $perPage;
$like     = "%{$search}%";

// count total
$countStmt = mysqli_prepare($conn,
  "SELECT COUNT(*)
   FROM projects p
   JOIN users u ON u.id = p.student_id
   WHERE p.title LIKE ? OR u.username LIKE ?"
);
mysqli_stmt_bind_param($countStmt, 'ss', $like, $like);
mysqli_stmt_execute($countStmt);
mysqli_stmt_bind_result($countStmt, $total);
mysqli_stmt_fetch($countStmt);
mysqli_stmt_close($countStmt);
$pages = ceil($total / $perPage);

// fetch page
$stmt = mysqli_prepare($conn,
  "SELECT p.id,p.title,p.description,p.submission_date,p.status,
          p.feedback,p.grade,p.file_path,u.username
   FROM projects p
   JOIN users u ON u.id = p.student_id
   WHERE p.title LIKE ? OR u.username LIKE ?
   ORDER BY p.submission_date DESC
   LIMIT ? OFFSET ?"
);
mysqli_stmt_bind_param($stmt, 'ssii', $like, $like, $perPage, $offset);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result(
  $stmt,
  $id, $title, $desc, $dt, $status,
  $fb, $grade, $fp, $stu
);

include 'header.php';
?>

<h2>Review Submissions</h2>

<form method="GET">
  <input name="search" placeholder="search title or student" value="<?=htmlspecialchars($search)?>">
  <button>Search</button>
</form>

<?php while(mysqli_stmt_fetch($stmt)): ?>
  <div class="project">
    <strong><?=htmlspecialchars($title)?></strong>
    by <?=htmlspecialchars($stu)?> on <?=$dt?><br>
    Status: <?=$status?> | Grade: <?=htmlspecialchars($grade)?>
    <?php if($fp): ?>
      | <a href="<?=htmlspecialchars($fp)?>" target="_blank">Attachment</a>
    <?php endif; ?>
    <p><?=nl2br(htmlspecialchars($desc))?></p>

    <form method="POST">
      <input type="hidden" name="project_id" value="<?=$id?>">
      Grade:<br>
        <select name="grade">
          <option value="">-- select grade --</option>
          <?php foreach ($gradeOptions as $opt): ?>
            <option value="<?=$opt?>" <?=($grade === $opt ? 'selected' : '')?>>
              <?=$opt?>
            </option>
          <?php endforeach; ?>
        </select>
        <br><br>

      Feedback:<br>
      <textarea name="feedback"><?=htmlspecialchars($fb)?></textarea><br>
      <button>Save & Notify</button>
    </form>
    <hr>
  </div>
<?php endwhile; ?>

<!-- pagination links -->
<div>
  <?php for($p=1; $p<=$pages; $p++): ?>
    <a href="?search=<?=urlencode($search)?>&page=<?=$p?>">
      <?=$p === $page ? "<strong>$p</strong>" : $p?>
    </a>
  <?php endfor; ?>
</div>

<?php include 'footer.php'; ?>
