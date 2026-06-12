<?php
$paymentInformation = json_decode($_POST["flexresponse"], true);

// Get auth transaction id from 3DS result
$file = '../storage/authTransId.txt';
$authTransId = file_get_contents($file);
// remove file
if (file_exists($file)) {
    unlink($file);
}

include '../validateAuthentication.php';
include '../templates/header.php';

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
<div class="container card">
    <div class="card-body">
        <form action="receipt.php" id="my-payerauth-form" method="post">
            <h1>Payer Authentication Setup</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Key</th>
                        <th scope="col">value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr scope="row">
                        <td>API Response</td>
                        <td style="max-width: 200px">
                            <pre><?php echo $apiResponse[0]; ?></pre>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            
            <button type="button" id="pay-button" class="btn btn-primary" hidden>Pay with Transient Token</button>
            <input type="hidden" id="flexresponse" name="flexresponse">
            <input type="hidden" id="consumerAuth" name="consumerAuth">
        </form>
    </div>
</div>
<script>
    const payButton = document.querySelector('#pay-button');
    const flexResponse = document.querySelector('#flexresponse');
    const consumerAuth = document.querySelector('#consumerAuth');
    const form = document.querySelector('#my-payerauth-form');

    window.onload = () => {
        const paresStatus = '<?php echo $paresStatus; ?>';
        if(paresStatus == "Y") {
            payButton.removeAttribute("hidden");
        }
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