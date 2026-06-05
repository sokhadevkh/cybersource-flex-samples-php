<?php 
$arrDump = json_decode($_POST["flexresponse"], true);
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
                    <tr scope="row">
                        <td>Transient Token</td>
                        <td>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6">
                                <?php echo $arrDump; ?>
                            </textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" id="pay-button" class="btn btn-primary">Make a Payment with Transient Token</button>
            <input type="hidden" id="flexresponse" name="flexresponse">
        </form>
    </div>
</div>
<script>
    var payButton = document.querySelector('#pay-button');
    var flexResponse = document.querySelector('#flexresponse');
    var form = document.querySelector('#my-token-form');

    payButton.addEventListener('click', function() {  
            
            var token = '<?php echo $arrDump; ?>' ;
            console.log(JSON.stringify(token));
            flexResponse.value = JSON.stringify(token);
            form.submit();
    });
</script>

<?php
include '../templates/footer.php';
?>