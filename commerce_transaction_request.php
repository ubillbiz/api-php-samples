<?php
require_once 'functions.php';

/** @var int $projectId ID проекта мобильной коммерции */
$projectId = 1001;
/** @var string $secretKey Секретный ключ проекта */
$secretKey = 'secretkey';


$params = array(
    'project_id' => $projectId,
    'price' => 20, // Сумма транзакции
    'phone' => '79221111111', // Номер абонента
    'description' => 'Платеж по заказу #00001', // описание заказа
    'success_message' => 'Спасибо за покупку', // сообщение, отправляемое абоненту, в случае успешного завершения оплаты
);

// генерируем подпись запроса
$params['signature'] = generateSignature($params, $secretKey);

$result = sendRequest(API_HOST . '/commerce/request', $params);
if (is_string($result)) {
    // Произошла ошибка
    echo "Ошибка:  " . $result;
} else {
    // ID созданной транзакции
    $transactionId = $result['transaction_id'];
    echo $transactionId;
}
