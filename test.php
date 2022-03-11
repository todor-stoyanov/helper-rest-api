<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

print_r('<pre>');

require_once __DIR__ . "/RestClient.php";
require_once __DIR__ . "/HttpClient.php";

$client = new RestClient('https://imp.bg/api/web/1/');
$client->username = 'test1';
$client->password = 'test1';

//$result = $client->postData('list-object'); print_r($result);exit;
//$result = $client->postData('list-country'); print_r($result);exit;
//$result = $client->postData('list-city',['country_id'=>100]); print_r($result);exit;
//$result = $client->postData('list-city'); print_r($result);exit;

//$result = $client->postData('list-street',['city_id'=>68134]); print_r($result);exit;
//$result = $client->postData('list-street'); print_r($result);exit;

//$result = $client->postData('list-office',['city_id'=>68134]); print_r($result);exit;
//$result = $client->postData('list-office'); print_r($result);exit;

/*$bolData = [];
//$bolData['SEND_OFFICE_ID'] = 51765; // [INT 11] example for id for the senders's office from which the shipment would be sent
$bolData['COD'] = 22.30; // [NUMERIC 8,2] COD Value. 0(zero) if there is no COD. Use "."(dot) for decimals!
$bolData['INSURANCE'] = 20; // [NUMERIC 8,2] Insurance value. Use "."(dot) for decimals!
$bolData['CONTENT'] = 'резервни части'; // [VARCHAR 200] Text with information about the content
$bolData['FRAGILE'] = 1; // [INT 11] - Fragile marker 0 or 1 (1 if content is fragile)
$bolData['WEIGHT'] = 3.5; // [NUMERIC 8,3] Weight in kg. Can't be 0(zero). Use "."(dot) for decimals.
//$bolData['TAKE_OFFICE_ID'] = 44209; // [INT 11] Office ID for receiver's office, it is obtained with the listOffice Method.
$bolData['RECEIVER_NAME'] = 'ФИРМА ООД'; // [VARCHAR 150] Receiver's name.
$bolData['RECEIVER_COUNTRY'] = 100; // [INT 11] Country ID of  receiver(ISO standart). Bulgaria is 100.
$bolData['RECEIVER_CITY'] = 'СОФИЯ'; // [VARCHAR 50] City name of  receiver.
$bolData['RECEIVER_CITY_ID'] = 68134; // [INT 11] City ID of  receiver.
$bolData['RECEIVER_PK'] = '1000'; // [VARCHAR 5] Post code of receiver.
$bolData['RECEIVER_STREET'] = 'УЛ. ЧЕРКОВНА'; // [VARCHAR 50] Street name of receiver.
$bolData['RECEIVER_STREET_ID'] = 3268; // [INT 11] Street ID of receiver.
$bolData['RECEIVER_STREET_TYPE'] = 1; // [INT 11] Receiver's street type - 1 for Street 2 for Neighborhood
$bolData['RECEIVER_STREET_NO'] = '33А'; // [VARCHAR 5] Receiver's street number used if STREETB_TYPE is set to 1
$bolData['RECEIVER_BLOCK'] = ''; // [VARCHAR 5] Receiver's block number used if STREETB_TYPE is set to 2
$bolData['RECEIVER_ENTRANCE'] = 'А'; // [VARCHAR 3] Receiver's entrance number
$bolData['RECEIVER_FLOOR'] =  '4'; // [VARCHAR 10]  Receiver's floor
$bolData['RECEIVER_APARTMENT'] = '45'; // [VARCHAR 3] Receiver's apartment number
$bolData['RECEIVER_ADDITIONAL_INFO'] = ''; // [VARCHAR 250] Receiver's additional information for delivery
$bolData['RECEIVER_PHONE'] = '35920000000'; // [VARCHAR 40] Receiver's phone
$bolData['RECEIVER_CONTACT_PERSON'] = 'ИВАН ИВАНОВ'; // [VARCHAR 100] Contact person for receiver
$bolData['FIX_HOUR'] = 'ТОЧНО:14:30'; // [VARCHAR 40]  fixed hour delivery service
$bolData['RETURN_RECEIPT'] = 1; // [INT 11] Return receipt
$bolData['RETURN_DOCUMENTS'] = 0; // [INT 11] Return documents
$bolData['PACK_COUNT'] = 1; // [INT 11] Pack or pallet count. If not set Default value is 1.
$bolData['SATURDAY_DELIVERY'] = 0; // [INT 11] Saturday delivery.
$bolData['CHECK_BEFORE_PAY'] = 0; // [INT 11] Check content on delivery,  before pay.
$bolData['CLIENT_REFERENCE'] = '456454534'; //[VARCHAR 30] Client reference ID.
$result = $client->postData('create-bol',$bolData); print_r($result);exit;*/

