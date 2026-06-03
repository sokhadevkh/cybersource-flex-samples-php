<?php

$transientToken = json_decode($_POST["flexresponse"], true);;
include 'paymentWithFlexTransientToken.php';

?>
<html lang="en">
    <head>
        <title>Receipt</title>
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
    
    <body>
    <nav class="w-100 py-3 bg-primary mb-5" style="padding-left: 8rem">
        <img width="150" src="public/src/images/aba-web-logo.png" alt="aba_logo">
    </nav>
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
    </body>
</html>