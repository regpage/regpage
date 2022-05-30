<?php
$request =
 '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pos="http://fclient.russianpost.org/postserver" xmlns:fcl="http://fclient.russianpost.org">
  <soapenv:Header/>
  <soapenv:Body>
     <pos:ticketRequest>
        <request>
           <fcl:Item Barcode="80088561298582"/>
           <fcl:Item Barcode="19776260002754"/>
           <fcl:Item Barcode="10307055021019"/>
        </request>
        <login>PhUOdFAsZwiQeO</login>
        <password>5GRHRg4YW1e5</password>
        <language>RUS</language>
     </pos:ticketRequest>
  </soapenv:Body>
</soapenv:Envelope>';

$client = new SoapClient("https://tracking.russianpost.ru/fc?wsdl",  array('trace' => 1, 'soap_version' => SOAP_1_1));

echo '<textarea rows="30" cols="70">'.$client->__doRequest($request, "https://tracking.russianpost.ru/fc", "getTicket", SOAP_1_1).'</textarea>';
?>
