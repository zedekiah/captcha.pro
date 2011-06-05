<div class="standart api">
    <h1>API 0.1</h1>
    <h2>Клиентская часть</h2>
    <textarea cols="100" rows="10">

    Подключите эти скрипты на странице с капчей (в head):
    <script type="text/javascript" src="http://procaptcha/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="http://procaptcha/js/getProCaptcha.js"></script>

    Не забудьте про таблицу стилей (в head):
    <link rel="stylesheet" type="text/css" media="screen" href="http://procaptcha/css/procaptcha-default.css">

    А в форму добавьте следующий блок, в котором и будет отображаться капча (в body):
    <div id="procaptcha_container"></div>
    </textarea>
    <h2>Серверная часть</h2>
    <textarea cols="100" rows="8">
    Подключите (или скачайте) скрипт:
    include('http://procaptcha/verification.php');

    Используйте следующую функцию для верификации:
    $hash = $_POST["captcha_hash"];
    $word = $_POST["captcha_word"];
    procaptcha_verify($hash, $word); // Возвращает true, если капча пройдена успешно.
    </textarea>
</div>
