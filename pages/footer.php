<?php

    function includeFooter($tos, $contact, $class = null) {
        echo '
            <footer class="'.$class.'">
                <div class="container my-4">
                    <div class="row no-gutters">
            
                        <div class="col-12 col-sm-6">
                            <div class="external-links m-3 text-right">
                                <h3 class="mb-0"><a href='.$tos.' target="_blank">Algemene voorwaarden</a></h3>
                                <h3 class="mb-0"><a href='.$contact.'>Contact</a></h3>
                            </div>
                        </div>
            
                        <div class="col-12 col-sm-6">
                            <div class="social-media m-3">
                                <h3 class="m-0">Volg ons op social media</h3>
                                <ul>
                                    <li class="mr-3"><a rel="noreferrer" href="http://google.com" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="mx-3"><a rel="noreferrer" href="http://google.com" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    <li class="mx-3"><a rel="noreferrer" href="http://google.com" target="_blank"> <i class="fab fa-twitter"></i></a></li>
                                </ul>
                            </div>
                        </div>
            
                    </div>
                </div>
            </footer> ';
    }
?>
