<?php

/*include 'databaseconnector.php';*/
//require_once 'databaseconnector.php';

//todo: change database from test to production

$dblink = mysqli_connect("localhost", "root", "", "test");

$selectAllProducten = 'SELECT * FROM producten';

$Producten = mysqli_query($dblink, $selectAllProducten);




function getCategorieen(){


}

//PHP simple button functionality

//


//data grip in een file? met return echo en drops


// toevoegen aan winkelmand functie

//Set categorie naam

//slider function

//sorteer op functie

// fix important tag for col colour

// if niet op voorraad = dan button disabled and prijs kleur rood en streep der doorheen


?>
<!--<script src="https://code.iconify.design/iconify-icon/2.2.0/iconify-icon.min.js"></script>-->


<div class = "container my-5">
    <div class="row">
        <!--Filter column-->
        <div class="col bg-body-tertiary" style="background-color:#FFFFFF  !important;">
            <div class="container px-5 py-3 shadow-sm" style="background-color: #ffc107 !important;">
                <h2> Filteren</h2>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorieen
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Acoustic Gitaar</a></li>
                        <li><a class="dropdown-item" href="#">Elektrisch gitaar </a></li>
                    </ul>
                </div>
                <h5 class="pt-3">Beschikbaarheid:</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        Op voorraad
                    </label>
                </div>
                <h5 class="pt-3">Merk:</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        Merk A
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        Merk B
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label" for="flexCheckChecked">
                        Merk C
                    </label>
                </div>
                <h5 class="pt-3">Prijs:</h5>
                <label for="customRange1" class="form-label">Example range</label>
                <input type="range" class="form-range" id="customRange1">
            </div>
        </div>

        <!--FILTER COLUMN-->
        <div class="col-9">
            <div class="container ">
                <div class="row">
                    <h1> Categorie naam / Alle Producten </h1>
                </div>

                    <div class="col">
                        <div class="dropdown">
                            Sorteer op:
                            <button  class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Prijs
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" >Prijs laag hoog</a></li>
                                <li><a class="dropdown-item" >Prijs hoog laag</a></li>
                            </ul>
                        </div>
                    </div>

                <div class="row mt-2">

<?php
while ($row = mysqli_fetch_assoc($Producten)) { ?>
    <!-- Product Card 1 -->
    <div class="col-md-4">

        <div class="card">
            <!-- todo: if in de aanbieding -->
            <span class="badge text-bg-danger rounded-0">Aanbieding!</span>
            <img src="https://via.placeholder.com/400x250" class="card-img-top rounded-0" alt="Electric Guitar">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['productnaam'])  ?></h5>
                <p class="card-text">High-quality electric guitar with stunning sound.</p>
                <p class="text-success">Van <s class="text-danger">€499.99</s> naar €300,-</p>
                <a href="#" class="btn btn-primary">View Details</a>
                <a href="#" class="btn btn-success align-items-center">Toevoegen <iconify-icon icon="mdi:add-shopping-cart" style="font-size: 22px; vertical-align: middle"></iconify-icon>  </a>
            </div>
        </div>
    </div>
<?php } ?>
                    <!-- Product Card 1 Aanbieding voorbeeld-->
                  <!--  <div class="col-md-4">

                        <div class="card">
                            <span class="badge text-bg-danger rounded-0">Aanbieding!</span>
                            <img src="https://via.placeholder.com/400x250" class="card-img-top rounded-0" alt="Electric Guitar">
                            <div class="card-body">
                                <h5 class="card-title">Aanbieding voorbeeld card</h5>
                                <p class="card-text">High-quality electric guitar with stunning sound.</p>
                                <p class="text-success">Van <s class="text-danger">€499.99</s> naar €300,-</p>
                                <a href="#" class="btn btn-primary">View Details</a>
                                <a href="#" class="btn btn-success align-items-center">Toevoegen <iconify-icon icon="mdi:add-shopping-cart" style="font-size: 22px; vertical-align: middle"></iconify-icon>  </a>
                            </div>
                        </div>
                    </div>
                     Product Card 2  Niet op voorraad voorbeeld
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Acoustic Guitar">
                            <div class="card-body">
                                <h5 class="card-title">Niet op voorraad voorbeeld card</h5>
                                <p class="card-text">Perfect acoustic guitar for beginners and professionals alike.</p>
                                <p class="text-danger">€349.99 Niet op voorraad</p>
                                <a href="#" class="btn btn-primary">View Details</a>
                                <a href="#" class="btn btn-danger align-items-center disabled" >Toevoegen <iconify-icon icon="mdi:add-shopping-cart" style="font-size: 22px; vertical-align: middle"></iconify-icon>  </a>

                            </div>
                        </div>
                    </div>
                    -->
                <nav aria-label="...">
                    <ul class="pagination justify-content-center pagination-sm mt-3">
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">1</span>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                    </ul>
                </nav>
            </div>


        </div>
    </div>

</div>


