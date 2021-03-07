<?php

    // Start or continue session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['logged-in-user']) || empty($_SESSION['logged-in-user'])) {
        header("Location: ".$_SERVER["SERVER_PROTOCOL"], true, 403);
        exit();
    }

    // Check if logout is clicked
    if (isset($_GET['logout'])) {
        unset($_SESSION['logged-in-user']);
        header("Location: ../index.php", true, 303);
    }
?>

<!DOCTYPE HTML>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Flavio Schoute">
    <title>FlappiesSnoep | Dashboard </title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>

  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">FlappiesSnoep</a>
      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
              data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
      <ul class="navbar-nav px-3">
          <li class="nav-item text-nowrap">
              <a class="nav-link" href="dashboard.php?logout=true">Uitloggen</a>
          </li>
      </ul>
  </nav>



  <div class="container-fluid">
      <div class="row">
          <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
              <div class="sidebar-sticky pt-3">
                  <ul class="nav flex-column">
                      <li class="nav-item">
                          <a class="nav-link active" href="#">
                              <span data-feather="home"></span>
                              Dashboard <span class="sr-only">(current)</span>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">
                              <span data-feather="file"></span>
                              Orders
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">
                              <span data-feather="shopping-cart"></span>
                              Products
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">
                              <span data-feather="users"></span>
                              Customers
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="overview.php">
                              <span data-feather="bar-chart-2"></span>
                              Bestelling overzicht
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">
                              <span data-feather="layers"></span>
                              Integrations
                          </a>
                      </li>
                  </ul>

                  <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                      <span>Saved reports</span>
                      <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                          <span data-feather="plus-circle"></span>
                      </a>
                  </h6>
                  <ul class="nav flex-column mb-2">
                      <li class="nav-item">
                          <a class="nav-link" href="#">
                              <span data-feather="file-text"></span>
                              Current month
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">
                              <span data-feather="file-text"></span>
                              Last quarter
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">
                              <span data-feather="file-text"></span>
                              Social engagement
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="#">
                              <span data-feather="file-text"></span>
                              Year-end sale
                          </a>
                      </li>
                  </ul>
              </div>
          </nav>

          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
              <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                  <h1 class="h2">Dashboard</h1>
                  <div class="btn-toolbar mb-2 mb-md-0">
                      <div class="btn-group mr-2">
                          <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                          <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                      </div>
                      <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                          <span data-feather="calendar"></span>
                          This week
                      </button>
                  </div>
              </div>

              <?php

              // Get the stuff we need
              require_once "process.php";
              require_once "../database/connection.php";
              require_once "../inc/functions.php";

              // Check connection
              $connection = getDatabaseConnection();
              if (!$connection) {
                  header($_SERVER["SERVER_PROTOCOL"], true, 503);
                  exit();
              }

              // Get products from the database
              $products = getProducts($connection, 'products');

              // Check if there are products returned
              if (empty($products)) {
                  ?>
                  <div class="col-12 p-3">
                      <div class="text-center no-products-found no-database-found d-flex justify-content-center align-items-center">
                          <div>
                              <strong><?php die("Geen producten gevonden..."); ?></strong>
                          </div>
                      </div>
                  </div>
                  <?php
              }
              ?>

              <div class="table-responsive">
                  <table class="table">
                      <thead>
                      <tr>
                          <th scope="col" class="border-0 bg-light">
                              <div class="p-2 px-3 text-uppercase">Productnaam</div>
                          </th>
                          <th scope="col" class="border-0 bg-light">
                              <div class="py-2 text-uppercase">Prijs</div>
                          </th>
                          <th scope="col" class="border-0 bg-light">
                              <div class="py-2 text-uppercase">Beschijving</div>
                          </th>
                          <th scope="col" class="border-0 bg-light">
                              <div class="py-2 text-uppercase">Actie</div>
                          </th>
                      </tr>
                      </thead>
                      <tbody>

                      <?php

                      foreach ($products as $product) {

                          // It have to be a switch statement - match statement PHP 8 doesn't work for some weird reason
                          $category;
                          switch ($product['category_id']) {
                              case 0:
                                  $category = 'zoet';
                                  break;
                              case 1:
                                  $category = 'zuur';
                                  break;

                              default:
                                  $category = "-";
                                  break;
                          }

                          ?>

                          <tr>
                              <th scope="row">
                                  <div class="p-2">
                                      <img src="../images/products/<?php echo $product['image_path'] ?>" alt=""
                                           width="40" class="img-fluid">
                                      <div class="ml-3 d-inline-block align-middle">
                                          <h5 class="mb-0"><a href="#" class="text-dark d-inline-block align-middle"><?php echo $product['name'] ?></a>
                                          </h5><span class="text-muted font-weight-normal font-italic d-block">Categorie: <?php echo $category ?></span>
                                      </div>
                                  </div>
                              </th>
                              <td class="align-middle"><strong>&euro;&nbsp;<?php echo $product['price'] ?></strong></td>
                              <td class="align-middle"><?php echo $product['description'] ?></strong></td>
                              <td class="align-middle">
                                  <a class="btn btn-info" role="button" href="dashboard.php?edit=<?php echo $product['product_id'] ?>">Veranderen</a>
                                  <a class="btn btn-danger" role="button" href="process.php?delete=<?php echo $product['product_id'] ?>">Verwijderen</a>
                              </td>
                          </tr>
                          <?php
                      }
                      ?>
                      </tbody>
                  </table>
              </div>


              <form action="process.php" method="POST" accept-charset="UTF-8">
                  <input type="hidden" name="product-id" value="<?php echo $id; ?>">

                  <div class="form-group">
                      <label for="product-name">Product naam:</label>
                      <input type="text" class="form-control" name="product-name" id="product-name" placeholder="Nieuwe product naam" required value="<?php echo $name ?>">
                  </div>

                  <div class="form-group">
                      <label for="product-image">Product afbeelding:</label>
                      <input type="text" class="form-control" name="product-image" id="product-image" placeholder="Nieuwe product afbeelding" required value="<?php echo $image ?>">
                  </div>

                  <div class="form-group">
                      <label for="product-description">Product beschijving:</label>
                      <input type="text" class="form-control" name="product-description" id="product-description" placeholder="Nieuwe product beschrijving" required value="<?php echo $description ?>">
                  </div>

                  <div class="form-group">
                      <label for="product-price">Product prijs:</label>
                      <input type="number" class="form-control" name="product-price" id="product-price" min="0" step=".01" placeholder="Nieuwe product prijs" required value="<?php echo $price ?>">
                  </div>

                  <div class="form-group">
                      <label for="product-category">Product categorie:</label>
                      <input type="text" class="form-control" name="product-category" id="product-category" placeholder="Nieuwe product categorie" required value="<?php echo $category ?>">
                  </div>

                  <div class="form-group">
                      <?php
                      if ($update) {
                          echo '<button type="submit" name="update" class="btn btn-info">Verander</button>';
                      } else {
                          echo '<button type="submit" name="save" class="btn btn-primary">Opslaan</button>';
                      }
                      ?>
                  </div>
              </form>

          </main>
      </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
</body>
</html>
