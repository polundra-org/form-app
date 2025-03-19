<?php

require_once __DIR__ . '/Requests.php';

$email = $_GET['email'];
$csvPath = getenv('CSV_PATH');

$requests = new Requests($csvPath);
$req = $requests->read($email);

$fullName = $req[0] . ' ' . $req[1];

?>
<html>
<head>
    <title>request info</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<p>
<?php
    if ($_GET['new']) {
        echo "$fullName, Ваши данные сохранены. Запрос на подтверждение отправлен на почту: $email";
    } else {
        echo "$fullName, Вы уже зарегестрированы. Ваша почта: $email";
    }
?>
</p>
<a href="/" class="max-w-sm mx-auto m-40" color='red'>
    Create new request
</a>
</body>
</html>
