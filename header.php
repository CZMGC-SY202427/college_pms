<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Project Tracker</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav>
  <?php if(is_logged_in()): ?>
    Hello, <?=htmlspecialchars($_SESSION['user']['username'])?> |
    <a href="logout.php">Logout</a> |
    <?php if(is_student()): ?>
      <a href="student_dashboard.php">My Dashboard</a>
    <?php else: ?>
      <a href="teacher_dashboard.php">Teacher Dashboard</a>
    <?php endif; ?>
  <?php else: ?>
    <a href="login.php">Login</a> |
    <a href="register.php">Register</a>
  <?php endif; ?>
</nav>
<hr>