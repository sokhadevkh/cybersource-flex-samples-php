<?php
    require_once __DIR__. DIRECTORY_SEPARATOR .'vendor/autoload.php';
    require_once __DIR__. DIRECTORY_SEPARATOR .'ExternalConfiguration.php';

$apiResponse = '';
$transientTokenJWK = $transientToken;

	$clientReferenceInformationArr = [
			"code" => "TC50171_3"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);


	$tokenInformationArr = [
			"transientTokenJwt" => "$transientTokenJWK"
    ];
	$tokenInformation = new CyberSource\Model\Ptsv2paymentsTokenInformation($tokenInformationArr);

	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"tokenInformation" => $tokenInformation
	];
	$requestObj = new CyberSource\Model\PayerAuthSetupRequest($requestObjArr);


	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);

	try {
		$apiResponse = $api_instance->payerAuthSetup($requestObj);
		//print_r(PHP_EOL);
		//print_r($apiResponse);


	} catch (Cybersource\ApiException $e) {
		print_r("<div class='text-danger position-absolute p-3 bg-white' style='top:90%; left:50%'>Transien token expired.</div>");
		// print_r($e->getResponseBody());
		// print_r($e->getMessage());
	}

?>