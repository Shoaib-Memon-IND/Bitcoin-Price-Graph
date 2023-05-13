<?php

$apiKey = '29366e8f-d165-48fb-94c2-e36c5b79d456';

$symbols = $_POST['symbol'];
$convert = $_POST['convert'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?symbol=' . $symbols . '&convert=' . $convert,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json',
    'X-CMC_PRO_API_KEY: ' . $apiKey
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo 'cURL Error #:' . $err;
} else {
  echo $response;
}

?>
