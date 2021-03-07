<!DOCTYPE HTML>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Flavio Schoute">
    <title>FlappiesSnoep | Checkout</title>


    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="../css/cart.css" type="text/css" rel="stylesheet">
</head>
<body>

  <div class="container bg-white rounded shadow-sm my-4 p-3">

      <div class="row">
          <div class="col-md-4 order-md-2 mb-4">
              <h4 class="d-flex justify-content-between align-items-center mb-3">
                  <span class="text-muted">Your cart</span>
                  <span class="badge badge-secondary badge-pill">3</span>
              </h4>
              <ul class="list-group mb-3">
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                      <div>
                          <h6 class="my-0">Product name</h6>
                          <small class="text-muted">Brief description</small>
                      </div>
                      <span class="text-muted">$12</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                      <div>
                          <h6 class="my-0">Second product</h6>
                          <small class="text-muted">Brief description</small>
                      </div>
                      <span class="text-muted">$8</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                      <div>
                          <h6 class="my-0">Third item</h6>
                          <small class="text-muted">Brief description</small>
                      </div>
                      <span class="text-muted">$5</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between bg-light">
                      <div class="text-success">
                          <h6 class="my-0">Promo code</h6>
                          <small>EXAMPLECODE</small>
                      </div>
                      <span class="text-success">-$5</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between">
                      <span>Total (USD)</span>
                      <strong>$20</strong>
                  </li>
              </ul>
          </div>

          <div class="col-md-8 order-md-1">
              <h4 class="mb-3">Facturatie adres</h4>
              <form class="needs-validation" novalidate action="../mollie-api/create-payment.php" method="POST" accept-charset="UTF-8" enctype="application/x-www-form-urlencoded">
                  <div class="row">

                      <div class="col-md-6 mb-3">
                          <label for="first-name">Voornaam:</label>
                          <input type="text" class="form-control" id="first-name" name="first-name" placeholder="" value="" required>
                          <div class="invalid-feedback">
                              Vul uw voornaam in
                          </div>
                      </div>

                      <div class="col-md-6 mb-3">
                          <label for="last-name">Achternaam:</label>
                          <input type="text" class="form-control" id="last-name" name="last-name" placeholder="" value="" required>
                          <div class="invalid-feedback">
                              Vul uw achternaam in
                          </div>
                      </div>
                  </div>


                  <div class="mb-3">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="ino@voorbeeld.nl" required>
                      <div class="invalid-feedback">
                          Vul een geldig email adress in.
                      </div>
                  </div>

                  <div class="mb-3">
                      <label for="residence">Woonplaats</label>
                      <input type="text" class="form-control" id="residence" name="residence" placeholder="Hoofdstraat 35" required>
                      <div class="invalid-feedback">
                          Vul een geldige woonplaats in
                      </div>
                  </div>


                  <div class="mb-3">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" id="address" name="address" placeholder="Hoofdstraat 35" required>
                      <div class="invalid-feedback">
                          Vul een geldig adres in.
                      </div>
                  </div>

                  <div class="mb-3">
                      <label for="phonenumber">Telefoon nummer</label>
                      <input type="tel" class="form-control" id="phonenumber" name="phonenumber" placeholder="" required>
                      <div class="invalid-feedback">
                          Vul een telefoon nummer in
                      </div>
                  </div>

                  <div class="row justify-content-between">
                      <div class="col-md-5 mb-3">
                          <label for="country">Country</label>
                          <select class="custom-select shadow-none d-block w-100" id="country" name="country" required>
                              <option value="" disabled selected>Land</option>
                              <option value="0">Nederland</option>
                              <option value="1">Belgie</option>
                          </select>

                          <div class="invalid-feedback">
                              Selecteer een land
                          </div>
                      </div>

                      <div class="col-md-3 mb-3">
                          <label for="postalcode">Postcode:</label>
                          <input type="text" class="form-control" id="postalcode" name="postalcode" placeholder="" required>
                          <div class="invalid-feedback">Postcode is verplicht.</div>
                      </div>

                  </div>

                  <hr class="mb-4">

                  <button class="btn btn-checkout shadow-none btn-lg btn-block" type="submit" name="submit">Verder met betaling</button>
              </form>
          </div>
      </div>

      <footer class="my-5 pt-5 text-muted text-center text-small">
          <p class="mb-1">&copy; 2017-2021 Company Name</p>
          <ul class="list-inline">
              <li class="list-inline-item"><a href="#">Privacy</a></li>
              <li class="list-inline-item"><a href="#">Terms</a></li>
              <li class="list-inline-item"><a href="#">Support</a></li>
          </ul>
      </footer>
  </div>


  <script>
      (function () {
          'use strict'
          window.addEventListener('load', function () {

              // Fetch all the forms we want to apply custom Bootstrap validation styles to
              let forms = document.getElementsByClassName('needs-validation')

              // Loop over them and prevent submission
              Array.prototype.filter.call(forms, function (form) {
                  form.addEventListener('submit', function (event) {
                      if (form.checkValidity() === false) {
                          event.preventDefault();
                          event.stopPropagation();
                      }

                      form.classList.add('was-validated')
                  }, false)
              })
          }, false)
      })();

  </script>

</body>
</html>
