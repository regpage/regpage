<?php
$curl = curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_POST,true);
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode(['request' => $data]));
curl_setopt($curl,CURLOPT_HEADER,false);

$out=curl_exec($curl);
$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
curl_close($curl);

$answer = json_decode($out, true);
