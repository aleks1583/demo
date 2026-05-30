<?php
include('db.php');
session_start();

if(!$_SESSION['admin']) die('Чтобы посмотреть панель администратора, надо войти в его аккаунт.');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	echo "Заявка {$_POST['request_id']} обновлена.<br><br>";

	$query = $con->query("UPDATE requests SET status='{$_POST['status']}', admin_message='{$_POST['admin_message']}' WHERE id={$_POST['request_id']}");
	if(!$query) die('update error: ' . $con->error);
}

// JOIN-запрос
$query = $con->query("SELECT requests.*, users.login, users.fullname FROM requests INNER JOIN users WHERE requests.user_id = users.id");
if(!$query) die('query error: ' . $con->error);

$i = 0;
while($request = $query->fetch_assoc()) {
	$i++;

	// Нет защиты от XSS
	echo "
	<h1>Админ панель</h1>
	<h2>Заявка $i от {$request['login']}</h2>

	<b>ФИО: </b>{$request['fullname']}<br>
	<b>Контактные данные: </b>{$request['contacts']}<br>
	<b>Водительское: </b>{$request['license']}<br>

	<b>Адрес: </b>{$request['address']}<br>
	<b>Дата: </b>{$request['date']}<br>
	<b>Вид услуги: </b>{$request['service']}<br>
	<b>Тип оплаты: </b>{$request['payment']}<br>

	<form action='' method='POST'>
		<input type='hidden' name='request_id' value='{$request['id']}'>
		<select name='status'>
			<option " . ($request['status'] == 'одобрено' ? 'selected' : '') . " value='одобрено'>одобрено</option>
			<option " . ($request['status'] == 'выполнено' ? 'selected' : '') . " value='выполнено'>выполнено</option>
			<option " . ($request['status'] == 'отклонено' ? 'selected' : '') . " value='отклонено'>отклонено</option>
		</select>
		<input name='admin_message' placeholder='Сообщение админа' value='{$request['admin_message']}'>

		<button type='submit'>Сохранить</button>
	</form>
	<hr>";
}
?>