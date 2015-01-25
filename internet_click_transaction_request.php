<?php
require_once 'functions.php';

/** @var int $projectId ID Internet-Click проекта */
$projectId = 1001;
/** @var string $secretKey Секретный ключ проекта */
$secretKey = 'secretkey';


$params = array(
    'project_id' => $projectId,
    'price' => 50, // Сумма транзакции
    'landing' => 1001, // ID лэндинга, на который будет направлен абонент, уточняйте у менеджера
);

// генерируем подпись запроса
$params['signature'] = generateSignature($params, $secretKey);

$result = sendRequest(API_HOST . '/internet-click', $params);
if (is_string($result)) {
    // Произошла ошибка
    echo "Ошибка:  " . $result;
} else {
    // Ссылка для перенаправления
    $redirectUrl = $result['redirect_url'];
    echo $redirectUrl;
}
