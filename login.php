<?php
require_once 'functions.php';
if(is_logged_in()) header('Location: ' . (is_student() ? 'student_dashboard.php' : 'teacher_dashboard.php'));

$err='';
if($_SERVER['REQUEST_METHOD']==='POST') {
  $u = $_POST['username'];
  $p = $_POST['password'];

  $q = mysqli_prepare($conn, "SELECT id,username,password,role FROM users WHERE username=?");
  mysqli_stmt_bind_param($q,'s',$u);
  mysqli_stmt_execute($q);
  mysqli_stmt_bind_result($q,$id,$user,$hash,$role);
  if(mysqli_stmt_fetch($q) && password_verify($p,$hash)) {
    $_SESSION['user'] = [
      'id'=>$id, 'username'=>$user, 'role'=>$role
    ];
    header('Location: ' . ($role==='student' ? 'student_dashboard.php' : 'teacher_dashboard.php'));
    exit;
  } else {
    $err = 'Invalid credentials';
  }
}
include 'header.php';
?>

<h2>Login</h2>
<?php if($err): ?><p class="error"><?=htmlspecialchars($err)?></p><?php endif; ?>
<form method="POST">
  Username:<br><input name="username"><br>
  Password:<br><input type="password" name="password"><br><br>
  <button>Login</button>
</form>

<?php include 'footer.php'; ?>