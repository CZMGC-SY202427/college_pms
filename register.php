<?php
require_once 'functions.php';
if(is_logged_in()) header('Location: login.php');

$err = '';
if($_SERVER['REQUEST_METHOD']==='POST') {
  $u = trim($_POST['username']);
  $p = $_POST['password'];
  $r = $_POST['role'] === 'teacher' ? 'teacher' : 'student';
  if($u === '' || $p === '') {
    $err = 'All fields required';
  } else {
    // check exist
    $q = mysqli_prepare($conn, "SELECT id FROM users WHERE username=?");
    mysqli_stmt_bind_param($q,'s',$u);
    mysqli_stmt_execute($q);
    mysqli_stmt_store_result($q);
    if(mysqli_stmt_num_rows($q) > 0) {
      $err = 'Username taken';
    } else {
      $hash = password_hash($p, PASSWORD_DEFAULT);
      $i = mysqli_prepare($conn,
        "INSERT INTO users(username,password,role) VALUES(?,?,?)");
      mysqli_stmt_bind_param($i,'sss',$u,$hash,$r);
      mysqli_stmt_execute($i);
      header('Location: login.php');
      exit;
    }
  }
}
include 'header.php';
?>

<h2>Register</h2>
<?php if($err): ?><p class="error"><?=htmlspecialchars($err)?></p><?php endif; ?>
<form method="POST">
  Username:<br>
  <input name="username"><br>
  Password:<br>
  <input type="password" name="password"><br>
  Role:<br>
  <select name="role">
    <option value="student">Student</option>
    <option value="teacher">Teacher</option>
  </select><br><br>
  <button type="submit">Register</button>
</form>

<?php include 'footer.php'; ?>