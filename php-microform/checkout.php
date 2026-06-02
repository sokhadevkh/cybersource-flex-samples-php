<?php
//header("Content-Security-Policy: script-src 'self' 'unsafe-inline'; object-src 'none'; base-uri 'none'; require-trusted-types-for 'script';");
include 'generatekey.php';

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Sample Checkout</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css" integrity="sha512-NZ19NrT58XPK5sXqXnnvtf9T5kLXSzGQlVZL9taZWeTBtXoN3xIfTdxbkQh6QSoJfJgpojRqMfhyqBAAEeiXcA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/js/bootstrap.min.js" integrity="sha512-Pv/SmxhkTB6tWGQWDa6gHgJpfBdIpyUy59QkbshS1948GRmj6WgZz18PaDMOqaEyKLRAvgil7sx/WACNGE4Txw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <style>
            #number-container, #securityCode-container {
                height: 38px;
            }

            .flex-microform-focused {
                background-color: #fff;
                border-color: #80bdff;
                outline: 0;
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
            }
            .fw-semibold {
              font-weight: 600 !important;
            }
        </style>
    </head>

    <div class="container card">
      <div class="card-body">
        <div class="payment-summary mb-5 fw-semibold">
          <h4 class="mb-3">Payment Summary</h4>
          <div class="row g-3">
            <div class="col-6 text-start">Sub Total</div>
            <div class="col-6 text-end">$1.00</div>
            <div class="col-12 m-0">
              <hr class="mb-0">
            </div>
            <div class="col-6 text-start">Total</div>
            <div class="col-6 text-end">$1.00</div>
          </div>
        </div>

        <div class="billing-info">
          <h4 class="mb-3">Billing Information</h4>
            <form class="row g-3" method="post">
                <div class="col-md-6">
                    <label for="first_name" class="fw-semibold fs-6 mb-1">First Name</label>
                    <input id="first_name" class="form-control" name="first_name" value="John">
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="fw-semibold fs-6 mb-1">Last Name</label>
                    <input id="last_name" class="form-control" name="last_name" value="Doe">
                </div>
                <div class="col-md-12">
                    <label for="address" class="fw-semibold fs-6 mb-1">Address</label>
                    <input id="address" class="form-control" name="address" value="Las Vegas, NV 89169">
                </div>
                <div class="col-md-6">
                    <label for="city" class="fw-semibold fs-6 mb-1">City</label>
                    <input id="city" class="form-control" name="city" value="Las Vegas">
                </div>
                <div class="col-md-6">
                    <label for="country" class="fw-semibold fs-6 mb-1">Country</label>
                    <input id="country" class="form-control" name="country" value="US">
                </div>

                <div class="col-md-12 mt-4">
                  <!-- Button trigger modal -->
                  <button id="checkout-btn" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                    Checkout
                  </button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <div class="payment-form">
      <!-- Modal -->
      <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content" style="width: 25rem; border-radius: 12px">
            <div class="modal-header">
              <h5 class="modal-title" id="paymentModalLabel">Credit / Debit Card</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="errors-output" role="alert"></div>
                    <form action="token.php" id="my-sample-form" class="row g-3" method="post">
                        <div class="col-md-12">
                            <label for="cardholderName" class="fw-semibold fs-6 mb-1">Name</label>
                            <input id="cardholderName" class="form-control" name="cardholderName" placeholder="Name on the card">
                        </div>
                        <div class="col-md-12">
                            <label id="cardNumber-label" class="fw-semibold fs-6 mb-1">Card Number <span class="text-danger">*</span></label>
                            <input id="number-container" class="form-control bg-transparent" readonly placeholder="0000 0000 0000 0000"></input>
                        </div>

                        <div class="col-md-6">
                            <label for="expDate" class="fw-semibold fs-6 mb-1">Expiry Date <span class="text-danger">*</span></label>
                            <input id="expDate" class="form-control" placeholder="MM / YY"></input>
                        </div>
                        <div class="col-md-6">
                            <label for="securityCode-container" class="fw-semibold fs-6 mb-1">Security Code <span class="text-danger">*</span></label>
                            <input id="securityCode-container" class="form-control bg-transparent" readonly placeholder="000"></input>
                        </div>
                        <div class="col-md-12 mt-4">
                          <hr>
                        </div>
                        <div class="col-md-12 mt-0 fw-semibold d-flex justify-content-between">
                          <div class="text-start">You're about to Pay:</div>
                          <div class="text-end">$1.00</div>
                        </div>
                        <div class="col-md-12 mt-3">
                          <input type="hidden" id="flexresponse" name="flexresponse">
                          <button type="button" id="pay-button" form="myForm" class="btn btn-primary w-100">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
    // Set up Cleave inputs
    new Cleave('#number-container', {
        creditCard: true
    });
    new Cleave('#expDate', {
        date: true,
        datePattern: ['m', 'y'],
        delimiter: '/',
        blocks: [2, 2],
        numericOnly: true,
    });
    new Cleave('#securityCode-container', {
        numericOnly: true,
        blocks: [3]
    });
  </script>

  <script>
            var checkoutBtn = document.querySelector('#checkout-btn');
            checkoutBtn.addEventListener('click', function() {
              // JWK is set up on the server side route for /
              var form = document.querySelector('#my-sample-form');
              var payButton = document.querySelector('#pay-button');
              var flexResponse = document.querySelector('#flexresponse');
              var expDate = document.querySelector('#expDate');
              var errorsOutput = document.querySelector('#errors-output');
            
              // the capture context that was requested server-side for this transaction
              var captureContext = '<?php echo $captureContext; ?>' ;
              var clientLibrary = '<?php echo $clientLibrary; ?>' ;
              var clientLibraryIntegrity = '<?php echo $clientLibraryIntegrity; ?>' ;
              console.log(captureContext);
  
              const script = document.createElement('script');
              script.type = 'text/javascript';
              script.async = true;
              script.onload = function() {
                // Invoke the Flex SDK once the scripts are loaded asynchronously
                flexSetup();
              }
              //url extracted from the JWT
              script.src = clientLibrary;
              //integrity extracted from the JWT
              if (clientLibraryIntegrity) {
                script.integrity = clientLibraryIntegrity;
                script.crossOrigin = "anonymous";
              }
              document.head.appendChild(script);
              // custom styles that will be applied to each field we create using Microform
              var myStyles = {  
                'input': {    
                  'font-size': '14px',    
                  'font-family': 'helvetica, tahoma, calibri, sans-serif',    
                  'color': '#555'  
                },  
                ':focus': { 'color': 'blue' },  
                ':disabled': { 'cursor': 'not-allowed' },  
                'valid': { 'color': '#3c763d' },  
                'invalid': { 'color': '#a94442' }
              };
  
              function flexSetup() {
                // setup
                var flex = new Flex(captureContext);
                var microform = flex.microform({ styles: myStyles });
                var number = microform.createField('number', { placeholder: '0000 0000 0000 0000' });
                var securityCode = microform.createField('securityCode', { placeholder: '000' });
  
                number.load('#number-container');
                securityCode.load('#securityCode-container');
  
                payButton.addEventListener('click', function() {  
                  var expArr = expDate.value?.split("/");
                  var expirationMonth = expArr[0];
                  var expirationYear = `20${expArr[1]}`;
                  var options = {    
                    expirationMonth: expirationMonth,  
                    expirationYear: expirationYear 
                  };
  
                  microform.createToken(options, function (err, token) {
                    if (err) {
                      // handle error
                      console.error(err);
                      errorsOutput.textContent = err.message;
                    } else {
                      // At this point you may pass the token back to your server as you wish.
                      // In this example we append a hidden input to the form and submit it.      
                      console.log(JSON.stringify(token));
                      flexResponse.value = JSON.stringify(token);
                      form.submit();
                    }
                  });
                }); 
              }
            });
        </script>
    </body>
</html>