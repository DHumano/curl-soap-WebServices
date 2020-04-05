<?php



function soap(){
    $WSDL = 'http://www.nanonull.com/TimeService/TimeService.asmx?WSDL';
$client = new SoapClient($WSDL);
// $response = $client->getUTCTime(); // WORKS

$response = $client->getTimeZoneTime(array('timezone'=>'zulu')); //works
print_r( $response);
echo "<br>";
}

soap();


function curl(){
    $params='<?xml version="1.0"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"
        soap:encodingStyle="http://www.w3.org/2003/05/soap-encoding">
            <soap:Body>
                <getUTCTime></getUTCTime>
            </soap:Body>
        </soap:Envelope>';

    $headers = [
        "Content-type: text/xml",
        "Content-length: " . strlen($params), "Connection: close",
        "SOAPAction: http://www.Nanonull.com/TimeService/getUTCTime"
    ];
    
    $params='<?xml version="1.0"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
                <getTimeZoneTime xmlns="http://www.Nanonull.com/TimeService/">
                <timezone>ZULU</timezone>
                </getTimeZoneTime>
            </soap:Body>
        </soap:Envelope>';

    $headers = [
        "Content-type: text/xml",
        "Content-length: " . strlen($params), "Connection: close",
        "SOAPAction: http://www.Nanonull.com/TimeService/getTimeZoneTime"
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.nanonull.com/TimeService/TimeService.asmx?WSDL");
    curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    
    curl_close($ch);    
    echo($output); 
}

curl();

    // $xml = new SimpleXMLElement('<ResolveIP/>');
    // $params=to_xml($xml, [ "ipAddress" => '210.45.151.101', "licenseKey" => "0" ])->asXML();
function to_xml(SimpleXMLElement $object, array $data)
{   
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $new_object = $object->addChild($key);
            to_xml($new_object, $value);
        } else {
            // if the key is an integer, it needs text with it to actually work.
            if ($key == (int) $key) {
                $key = "key_$key";
            }

            $object->addChild($key, $value);
        }   
    }   
    return $object;
}   

