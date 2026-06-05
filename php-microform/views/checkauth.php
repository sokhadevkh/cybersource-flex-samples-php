<?php
// save token into storage
$transientToken = json_decode($_POST["flexresponse"], true);
$sessionId = $_POST["sessionId"];
include '../checkAuthentication.php';
include '../templates/header.php';

$response = "";
if($apiResponse) {
    $response = json_decode($apiResponse[0], true);
}

$stepUpUrl = "";
$accessToken = "";
$paresStatus = "";
$status = isset($response["status"]) ? $response["status"] : "Failed";
if(isset($response["consumerAuthenticationInformation"]["accessToken"])) {
    $stepUpUrl = $response["consumerAuthenticationInformation"]["stepUpUrl"];
    $accessToken = $response["consumerAuthenticationInformation"]["accessToken"];
    $paresStatus = $response["consumerAuthenticationInformation"]["paresStatus"];
}
?>
<div class="container card">
    <div class="card-body">
        <h1>Check Authentication</h1>
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
                    <td>Authentication Status</td>
                    <td>
                        <pre id="auth-status"><?php echo $status; ?></pre>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-start gap-2">
            <button 
                type="button" id="render-3ds-button"
                class="btn btn-secondary" hidden 
                data-bs-toggle="modal"
                data-bs-target="#paymentModal">
                Manually Render 3DS
            </button>
            <form action="validateauth.php" id="my-cres-form" method="post" hidden>
                <button type="button" id="validate-button" class="btn btn-secondary">Validate 3DS Result</button>
                <input type="hidden" id="cres-flexresponse" name="flexresponse"">
            </form>
            <form action="receipt.php" id="my-frictionless-form" method="post" hidden>
                <button type="button" id="frictionless-button" class="btn btn-primary">Pay (Frictionless)</button>
                <input type="hidden" id="frictionless-flexresponse" name="flexresponse"">
            </form>
            <form action="receipt.php" id="my-payment-form" method="post">
                <button type="button" id="pay-button" class="btn btn-primary">Pay (Non3DS)</button>
                <input type="hidden" id="flexresponse" name="flexresponse"">
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div
    class="modal fade"
    id="paymentModal"
    tabindex="-1"
    aria-labelledby="paymentModalLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    style="overflow-y: hidden;"
>
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="width: 32rem; border-radius: 12px">
        <div class="modal-body p-0">
            <div class="text-end w-100 px-3 pt-3">
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <iframe
                id="threeDSFrame"
                title="3DS Authentication Frame"
                width="100%"
                height="720"
                style="border: none"
            ></iframe>
        </div>
    </div>
    </div>
</div>
<script>
    const authStatus = document.querySelector("#auth-status");
    window.addEventListener("message", function (event) {
        if (event.origin == "https://centinelapistag.cardinalcommerce.com") {
            console.log("Message received:", event.data);
            authStatus.textContent = event.data;
        }
    });

    const status = '<?php echo $status; ?>';
    const paresStatus = '<?php echo $paresStatus; ?>';
    window.onload = () => {
        if(status == "AUTHENTICATION_SUCCESSFUL") {
            let formPayFrictionless = document.querySelector('#my-frictionless-form');
            formPayFrictionless.removeAttribute("hidden");
        } else if(paresStatus == "C") {
            const render3DS = document.querySelector("#render-3ds-button");
            const validateForm = document.querySelector("#my-cres-form");
            render3DS.removeAttribute("hidden");
            validateForm.removeAttribute("hidden");
            handleProcess3DS();
        }
    }
    function handleProcess3DS() {
        const el = document.getElementById("threeDSFrame");
        if (!el) {
            alert("Unable to find iframe!");
            authStatus.textContent = "Failed";
            return;
        }
        threeDSFrame.value = el;
        const doc = el.contentDocument;
        if (!doc) {
            alert("Iframe is not accessible!");
            authStatus.textContent = "Failed";
            return;
        }

        doc.open();
        doc.write(`
            <form id="process3DS" action="<?php echo $stepUpUrl; ?>" method="POST">
                <input id="cardinal_collection_form_input" type="hidden" name="JWT" value="<?php echo $accessToken; ?>" />
                <input type="submit" value="Process 3DS" />
            </form>
        `);
        doc.close();

        const form = doc.getElementById("process3DS");
        if (form) {
            form.submit();
            console.log("Form Submit");
        } else {
            alert("Form not found in iframe!");
            authStatus.textContent = "Failed";
        }
    }
</script>
<script>
    const payButton = document.querySelector('#pay-button');
    const validateButton = document.querySelector('#validate-button');
    const frictionlessButton = document.querySelector('#frictionless-button');

    const flexResponse = document.querySelector('#flexresponse');
    const CresflexResponse = document.querySelector('#cres-flexresponse');
    const FrictflexResponse = document.querySelector('#frictionless-flexresponse');

    const formPay = document.querySelector('#my-payment-form');
    const formPayFrictionless = document.querySelector('#my-frictionless-form');
    const formCres = document.querySelector('#my-cres-form');

    payButton.addEventListener('click', function() {
        const token = '<?php echo $transientToken; ?>' ;
        console.log(JSON.stringify(token));
        flexResponse.value = JSON.stringify(token);
        formPay.submit();
    });

    frictionlessButton.addEventListener('click', function() {
        const token = '<?php echo $transientToken; ?>' ;
        console.log(JSON.stringify(token));
        FrictflexResponse.value = JSON.stringify(token);
        formPayFrictionless.submit();
    });

    validateButton.addEventListener('click', function() {
        const token = '<?php echo $transientToken; ?>' ;
        console.log(JSON.stringify(token));
        CresflexResponse.value = JSON.stringify(token);
        formCres.submit();
    });
</script>
<?php
include '../templates/footer.php';
?>