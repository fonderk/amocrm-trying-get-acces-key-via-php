<?php
$subdomain = 'ilkaskyrim'; //Поддомен нужного аккаунта
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

/** Соберем данные для запроса */
$data = [
    'client_id' => '',
    'client_secret' => '',
    'grant_type' => 'authorization_code',
    'code' => 'def502007406275c9c14f3f6ec02a3f4b1c1d5a437175ada03689697bfa494ff9081cafbb2e3880189b9793163ca09b83efea80a6c42ef8ab752980c7d087e636d0ec153338250450d1bf3fa37934db1064e1e998f7097f3e0ff9012b65de47f2df490d02b02165f240cb68f163dd80a585e3a87b331f19f938ce1daffee4bfe5a73391f220ac7b8953a683c09eeec24f79557f0f4c581788f5d460793a3f00d526476ab9d2401f24011ba5c4b3435e51f41caa906ff0decc64d11f6f2e7ed88537c37023ca474f65ab27f63fe3ef1f256a47f38dc4f33f8a3834f7862d73a71c1d4420583e10396fb62398cc6e503acacb30e1e8eddf283ce2e954d227577a7c276bbbe39e8c9f62cf19c36578b20857c1c669c97a5a691d461ccd46e32a9e896ff3c560dcb2824d959e386da6838497191528c2a71bb5a32497b9943305f423068240f1fa7acd0426f5ca05a4e60ea91522d89e4005fe7715a3334c8816a5156d9b9fc6ea3d598f86f7977f465e629c9d6489092b46b1dc7e8d0033d6745c4181274506df3573c91b33716a3e64364c6e99f87730c57a2070c4eb0b22df29a38a67ec444a03f5fb4913a802f57143fec9e1407c08546dfcf7fcde695222475d5',
    'redirect_uri' => 'https://www.google.ru/',
];

/**
 * Нам необходимо инициировать запрос к серверу.
 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
 */
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
/**
$code = (int)$code;

$errors = [
400 => 'Bad request',
401 => 'Unauthorized',
403 => 'Forbidden',
404 => 'Not found',
500 => 'Internal server error',
502 => 'Bad gateway',
503 => 'Service unavailable',
];
 */


/*
try
{


    if ($code < 200 || $code > 204) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
    }
}
catch(\Exception $e)
{
    die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
}
*/
/**
 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
 * нам придётся перевести ответ в формат, понятный PHP
 */
$response = json_decode($out, true);

$access_token = $response['access_token']; //Access токен
$refresh_token = $response['refresh_token']; //Refresh токен
$token_type = $response['token_type']; //Тип токена
$expires_in = $response['expires_in'];

echo $access_token;
echo $response;