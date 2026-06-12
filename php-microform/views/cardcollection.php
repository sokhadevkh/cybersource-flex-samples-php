<?php 
$arrDump = json_decode($_POST["flexresponse"], true);
$formatCard = [];
if(is_array($arrDump) && isset($arrDump["number"])) {
    $arrDump["number"] = str_replace(' ', '', $arrDump["number"]);
    $pan = $arrDump["number"];
    $formatCard = [
        "number" => substr($pan, 0, 6) . '******' . substr($pan, -4),
        "expirationMonth" => $arrDump["expirationMonth"],
        "expirationYear" => $arrDump["expirationYear"],
        "securityCode" => "***"
    ];
}
include '../templates/header.php';
?>
<div class="container card">
    <div class="card-body">
            <form action="payerauth.php" id="my-token-form" method="post">
            <h1>Token</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Key</th>
                        <th scope="col">value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($formatCard) && isset($formatCard["number"])): ?>
                    <tr scope="row">
                        <td>Card Data</td>
                        <td>
                            <pre class="form-control">
                                <?php echo json_encode($formatCard, JSON_PRETTY_PRINT); ?>
                            </pre>
                        </td>
                    </tr>
                    <?php else: ?>
                    <tr scope="row">
                        <td>Transient Token</td>
                        <td>
                            <textarea class="form-control" rows="6">
                                <?php echo json_encode($arrDump); ?>
                            </textarea>
                        </td>
                    </tr>
                    
                    <?php endif; ?>
                </tbody>
            </table>

            <button type="button" id="pay-button" class="btn btn-primary">Make Payment</button>
            <input type="hidden" id="flexresponse" name="flexresponse">
        </form>
    </div>
</div>
<script>
    var payButton = document.querySelector('#pay-button');
    var flexResponse = document.querySelector('#flexresponse');
    var form = document.querySelector('#my-token-form');

    payButton.addEventListener('click', function() {  
            
            var token = '<?php echo json_encode($arrDump); ?>' ;
            flexResponse.value = token;
            form.submit();
    });
</script>

<?php
include '../templates/footer.php';
?>