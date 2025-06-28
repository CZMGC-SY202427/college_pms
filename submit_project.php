<?php
require_once 'functions.php';
require_login();
if(!is_student()) die('Access denied');

$err = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  $t = trim($_POST['title']);
  $d = trim($_POST['description']);

  // handle file upload
  $filePath = null;
  if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $tmp  = $_FILES['attachment']['tmp_name'];
    $name = basename($_FILES['attachment']['name']);
    $ext  = pathinfo($name, PATHINFO_EXTENSION);
    $new  = 'uploads/' . uniqid('proj_') . '.' . $ext;
    if(!move_uploaded_file($tmp, $new)) {
      $err = 'Failed to save attachment.';
    } else {
      $filePath = $new;
    }
  }

  if($t === '') {
    $err = 'Title required';
  }

  if(!$err) {
    $ins = mysqli_prepare($conn,
      "INSERT INTO projects(student_id,title,description,file_path)
       VALUES(?,?,?,?)"
    );
    mysqli_stmt_bind_param($ins, 'isss',
      $_SESSION['user']['id'], $t, $d, $filePath);
    mysqli_stmt_execute($ins);
    header('Location: view_my_projects.php');
    exit;
  }
}

include 'header.php';
?>

<h2>Submit Project</h2>
<?php if($err): ?><p class="error"><?=htmlspecialchars($err)?></p><?php endif; ?>
<form method="POST" enctype="multipart/form-data">
  Title:<br>
  <input name="title"><br><br>

  Description:<br>
  <textarea name="description"></textarea><br><br>

  Attachment (pdf/zip/...):<br>
  <input type="file" name="attachment"><br><br>

  <button>Submit</button>
</form>

<?php include 'footer.php'; ?>
