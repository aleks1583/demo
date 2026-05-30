<?php
session_start();
// Проверяем, авторизован ли пользователь
if(!isset($_SESSION['user_id'])) die('Чтобы посмотреть историю заявок, надо войти в аккаунт.');
include('db.php'); // Подключаемся к базе данных
// Обрабатываем отправку отзыва
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Обновляем отзыв в базе данных
    $con->query("UPDATE request SET review='{$_POST['review']}' WHERE id='{$_POST['request_id']}' AND user_id='{$_SESSION['user_id']}'");
}
// Получаем все заявки текущего пользователя
$query = $con->query("SELECT * FROM request WHERE user_id='{$_SESSION['user_id']}'");
if(!$query) die('query error: ' . $con->error); // Если ошибка запроса - показываем её
?>
<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <!-- Шапка сайта -->
    <div class="header">
        <div class="nav">
            <a href="index.php" class="logo">Пассажиры.РФ</a>    
            <!-- Меню навигации -->
            <div class="nav-buttons">
                <a href="history.php" class="btn-active">Мои заявки</a>
                <a href="create.php" class="btn-create">Новая заявка</a>
            </div>
        </div>
    </div>
    <!-- Основной контент -->
    <div class="container">
        <div class="booking-card">
        <a href="?index=1" class="btn-exit">Выйти</a>
            <div class="booking-header"><h1>История заявок</h1></div>
            <?php $i = 0; // Счетчик заявок
            // Показываем все заявки пользователя
            while($request = $query->fetch_assoc()) {
                $i++; // Увеличиваем счетчик
                echo    "<div class='request-card'>
                        <h2 style='text-align:center'>Заявка $i</h2>
                        <!-- Основная информация о заявке -->
                        <b>Дата начала: </b>{$request['date']} 
                        <b>Вид услуги: </b>{$request['curses']}
                        <b>Тип оплаты: </b>{$request['payment']} 
                        <b>Статус: </b>{$request['status']}<br>";
                // Если отзыв уже есть - показываем его
                if(!empty($request['review'])) {
                    echo "<b>Ваш отзыв: </b>{$request['review']}";}
                // Если обучение завершено - показываем форму для отзыва
                if($request['status'] === 'Обучение завершено') {
                    echo    "<form method='POST'>
                            <b>Оставить отзыв</b>
                            <!-- Скрытое поле с ID заявки для обработки формы -->
                            <input type='hidden' name='request_id' value='{$request['id']}'>
                            <!-- Поле для ввода отзыва -->
                            <input name='review' placeholder='Отзыв об услуге' value='{$request['review']}'>
                            <button class='btn-sub'>Оставить отзыв</button>
                            </form>";}
                echo "</div>";
            }
            // Если заявок нет - показываем сообщение
            if($i === 0) {echo "<div class='request-card'><p>У вас пока нет заявок</p></div>";}?>
        </div>
        <?php if(isset($_GET['index'])) {// Обработка выхода 
            session_destroy(); // Уничтожаем сессию
            header('Location:index.php'); // Перенаправляем на главную
            exit;}
        ?>
    </div>
</body>
</html>