//$result = $client->postData('print-bol',['bol_id'=>'15749394']); print_r($result);exit;
//$result = $client->postData('print-bol',['bol_id'=>'9101330192','by_reference'=>1]); print_r($result);exit;

//$result = $client->postData('cancel-bol',['bol_id'=>'15749394']); print_r($result);exit;
//$result = $client->postData('cancel-bol',['bol_id'=>'9101330192','by_reference'=>1]); print_r($result);exit;

//$result = $client->postData('request-courier',['count'=>1,'weight'=>2,'readiness'=>'15:30']); print_r($result);exit;

//$result = $client->postData('track-bol',['bol_id'=>'15749394']); print_r($result);exit;
//$result = $client->postData('track-bol',['bol_id'=>'9101330192','by_reference'=>1]); print_r($result);exit;
//$result = $client->postData('track-bol',['bol_id'=>'456454534','by_reference'=>2]); print_r($result);exit;

//$result = $client->postData('track-bols',['bols_id'=>['15749394']]); print_r($result);exit;
//$result = $client->postData('track-bols',['bols_id'=>['9101330192'],'by_reference'=>1]); print_r($result);exit;
//$result = $client->postData('track-bols',['bols_id'=>['456454534'],'by_reference'=>2]); print_r($result);exit;

//$result = $client->postData('track-request',['request_id'=>'15449780']); print_r($result);exit;

//$result = $client->postData('list-all-status',['from_date'=>'2022-03-07 00:00:00','to_date'=>'2022-03-11 23:59:59']); print_r($result);exit;

//$result = $client->postData('list-return-redirect',['from_date'=>'2022-03-01 00:00:00','to_date'=>'2022-03-11 23:59:59']); print_r($result);exit;

//$result = $client->postData('bol-finance-info',['bol_id'=>'15749394']); print_r($result);exit;
//$result = $client->postData('bol-finance-info',['bol_id'=>'9101032936','by_reference'=>1]); print_r($result);exit;

//$result = $client->postData('bol-info',['bol_id'=>'15749394']); print_r($result);exit;
//$result = $client->postData('bol-info',['bol_id'=>'9101330192','by_reference'=>1]); print_r($result);exit;

//$result = $client->postData('list-cod-order',['from_date'=>'2022-03-01 00:00:00','to_date'=>'2022-03-11 23:59:59']); print_r($result);exit;

//$result = $client->postData('info-cod-order',['order_id'=>'123456']); print_r($result);exit;

//$result = $client->postData('info-cod-order-detailed',['order_id'=>'123456']); print_r($result);exit;

//$result = $client->postData('list-invoice',['from_date'=>'2022-03-01 00:00:00','to_date'=>'2022-03-11 23:59:59']); print_r($result);exit;

/*$bolData = array();
$bolData['FIX_HOUR'] = 0;
$bolData['RETURN_RECEIPT'] = 0;
$bolData['RETURN_DOCUMENTS'] = 0;
$bolData['COD'] = 50;
$bolData['INSURANCE'] = 50;
$bolData['WEIGHT'] = 2.5;
$bolData['RECEIVER_COUNTRY'] = 100;
$bolData['RECEIVER_CITY_ID'] = 68134;
$result = $client->postData('calculate-bol',$bolData); print_r($result);exit;*/