<?php
$request =
 '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pos="http://fclient.russianpost.org/postserver">
  <soapenv:Header/>
  <soapenv:Body>
     <pos:answerByTicketRequest>
        <ticket></ticket>
        <login>PhUOdFAsZwiQeO</login>
        <password>5GRHRg4YW1e5</password>
     </pos:answerByTicketRequest>
  </soapenv:Body>
</soapenv:Envelope>';

$client = new SoapClient("https://tracking.russianpost.ru/fc?wsdl",  array('trace' => 1, 'soap_version' => SOAP_1_1));

echo '<textarea rows="30" cols="50">'.$client->__doRequest($request, "https://tracking.russianpost.ru/fc", "getResponseByTicket", SOAP_1_1).'</textarea>';
?>
