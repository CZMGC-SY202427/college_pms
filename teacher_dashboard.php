<?php
require_once 'functions.php';
require_login();
if(!is_teacher()) die('Access denied');
include 'header.php';
?>

<h2>Teacher Dashboard</h2>
<p><a href="review_project.php">Review All Submissions</a></p>

<?php include 'footer.php'; ?>
