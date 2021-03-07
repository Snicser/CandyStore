<!DOCTYPE HTML>
<html lang="nl">
<head>
    <title>Snoepwinkel | Contact</title>

    <!-- Meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous"/>

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

</head>
<body class="candy-store-bg-image">

    <header class="my-4">
        <section>
            <div class="container">
                <div class="row" style="border: 1px solid black">
                    <div class="col">
                        <img  class="img-fluid mx-auto d-block" src="../images/shop-logo.png" alt="Logo">
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <h1 class="mb-0 py-4 text-center welcome-text text-white text-uppercase">Contact</h1>
            </div>
        </section>
    </header>

    <!-- Spacing tussen hier te groot -->

    <main>
        <section>
            <div class="container product-overview-bg-color my-4 p-3">

                <div class="row no-gutters">
                    <div class="col p-2">
                       <a class="btn-go-back p-2" href="../"><i class="fas fa-arrow-left"></i></a>
                    </div>
                </div>


                <div class="row no-gutters align-items-stretch" style="border-top: 1px solid rgba(0, 0, 0, .6);">
                    <div class="col-12 col-md-6 p-2">

                        <h3 class="contact-header">Algemene informatie:</h3>

                        <p class="contact-text">
                            Heb je een vraag/opmerking over een aankoop in de winkel?
                            Neem hierover contact op met de winkel.
                        </p>

                        <p class="contact-text">
                            Heb je een vraag/opmerking over een aankoop via de webshop?
                            Klik dan hier. Staat je vraag er niet tussen? Klik dan hier.
                        </p>

                        <p class="contact-text">
                            Pers-/marketingvragen uitsluitend per e-mail.
                            Telefonische acquisitie wordt niet op prijs gesteld.
                        </p>

                    </div>

                    <div class="col-12 col-md-6 p-2">
                        <h3 class="contact-header">Bezoek adres:</h3>

                        <p class="contact-text">
                            De Boedingen 39 <br>
                            4906 BA Oosterhout
                        </p>

                        <p class="contact-text">
                            Telefoonnummer: (0318) 52 52 12 <br>
                            KvK:  202155021 <br>
                            BTW-nummer: NL031867864B03 <br>
                        </p>
                    </div>
                </div>

                <div class="row no-gutters">
                    <div class="col p-2" style="border-top: 1px solid rgba(0, 0, 0, .6);">
                        <h6 class="text-info text-center text-sm-left mb-0" style="font-weight: bold;">Het contact formulier is momenteel in onderhoud...<i class="fas fa-tools" style="padding-left: 5px"></i></h6>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <!-- Include footer with PHP -->
    <?php include 'footer.php';
        includeFooter('../algemene-voorwaarden.pdf#page=1&pagemode=bookmarks', 'contact.php');
    ?>

</body>
</html>