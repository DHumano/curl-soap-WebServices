<?php

function soap()
{
    $url = "http://ws.cdyne.com/ip2geo/ip2geo.asmx?wsdl";
    try {
        $client = new SoapClient($url, [ "trace" => 1 ] );
        $result = $client->ResolveIP( [ "ipAddress" => '210.45.151.101', "licenseKey" => "0" ] );
        var_dump($result);
    } catch ( SoapFault $e ) {
        echo $e->getMessage();
    }
    echo PHP_EOL;
}   

// soap();

function curl(){
    
    $params='<?xml version="1.0"?>
        <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
                <ResolveIP xmlns="http://ws.cdyne.com/">
                <ipAddress>210.45.151.101</ipAddress>
                <licenseKey>0</licenseKey>
                </ResolveIP>
            </soap:Body>
        </soap:Envelope>';

    $headers = [
        "Content-type: text/xml",
        "Content-length: " . strlen($params), "Connection: close",
        "SOAPAction: http://ws.cdyne.com/ResolveIP"
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ws.cdyne.com/ip2geo/ip2geo.asmx?wsdl");
    curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    
    curl_close($ch);    
    echo($output); 
}

curl();