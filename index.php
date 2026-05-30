<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Пассажиры.РФ</title>
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/slider.css">
</head>
<body>

<div class="header">
  <div class="nav">
    <a href="index.php" class="logo">Пассажиры.РФ</a>
    
    <?php if(!isset($_SESSION['user_id'])): ?>
      <div class="nav-buttons">
        <a href="login.php" class="btn-login">Войти</a>
        <a href="register.php" class="btn-register">Регистрация</a>
      </div>
  
    <?php elseif($_SESSION['admin']): ?>
    
      <?php if(isset($_GET['index'])) { 
        session_destroy(); 
        header('Location:index.php'); 
        exit;}?>
      <div class="nav-buttons">
        <a href="admin.php" class="btn-admin">Панель администратора</a>
        <a href="?index=1" class="btn-exit">Выход</a>
      </div>
   
    <?php else: ?>
      <div class="nav-buttons">
        <a href="history.php" class="btn-lk">Мои заявки</a>
        <a href="create.php" class="btn-create">Новая заявка</a>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="slideshow-container">
  <div class="mySlides fade">
    <img src="foto 1.png" style="width:100%">
    <div class="text">Слайд 1</div>
  </div>
  <div class="mySlides fade">
    <img src="foto 2.jpg" style="width:100%">
    <div class="text">Слайд 2</div>
  </div>
  <div class="mySlides fade">
    <img src="foto 3.jpg" style="width:100%">
    <div class="text">Слайд 3</div>
  </div>
  <div class="mySlides fade">
    <img src="foto 4.jpg" style="width:100%">
    <div class="text">Слайд 4</div>
  </div>
  
  <a class="prev" onclick="plusSlides(-1)">❮</a>
  <a class="next" onclick="plusSlides(1)">❯</a>
</div>
<div class="dot-container">
  <span class="dot active" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
  <span class="dot" onclick="currentSlide(4)"></span>
</div>
<script src='script/script.js'></script>
</body>
</html>