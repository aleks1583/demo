<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Пассажирам.РФ</title>
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/slider.css">
</head>
<body>
<!-- Шапка сайта -->
<div class="header">
  <div class="nav">
    <a href="index.php" class="logo">Пассажирам.РФ</a>
    <!-- Кнопки для неавторизованных -->
    <?php if(!isset($_SESSION['user_id'])): ?>
      <div class="nav-buttons">
        <a href="login.php" class="btn-login">Войти</a>
        <a href="register.php" class="btn-register">Регистрация</a>
      </div>
    <!-- Кнопки для администратора -->
    <?php elseif($_SESSION['admin']): ?>
      <!-- Обработка кнопки выхода -->
      <?php if(isset($_GET['index'])) { 
        session_destroy(); 
        header('Location:index.php'); 
        exit;}?>
      <div class="nav-buttons">
        <a href="admin.php" class="btn-admin">Панель администратора</a>
        <a href="?index=1" class="btn-exit">Выход</a>
      </div>
    <!-- Кнопки для обычных пользователей -->
    <?php else: ?>
      <div class="nav-buttons">
        <a href="history.php" class="btn-lk">Мои заявки</a>
        <a href="create.php" class="btn-create">Новая заявка</a>
      </div>
    <?php endif; ?>
  </div>
</div>

<script src='script/script.js'></script>
</body>
</html>