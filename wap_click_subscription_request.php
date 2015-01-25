<?php
require_once 'functions.php';

/** @var int $projectId ID WAP-Click проекта */
$projectId = 1001;
/** @var string $secretKey Секретный ключ проекта */
$secretKey = 'secretkey';
/** @var string $projectSubType Подтип WAP-Click проекта, указан на странице редактирования проекта */
$projectSubType = 'A';


$params = array(
    'project_id' => $projectId,
);

switch ($projectSubType) {
    case 'A':
        $params['traffic_source_id'] = 1001; // ID одобренного источника трафика
        $params['return_url'] = 'http://ubill.biz'; // url адрес, куда необходимо перенаправить абонента после завершения действия
        break;
    case 'B':
        $params['landing'] = 1001; // ID лэндинга, на который будет направлен абонент, уточняйте у менеджера
        break;
    default:
        echo "Неизвестный подтип проекта.";
        die();
        break;
}

// генерируем подпись запроса
$params['signature'] = generateSignature($params, $secretKey);

$result = sendRequest(API_HOST . '/wap-click/subscribe', $params);
if (is_string($result)) {
    // Произошла ошибка
    echo "Ошибка:  " . $result;
} else {
    // Ссылка для перенаправления
    $redirectUrl = $result['redirect_url'];
    echo $redirectUrl;
}
