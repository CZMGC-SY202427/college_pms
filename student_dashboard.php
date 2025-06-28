<?php
require_once 'functions.php';
require_login();
if(!is_student()) die('Access denied');
include 'header.php';
?>

<h2>Student Dashboard</h2>
<p><a href="submit_project.php">Submit New Project</a></p>
<p><a href="view_my_projects.php">View My Submissions</a></p>

<?php include 'footer.php'; ?>