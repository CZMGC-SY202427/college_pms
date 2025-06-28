<?php
require_once 'config.php';

function is_logged_in() {
  return isset($_SESSION['user']);
}

function require_login() {
  if (!is_logged_in()) {
    header('Location: login.php');
    exit;
  }
}

function current_user() {
  return $_SESSION['user'] ?? null;
}

function is_teacher() {
  return is_logged_in() && $_SESSION['user']['role'] === 'teacher';
}

function is_student() {
  return is_logged_in() && $_SESSION['user']['role'] === 'student';
}
?>