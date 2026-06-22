<?php
// Get auth transaction id from 3DS result
$files = [
    "paymentInformation" => '../storage/paymentInformation.txt',
    "authId" => '../storage/authTransId.txt'
];
$paymentInformation = file_get_contents($files['paymentInformation']);
$paymentInformation = json_decode($paymentInformation, true);
$authTransId = file_get_contents($files['authId']);
// remove file
foreach ($files as $file) {
    if (file_exists($file)) {
        unlink($file);
    }
}

include '../validateAuthentication.php';

$response = "";
if($apiResponse) {
    $response = json_decode($apiResponse[0], true);
}

$consumerAuth = "";
$paresStatus = "";
if(isset($response["consumerAuthenticationInformation"])) {
    $paresStatus = isset($response["consumerAuthenticationInformation"]["paresStatus"]) ? $response["consumerAuthenticationInformation"]["paresStatus"] : "";
    $consumerAuth = [
        "authenticationTransactionId"   => $authTransId,
        "cavv"                          => isset($response["consumerAuthenticationInformation"]["cavv"]) ? $response["consumerAuthenticationInformation"]["cavv"] : null,
        "eciRaw"                        => isset($response["consumerAuthenticationInformation"]["eciRaw"]) ? $response["consumerAuthenticationInformation"]["eciRaw"] : null,
        "paresStatus"                   => $paresStatus,
        "xid"                           => isset($response["consumerAuthenticationInformation"]["xid"]) ? $response["consumerAuthenticationInformation"]["xid"] : null,
        "directoryServerTransactionId"  => isset($response["consumerAuthenticationInformation"]["directoryServerTransactionId"]) ? $response["consumerAuthenticationInformation"]["directoryServerTransactionId"] : null,
        "paSpecificationVersion"        => isset($response["consumerAuthenticationInformation"]["specificationVersion"]) ? $response["consumerAuthenticationInformation"]["specificationVersion"] : null,
        "acsTransactionId"              => isset($response["consumerAuthenticationInformation"]["acsTransactionId"]) ? $response["consumerAuthenticationInformation"]["acsTransactionId"] : null,
    ];
}
?>
        <tr scope="row">
            <td style="width: 90px">Validate Auth Response</td>
            <td style="max-width: 200px">
                <pre><?php echo $apiResponse[0]; ?></pre>
            </td>
        </tr>
    </tbody>
</table>
<form action="receipt.php" id="my-payerauth-form" method="post" target="_top">
    <div class="w-100 d-flex justify-content-center">
        <button type="button" id="pay-button" class="btn btn-primary" disabled>Complete Payment</button>
    </div>
    <input type="hidden" id="flexresponse" name="flexresponse">
    <input type="hidden" id="consumerAuth" name="consumerAuth">
</form>
<script>
    const payButton = document.querySelector('#pay-button');
    const flexResponse = document.querySelector('#flexresponse');
    const consumerAuth = document.querySelector('#consumerAuth');
    const form = document.querySelector('#my-payerauth-form');

    const paresStatus = '<?php echo $paresStatus; ?>';
    if(paresStatus == "Y") {
        payButton.removeAttribute("disabled");
    }

    payButton.addEventListener('click', function() {
            const token = '<?php echo json_encode($paymentInformation); ?>' ;
            const consumerAuthData = '<?php echo json_encode($consumerAuth, true); ?>' ;
            flexResponse.value = token;
            consumerAuth.value = consumerAuthData;
            form.submit();
    });
</script>
<?php
include '../templates/footer.php';
?>