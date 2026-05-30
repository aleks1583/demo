<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$login = $_POST['login'];
	$password = $_POST['password'];
	$fullname = $_POST['fullname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];

	include('db.php');

	// Жалкая подобия валидации (нельзя использовать функцию empty, потому что empty('0') возвращает true)
	if($login == '') die('Логин не может быть пуст');
	if($password == '') die('Пароль не может быть пуст');
	if($fullname == '') die('ФИО не может быть пустым');
	if($phone == '') die('Телефон не может быть пуст');
	if($email == '') die('Email не может быть пуст');

	// Хеширования паролей нет
	$query = $con->query("INSERT INTO users (login, password, fullname, phone, email) VALUES ('$login', '$password', '$fullname', '$phone', '$email')"); // SQL-инъекция | обрати внимание на порядок полей!
	if(!$query) die('query error: ' . $con->error); // [необязательно] Проверка синтаксических ошибок или ошибок в данных (например, слишком длинная строка)

	header('Location: login.php');
}
?>

<h1>Регистрация</h1>

<!-- Нужно ставить required, чтобы поля стали обязательными для заполнения -->
<form action="" method="POST">
	<input required type="text" name="login" placeholder="Логин"><br>
	<input required type="password" name="password" placeholder="Пароль" minlength="6"><br>
	<input required type="text" name="fullname" placeholder="ФИО" pattern="[А-Яа-я ]+"><br>
	<input required type="tel" name="phone" placeholder="Телефон" pattern="\+7\(\d\d\d\)-\d\d\d-\d\d-\d\d"><br>
	<input required type="email" name="email" placeholder="Email"><br>
	<button>Зарегистрироваться</button>
</form>