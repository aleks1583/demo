<?php
session_start();
if(!isset($_SESSION['user_id'])) die('Чтобы оставить заявку, надо войти в аккаунт.');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$address = $_POST['address'];
	$contacts = $_POST['contacts'];
	$license = $_POST['license'];
	$date = $_POST['date'];
	$service = $_POST['service'];
	$payment = $_POST['payment'];

	include('db.php');

	$query = $con->query("INSERT INTO requests (address, contacts, license, date, service, payment, user_id) VALUES ('$address', '$contacts', '$license', '$date', '$service', '$payment', '{$_SESSION['user_id']}')"); // SQL-инъекция / чтобы понять КТО оставил заявку, нам нужен $_SESSION['user_id'] - это  foreign key
	if(!$query) die('query error: ' . $con->error);

	header('Location: history.php');
}
?>

<h1>Создание заявки</h1>
<form action="" method="POST">
	<input required size="50" type="text" name="address" placeholder="Адрес"><br>
	<input required size="50" type="text" name="contacts" placeholder="Контактные данные"><br>
	<input required size="50" type="text" name="license" placeholder="Водительское удостоверение (серия, номер, дата выдачи)"><br>
	<input required size="50" type="datetime-local" name="date"><br>

	<select required name="service">
		<option value="Лада ГРАНТА седан">Лада ГРАНТА седан</option>
		<option value="Лада ГРАНТА универсал">Лада ГРАНТА универсал</option>
		<option value="НИВА-Легенда">НИВА-Легенда</option>
		<option value="НИВА 4x4">НИВА 4x4</option>
		<option value="УАЗ Патриот">УАЗ Патриот</option>
		<option value="УАЗ Буханка">УАЗ Буханка</option>
		<option value="Москвич">Москвич</option>
	</select>
	<br>

	<select required name="payment">
		<option value="наличные">наличные</option>
		<option value="банковская карта">банковская карта</option>
	</select>
	<br>

	<button>Оставить заявку</button>
</form>