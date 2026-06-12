<?php
$paymentInformation = json_decode($_POST["flexresponse"], true);
$consumerAuth = json_decode($_POST["consumerAuth"] ?? null, true);

include '../paymentAuthorization.php';
include '../templates/header.php';
?>
<div class="container card">
    <div class="card-body">
        <h1>Receipt</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Key</th>
                    <th scope="col">value</th>
                </tr>
            </thead>
            <tbody>
                <tr scope="row">
                    <td>PaymentResponse</td>
                    <td id="responseJson">
                        <pre><?php echo $apiResponse[0]; ?></pre>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="checkout.php" class="btn btn-primary">Repeat checkout process</a>
    </div>
</div>

<?php
include '../templates/footer.php';
?>