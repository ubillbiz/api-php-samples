<?php

CONST API_HOST = 'http://api.ubill.biz';

/**
 * Функция генерации подписи запроса
 * @param array $params Параметры запроса
 * @param string $secretKey Секретный ключ
 * @return string Подпись запроса
 */
function generateSignature(array $params, $secretKey)
{
    unset($params['signature']);
    ksort($params);
    $signature = implode(':', $params) . ':' . $secretKey;

    return md5($signature);
}

/**
 * Функция отправки запроса
 * @param string $url Адрес, на который нужно отправить запрос
 * @param array $params Параметры запроса
 * @return string|array Результат запроса, массив с данными в случае успеха, сообщение об ошибке в случае неудачи
 */
function sendRequest($url, array $params)
{
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $result = curl_exec($ch);

        if ($result === false) {
            $return = curl_error($ch);
        } else {
            $result = json_decode($result, true);
            if ($result === false) {
                $return = "Неверный ответ от сервера.";
            } else {
                if ($result['success']) {
                    $return = $result['data'];
                } else {
                    $return = $result['message'];
                }
            }
        }
        curl_close($ch);
        return $return;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}
