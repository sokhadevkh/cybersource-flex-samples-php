<html lang="en">
    <head>
        <title>Token</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css" integrity="sha512-usVBAd66/NpVNfBge19gws2j6JZinnca12rAe2l+d+QkLU9fiG02O1X8Q6hepIpr/EYKZvKx/I9WsnujJuOmBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script async="async" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.min.js" integrity="sha512-a6ctI6w1kg3J4dSjknHj3aWLEbjitAXAjLDRUxo2wyYmDFRcz2RJuQr5M3Kt8O/TtUSp8n2rAyaXYy1sjoKmrQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="public/src/css/global.css"/>
        <style>
            .td-1 {
                word-break: break-all;
                word-wrap: break-word;
            }
        </style>
    </head>
    <?php $arrDump = json_decode($_POST["flexresponse"], true);?>
    <body>
    <nav class="w-100 py-3 bg-primary mb-5" style="padding-left: 8rem">
        <img width="150" src="public/src/images/aba-web-logo.png" alt="aba_logo">
    </nav>
        <div class="container card">
            <div class="card-body">
                 <form action="receipt.php" id="my-token-form" method="post">
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

    </body>
</html>