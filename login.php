<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$login = $_POST['login'];
	$password = $_POST['password'];

	include('db.php');

	$query = $con->query("SELECT * FROM users WHERE login='$login' AND password='$password'"); // SQL-инъекция
	if(!$query) die('query error: ' . $con->error);

	$user = $query->fetch_assoc();
	if(!$user) die('Неверный логин или пароль');

	session_start(); // Нет защиты от Session fixation атаки
	$_SESSION['user_id'] = $user['id'];
	$_SESSION['admin'] = $user['login'] == 'avto2024';

	header('Location: history.php');
}
?>

<h1>Логин</h1>
<form action="" method="POST">
	<input type="text" name="login" placeholder="Логин"><br>
	<input type="password" name="password" placeholder="Пароль"><br>
	<button>Войти</button>
</form>