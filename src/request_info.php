<?php

require_once __DIR__ . '/Requests.php';

define('OK_LOGO', '../img/ok_logo.png');
define('WARNING_LOGO','../img/warning_logo.png');
define('EMESSAGE_NO_EMAIL','Bad request. Email not transferred');
define('EMESSAGE_BAD_EMAIL','Bad request. User not found');

$csvPath = getenv('CSV_PATH');

if (!empty($_GET['email'])) {
    $email = $_GET['email'];
    $requests = new Requests($csvPath);
    $req = $requests->read($email);

    if (!empty($req)) {
        if ($req[3] > 1) {
            $new = false;
        } else {
            $new = true;
        }
    } else {
        $eMessage = EMESSAGE_BAD_EMAIL;
    }
} else {
    $eMessage = EMESSAGE_NO_EMAIL;
}

$fullName = $req[0] . ' ' . $req[1];
?>
<html>
<head>
    <title>Request info</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-96 p-4 m-auto mt-40">
        <div>
            <img class="size-16 m-auto" src="<?php echo $new ? OK_LOGO : WARNING_LOGO;?>" alt="-" />
        </div>
        <div class="mt-4 mb-6">
            <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                <?php
                if (!empty($eMessage)) {
                    echo $eMessage;
                } else {
                    if ($new) {
                        echo "$fullName, Ваши данные сохранены. Запрос на подтверждение отправлен на почту: $email";
                    } else {
                        echo "$fullName, Вы уже зарегестрированы. Ваша почта: $email";
                    }
                }
                ?>
            </p>
        </div>
        <div>
            <a href="/">
                <input type="button" value="Create new request" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"/>
            </a>
        </div>
    </div>
</body>
</html>
