<?php
$paymentInformation = json_decode($_POST["flexresponse"], true);
include '../payerAuthentication.php';
include '../templates/header.php';

$response = "";
if($apiResponse) {
    $response = json_decode($apiResponse[0], true);
}
$accessToken = "";
$deviceDataCollectionUrl = "";
$referenceId = "";
if(isset($response["consumerAuthenticationInformation"]["accessToken"])) {
    $accessToken = $response["consumerAuthenticationInformation"]["accessToken"];
    $deviceDataCollectionUrl = $response["consumerAuthenticationInformation"]["deviceDataCollectionUrl"];
    $referenceId = $response["consumerAuthenticationInformation"]["referenceId"];
}
?>
<div class="container card">
    <div class="card-body">
        <form action="checkauth.php" id="my-payerauth-form" method="post">
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
                    <tr scope="row">
                        <td>Device Data Collection Status</td>
                        <td>
                            <pre id="collection-status">Processing</pre>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            
            <button type="button" id="pay-button" class="btn btn-primary" hidden>Check 3DS Authentication</button>
            <input type="hidden" id="flexresponse" name="flexresponse">
            <input type="hidden" id="sessionId" name="sessionId">
        </form>
        <iframe
            id="collectionIframe"
            title="Device Data Collection"
            width="100%"
            height="0"
        ></iframe>
    </div>
</div>
<script>
    const collectionStatus = document.querySelector("#collection-status");

    window.addEventListener("message", function (event) {
        if (event.origin == "https://centinelapistag.cardinalcommerce.com") {
            console.log("Message received:", event.data);
            const json = JSON.parse(event.data);
            collectionStatus.textContent = JSON.stringify(json, null, 2);
            let btn = document.querySelector('#pay-button');
            btn.removeAttribute("hidden");
        }
    });

    window.onload = () => {
        handleDataCollectiveProcess();
    };

    function handleDataCollectiveProcess() {
        const el = document.getElementById("collectionIframe");
        if (!el) {
            alert("Unable to find iframe!");
            collectionStatus.textContent = "Failed";
            return;
        }
        collectionIframe.value = el;
        const doc = el.contentDocument;
        if (!doc) {
            alert("Iframe is not accessible!");
            collectionStatus.textContent = "Failed";
            return;
        }

        doc.open();
        doc.write(`
            <form id="cardinal_collection_form" action="<?php echo $deviceDataCollectionUrl; ?>" method="POST">
            <input id="cardinal_collection_form_input" type="hidden" name="JWT" value="<?php echo $accessToken; ?>" />
            <input type="submit" value="Submit" />
            </form>
        `);
        doc.close();

        const form = doc.getElementById("cardinal_collection_form");
        if (form) {
            form.submit();
            console.log("Form Submit");
        } else {
            alert("Form not found in iframe!");
            collectionStatus.textContent = "Failed";
        }
    }
</script>
<script>
    const payButton = document.querySelector('#pay-button');
    const flexResponse = document.querySelector('#flexresponse');
    const sessionId = document.querySelector('#sessionId');
    const form = document.querySelector('#my-payerauth-form');

    payButton.addEventListener('click', function() {
            const token = '<?php echo json_encode($paymentInformation); ?>' ;
            const referenceId = '<?php echo $referenceId; ?>' ;
            flexResponse.value = token;
            sessionId.value = referenceId;
            form.submit();
    });
</script>
<?php
include '../templates/footer.php';
?>