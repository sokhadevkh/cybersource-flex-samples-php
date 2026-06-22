<?php
    require_once __DIR__. DIRECTORY_SEPARATOR .'vendor/autoload.php';
    require_once __DIR__. DIRECTORY_SEPARATOR .'ExternalConfiguration.php';

$apiResponse = '';
$transientTokenJWK = $paymentInformation;

	$clientReferenceInformationArr = [
			"code" => "TC50171_3"
	];
	$clientReferenceInformation = new CyberSource\Model\Ptsv2paymentsClientReferenceInformation($clientReferenceInformationArr);

	$orderInformationAmountDetailsArr = [
		"totalAmount" => "1.00",
		"currency" => "USD"
	];
	$orderInformationAmountDetails = new CyberSource\Model\Ptsv2paymentsOrderInformationAmountDetails($orderInformationAmountDetailsArr);

	$orderInformationBillToArr = [
			"firstName" => "RTS",
			"lastName" => "VDP",
			"address1" => "201 S. Division St.",
			"locality" => "Ann Arbor",
			"administrativeArea" => "MI",
			"postalCode" => "48104-2201",
			"country" => "US",
			"district" => "MI",
			"buildingNumber" => "123",
			"email" => "test@cybs.com",
			"phoneNumber" => "999999999"
	];
	$orderInformationBillTo = new CyberSource\Model\Ptsv2paymentsOrderInformationBillTo($orderInformationBillToArr);

	$orderInformationArr = [
			"amountDetails" => $orderInformationAmountDetails,
			"billTo" => $orderInformationBillTo
	];
	$orderInformation = new CyberSource\Model\Ptsv2paymentsOrderInformation($orderInformationArr);

	$consumerAuthenticationInformationArr = [
			"authenticationTransactionId" => $authTransId
	];
	
	$requestObjArr = [
			"clientReferenceInformation" => $clientReferenceInformation,
			"orderInformation" => $orderInformation,
			"consumerAuthenticationInformation" => $consumerAuthenticationInformationArr,
	];

	if(is_array($paymentInformation) && isset($paymentInformation["number"])) {
		$paymentInformationArr = [
			"card" => $paymentInformation
		];

		$requestObjArr["paymentInformation"] = $paymentInformationArr;
	} else {
		$tokenInformationArr = [
			"transientTokenJwt" => "$transientTokenJWK"
		];
		$tokenInformation = new CyberSource\Model\Ptsv2paymentsTokenInformation($tokenInformationArr);

		$requestObjArr["tokenInformation"] = $tokenInformation;
	}

	$requestObj = new CyberSource\Model\ValidateRequest($requestObjArr);
	
	$commonElement = new CyberSource\ExternalConfiguration();
	$config = $commonElement->ConnectionHost();
	$merchantConfig = $commonElement->merchantConfigObject();

	$api_client = new CyberSource\ApiClient($config, $merchantConfig);
	$api_instance = new CyberSource\Api\PayerAuthenticationApi($api_client);

	try {
		$apiResponse = $api_instance->validateAuthenticationResults($requestObj);
		//print_r(PHP_EOL);
		//print_r($apiResponse);
	} catch (Cybersource\ApiException $e) {
		print_r("<div class='text-danger position-absolute p-3 bg-white' style='top:90%; left:50%'>Transien token expired.</div>");
		// print_r($e->getResponseBody());
		// print_r($e->getMessage());
	}
?>