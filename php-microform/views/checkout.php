<?php
//header("Content-Security-Policy: script-src 'self' 'unsafe-inline'; object-src 'none'; base-uri 'none'; require-trusted-types-for 'script';");
include '../generatekey.php';
include '../templates/header.php';
?>

    <div class="container card">
      <div class="card-body row">
        <div class="col-8">
          <div class="payment-summary mb-5 fw-semibold">
            <h4 class="mb-3">Payment Summary</h4>
            <div class="row g-3">
              <div class="col-6 text-start">Sub Total</div>
              <div class="col-6 text-end">$1.00</div>
              <div class="col-12 m-0">
                <hr class="mb-0" />
              </div>
              <div class="col-6 text-start">Total</div>
              <div class="col-6 text-end">$1.00</div>
            </div>
          </div>

          <div class="billing-info">
            <h4 class="mb-3">Billing Information</h4>
            <form class="row g-3" method="post">
              <div class="col-md-6">
                <label for="first_name" class="fw-semibold fs-6 mb-1"
                  >First Name</label
                >
                <input
                  id="first_name"
                  class="form-control"
                  name="first_name"
                  value="John"
                />
              </div>
              <div class="col-md-6">
                <label for="last_name" class="fw-semibold fs-6 mb-1"
                  >Last Name</label
                >
                <input
                  id="last_name"
                  class="form-control"
                  name="last_name"
                  value="Doe"
                />
              </div>
              <div class="col-md-12">
                <label for="address" class="fw-semibold fs-6 mb-1">Address</label>
                <input
                  id="address"
                  class="form-control"
                  name="address"
                  value="Las Vegas, NV 89169"
                />
              </div>
              <div class="col-md-6">
                <label for="city" class="fw-semibold fs-6 mb-1">City</label>
                <input
                  id="city"
                  class="form-control"
                  name="city"
                  value="Las Vegas"
                />
              </div>
              <div class="col-md-6">
                <label for="country" class="fw-semibold fs-6 mb-1">Country</label>
                <input
                  id="country"
                  class="form-control"
                  name="country"
                  value="US"
                />
              </div>
            </form>
          </div>
        </div>
        <div class="col-4" style="border-left: 1px solid rgba(0, 0, 0, .125)">
            <div class="mb-4">
              <h4 class="mb-3">Payment Methods</h4>
              <div class="row g-3">
                <div class="col-md-12">
                  <input
                    id="payment_method"
                    type="radio"
                    name="payment_method"
                    checked
                  />
                  <label for="payment_method" class="fs-6 mb-1">
                    <img src="../public/src/images/payment_sc.svg" alt="credit_cards">
                    <span>Card Payment</span>
                  </label>
                </div>
              </div>
            </div>
            <div>
              <h4 class="mb-3">Payment Types</h4>
              <div class="row g-3">
                <div class="col-md-12">
                  <input
                    id="flex_microform"
                    type="radio"
                    name="payment_type"
                    value="flex_microform"
                    checked
                  />
                  <label for="flex_microform" class="fs-6 mb-1">
                    <span>Flex Microform Checkout</span>
                  </label>
                </div>
                <div class="col-md-12">
                  <input
                    id="rest_api"
                    type="radio"
                    name="payment_type"
                    value="rest_api"
                  />
                  <label for="rest_api" class="fs-6 mb-1">
                    <span>RestAPI / DirectAPI Checkout</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-md-12 mt-4">
              <!-- Button trigger modal -->
              <button
                id="checkout-btn"
                type="button"
                class="btn btn-primary btn-lg"
                data-bs-toggle="modal"
                data-bs-target="#paymentModal"
              >
                Place Order
              </button>
            </div>
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
        <div class="modal-content" style="width: 25rem; border-radius: 12px">
          <div class="modal-header">
            <h5 class="modal-title" id="paymentModalLabel">
              Credit / Debit Card
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form
              action="cardcollection.php"
              id="my-sample-form"
              class="row g-3"
              method="post"
            >
              <div id="errors-output" role="alert" class="text-danger"></div>
            
              <div class="col-md-12">
                <label for="cardholderName" class="fw-semibold fs-6 mb-1"
                  >Name</label
                >
                <input
                  id="cardholderName"
                  class="form-control"
                  name="cardholderName"
                  placeholder="Name on the card"
                />
              </div>
              <div class="col-md-12">
                <label id="cardNumber-label" class="d-flex justify-content-between fw-semibold fs-6 mb-1"
                  ><span>Card Number <span class="text-danger">*</span></span>
                  <div class="position-relative">
                    <img
                      src="../public/src/images/payment_sc.svg"
                      alt="icon"
                    />
                    <span class="position-absolute end-0 me-3" style="top: 140%">
                      <img id="card-detection" src="../public/src/images/credit-card.svg" alt="card" style="width: 35px" />
                    </span>
                  </div>
                </label>
                <div
                  id="number-container"
                  class="form-control bg-transparent"
                  placeholder="0000 0000 0000 0000"
                ></div>
              </div>

              <div class="col-md-6">
                <label for="expDate" class="fw-semibold fs-6 mb-1"
                  >Expiry Date <span class="text-danger">*</span></label
                >
                <input id="expDate" class="form-control" placeholder="MM / YY" required/>
              </div>
              <div class="col-md-6 position-relative">
                <label for="securityCode-container" class="fw-semibold fs-6 mb-1"
                  >Security Code <span class="text-danger">*</span></label
                >
                <div
                  id="securityCode-container"
                  class="form-control bg-transparent"
                  placeholder="***"
                ></div>
                <span class="position-absolute end-0 top-50 me-3"
                  ><img src="../public/src/images/cvv.svg" alt="CVV icon" />
                </span>
              </div>
              <div class="col-md-12 mt-4">
                <hr />
              </div>
              <div
                class="col-md-12 mt-0 fw-semibold d-flex justify-content-between"
              >
                <div class="text-start">You're about to Pay:</div>
                <div class="text-end">$1.00</div>
              </div>
              <div class="col-md-12 mt-3">
                <input type="hidden" id="flexresponse" name="flexresponse" />
                <button
                  type="button"
                  id="pay-button"
                  form="myForm"
                  class="btn btn-primary w-100"
                >
                  Pay
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      var checkoutBtn = document.querySelector("#checkout-btn");
      var form = document.querySelector("#my-sample-form");
      var payButton = document.querySelector("#pay-button");
      var flexResponse = document.querySelector("#flexresponse");
      var expDate = document.querySelector("#expDate");
      var errorsOutput = document.querySelector("#errors-output");

      checkoutBtn.addEventListener("click", function () {
        var paymentType = document.querySelector('input[name="payment_type"]:checked');
        setupFormModal(paymentType.value);
        if(paymentType.value === "rest_api") {
          loadRest();
        } else {
          setupFlex();
        }
      });
      
      // Setup Flex
      function setupFlex() {
        // the capture context that was requested server-side for this transaction
        var captureContext = "<?php echo $captureContext; ?>";
        var clientLibrary = "<?php echo $clientLibrary; ?>";
        var clientLibraryIntegrity = "<?php echo $clientLibraryIntegrity; ?>";
        console.log(captureContext);

        const script = document.createElement("script");
        script.type = "text/javascript";
        script.async = true;
        script.onload = function () {
          // Invoke the Flex SDK once the scripts are loaded asynchronously
          loadFlex(captureContext);
        };
        //url extracted from the JWT
        script.src = clientLibrary;
        //integrity extracted from the JWT
        if (clientLibraryIntegrity) {
          script.integrity = clientLibraryIntegrity;
          script.crossOrigin = "anonymous";
        }
        document.head.appendChild(script);
      }
      // Load Flex form 
      function loadFlex(captureContext) {
        // setup
        var flex = new Flex(captureContext);
        // custom styles that will be applied to each field we create using Microform
        var myStyles = {
          input: {
            "font-size": "14px",
            "font-family": "helvetica, tahoma, calibri, sans-serif",
            color: "#555",
          },
          ":focus": { color: "blue" },
          ":disabled": { cursor: "not-allowed" },
          valid: { color: "#3c763d" },
          invalid: { color: "#a94442" },
        };
        var microform = flex.microform({ styles: myStyles });
        var number = microform.createField("number", {
          placeholder: "0000 0000 0000 0000",
        });
        var securityCode = microform.createField("securityCode", {
          placeholder: "***",
        });

        number.load("#number-container");
        securityCode.load("#securityCode-container");

        number.on("change", function (data) {
          handleCheckCard(data.card[0]?.name);
        });

        payButton.addEventListener("click", function () {
          var expArr = expDate.value?.split("/");
          var expirationMonth = expArr[0];
          var expirationYear = `20${expArr[1]}`;
          var options = {
            expirationMonth: expirationMonth,
            expirationYear: expirationYear,
          };

          microform.createToken(options, function (err, token) {
            if (err) {
              // handle error
              console.error(err);
              errorsOutput.textContent = "* " + err.message;
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

      function loadRest() {
        payButton.addEventListener("click", function () {
          var cardNum = document.querySelector("#number-container");
          var cardCVV = document.querySelector("#securityCode-container");

          var expArr = expDate.value?.split("/");
          var expirationMonth = expArr[0];
          var expirationYear = `20${expArr[1]}`;
          var options = {
            expirationMonth: expirationMonth,
            expirationYear: expirationYear,
          };
          var cardCollection = {
            number: cardNum.value,
            expirationMonth: expirationMonth,
            expirationYear: expirationYear,
            securityCode: cardCVV.value
          }
          console.log(cardCollection);
          flexResponse.value = JSON.stringify(cardCollection);
          form.submit();
        });
      }

      /** Check Card Type */
      function handleCheckCard(type) {
        const img = document.getElementById('card-detection');
        if (type === "visa") {
          img.src = "../public/src/images/visa.svg";
        } else if (type === "mastercard") {
          img.src = "../public/src/images/master.svg";
        } else if (type === "cup" || type === "unionPay") {
          img.src = "../public/src/images/unionpay.svg";
        } else if (type === "jcb") {
          img.src = "../public/src/images/jcb.svg";
        } else {
          img.src = "../public/src/images/credit-card.svg";
        }
      };

      function setupFormModal(paymentType) {
        if (paymentType === "rest_api") {
          const divNum = document.getElementById('number-container');
          const divCVV = document.getElementById('securityCode-container');
          const inputNum = document.createElement('input');
          const inputCVV = document.createElement('input');
          inputNum.type = 'text';
          inputNum.id = 'number-container';
          inputNum.className = 'form-control bg-transparent';
          inputNum.placeholder = '0000 0000 0000 0000';

          inputCVV.type = 'text';
          inputCVV.id = 'securityCode-container';
          inputCVV.className = 'form-control bg-transparent';
          inputCVV.placeholder = '***';

          // Replace div with input
          divNum.replaceWith(inputNum);
          divCVV.replaceWith(inputCVV);
          cleaveSetup();
        } else {
          const inputNum = document.getElementById('number-container');
          const inputCVV = document.getElementById('securityCode-container');
          const divNum = document.createElement('div');
          const divCVV = document.createElement('div');
          divNum.id = 'number-container';
          divNum.className = 'form-control bg-transparent';
          divNum.placeholder = '0000 0000 0000 0000';

          divCVV.id = 'securityCode-container';
          divCVV.className = 'form-control bg-transparent';
          divCVV.placeholder = '***';

          // Replace div with input
          inputNum.replaceWith(divNum);
          inputCVV.replaceWith(divCVV);
        }
      }

      // Set up Cleave inputs
      function cleaveSetup() {
        new Cleave("#number-container", {
          creditCard: true,
          delimiter: ' ',
          onCreditCardTypeChanged: function(type) {
            console.log("Card Type: ", type);
            handleCheckCard(type);
          }
        });
        new Cleave("#securityCode-container", {
          blocks: [3],
          numericOnly: true,
        });
      }
      
      new Cleave("#expDate", {
        date: true,
        datePattern: ["m", "y"],
        delimiter: "/",
        blocks: [2, 2],
        numericOnly: true,
      });

      // Validate Expiry date
      expDate.addEventListener("blur", function () {
        const d = new Date();
        const month = d.getMonth() + 1;
        const year = d.getFullYear() % 100;
        if(expDate.value && expDate.value != "") {
          let expArr = expDate.value.split("/");
          if(Number(expArr[1]) > year || (Number(expArr[1]) == year && Number(expArr[0]) >= month)) {
            expDate.classList.add('text-valid');
            expDate.classList.remove('text-invalid');
          } else {
            new Cleave("#securityCode-container", {
              numericOnly: true,
              blocks: [3],
            });
            expDate.classList.remove('text-valid');
            expDate.classList.add('text-invalid');
          }
        }
      })
    </script>
<?php
include '../templates/footer.php';
?>