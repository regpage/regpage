<?php
$wsdlurl = 'https://tracking.russianpost.ru/rtm34?wsdl';
$client2 = '';

$client2 = new SoapClient($wsdlurl, array('trace' => 1, 'soap_version' => SOAP_1_2));

$params3 = array ('OperationHistoryRequest' => array ('Barcode' => '80088561298582', 'MessageType' => '0','Language' => 'RUS'),
				  'AuthorizationHeader' => array ('login'=>'PhUOdFAsZwiQeO','password'=>'5GRHRg4YW1e5'));

$result = $client2->getOperationHistory(new SoapParam($params3,'OperationHistoryRequest'));

foreach ($result->OperationHistoryData->historyRecord as $record) {
	printf("<p>%s </br>  %s, %s</p>",
	$record->OperationParameters->OperDate,
	$record->AddressParameters->OperationAddress->Description,
	$record->OperationParameters->OperAttr->Name);
};
?>
