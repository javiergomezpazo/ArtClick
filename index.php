<?php
require_once 'Actions/InsertData.php';
require_once 'Actions/session.php';

if (comprobarSession()) {
            header("Location: home");
}
?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <title>ArtClick</title>
    <meta name="author" content="ArtClick">
    <link rel="icon" type="image/x-icon" href="img/favicon.jpg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Example description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="fonts/fontawesome-free-5.12.1-web/css/fontawesome.css" rel="stylesheet">
    <link href="fonts/fontawesome-free-5.12.1-web/css/brands.css" rel="stylesheet">
    <link href="fonts/fontawesome-free-5.12.1-web/css/solid.css" rel="stylesheet">
    <script src="js/index.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/index.css" />
    <script>
    
        $(document).ready(function (){
                $('html, body').css({

        'overflow': 'hidden',

        'height': '100%'

    });
            var load = $("#load");
            load.css("height", "100%");
            console.log(screen.height);
        });
        
        
    </script>
</head>

<body>
    <div id="load" class="text-center modal-dialog-centered justify-content-center w-100">
   <div class="text-center" id="loading_info">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
    </div>
    <header></header>
    <nav class="navbar navbar-expand-lg navbar-light bg p-3 px-5">

        <a class="navbar-brand ml-5" href="index" id="logo"><img src="img/logo.png" alt="logo" class="w-100 text-center" /></a>

        <div class="row" id="phone">
            <div id="logo_phone" class="mx-auto col-6"><a class="navbar-brand" href="index"><img src="img/logo.png" alt="logo" class="w-100 text-center" /></a></div>
            <button class="navbar-toggler col-2" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="navbar-toggler-icon"></i>
            </button>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="button_nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center ml-5" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto ">
                <li class="nav-item dropdown mx-2">
                    <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Discover <i class="fas fa-angle-down ml-1 display-7 font-weight-light"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Popular works</a>
                        <a class="dropdown-item" href="#">Categories</a>
                    </div>
                </li>                
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">Licence</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0  rounded ">
                <button class="btn my-2 my-sm-0 text-primary" type="button" id="icon_search"><i class="fas fa-search"></i></button>
                <input class="form-control mr-sm-2 bg-white border-0" type="search" placeholder="Search..." aria-label="Search">
            </form>
            <!--<div class="ml-3" id="button_no_connect">
                <button class="btn btn-outline-primary" type="button">Sign In</button>
                <button class="btn btn-primary ml-2" type="button">Sign Up</button>
            </div>-->

            <!--<div class="ml-3" id="button_connect">
             
                <div class="px-0 p-0 m-0 btn btn">
                    <div class=" nav-item dropdown">
                        <a class="nav-link  p-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><div id="img_profile" class="btn btn overflow-hidden rounded-circle"></div> </a>
                        <div class="dropdown-menu py-0" aria-labelledby="navbarDropdownMenuLink"> 
                            <a class="dropdown-item text-dark p-2 pl-3 text-left" href="Profile.php">Profile</a> 
                            <a class="dropdown-item text-dark p-2 pl-3" href="Mydata.php">My data</a>
                            <p class="dropdown-item text-danger p-2 pl-3 mb-0" id="log_out">Log Out</p>
                        </div>
                    </div>
                </div>
                
                <div class="px-0 p-0 m-0 btn btn ml-2" id="div_notification">
                    <div class=" nav-item dropdown">
                        <a class="nav-link  p-0" href="#" id="notification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bell"></i><i class="fas fa-circle ml-1" id="alert_notification"></i> </a>
                        <div class="dropdown-menu py-0" aria-labelledby="notification"> 
                            <h4 class="p-3">Notification</h4>
                          <ul class="ul px-3 my-2">
                            <li class="row  p-0 m-0 mt-2 my-auto">
                              <a href="profile.html">
                                  <div id="img_profile_notification" class="btn btn overflow-hidden rounded-circle p-0 m-0">
                                  </div>
                              </a>
                              <p class="col-sm text-justify"><a href="profile.html?id=01">@jose_luis</a> like your post <a href="post.html?id=01">Title</a></p>
                              <p class="col-sm-1 font-weight-light text-right px-2">5h</p>
                              </li> 
                              <li class="row  p-0 m-0 mt-2 my-auto">
                              <div id="img_profile" class="btn btn overflow-hidden rounded-circle p-0 m-0">
                </div>
                                <p class="col-sm text-justify"><a href="profile.html?id=01">@jose_luis</a> like your post <a href="post.html?id=01">Title</a></p>
                                <p class="col-sm-1 font-weight-light text-right px-2">5h</p>
                              </li> 
                            </ul>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    </nav>

    <main>
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/img_index_3.jpg" class="d-block w-100" alt="...">
                    <img src="img/border_imgIindex.png" class="w-100 border_img">
                    <div class="p-5 py-4 ml-1 rounded" id="div_text">
                        <h1 class="h1 text-left mb-3">¿Eres un artista?</h1>
                        <h4>¿Profesional?¿Amateur?</h4>
                        <p class="font-weight-light mx-0">
                            Si ese es el caso, entonces esta es tu web. Unete con decenas de artistas y muestra tus obras.
                        </p>
                        <a href="SignUp.php"><button class="btn btn-primary mx-0" type="button">Sign Up</button></a>
                    </div>
                    <p id="credit_photo" class="m-3 mr-5 font-weight-lighter">by <a href="https://unsplash.com/photos/Wa9ilX9XYOI">Diogo Nunes</a></p>
                </div>
            </div>

        </div>


        <section class="px-5 " id="section_2">
            <h1 class="mb-5">¿What is ArtClick?</h1>
            <div class="row justify-content-center m-0">
                <article class="col-sm-3 text-center mb-3">
                    <p class=" display-4 mb-1 text-primary"><i class="fa fa-lightbulb"></i></p>
                    <p class="font-weight-bold m-0 mb-1 text-primary">Show your ideas</p>
                    <p class="font-weight-light w-60 pl-2 signika_linght font-weight-lighter">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </article>

                <article class="col-sm-3 text-center mb-3">
                    <p class=" display-4 mb-1 text-primary"><i class="fa fa-users"></i></p>
                    <p class="font-weight-bold m-0 mb-1 text-primary">Artist</p>
                    <p class="font-weight-light w-60 pl-2 signika_linght font-weight-lighter">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </article>

                <article class="col-sm-3 text-center mb-3">
                    <p class=" display-4 mb-1 text-primary"><i class="fas fa-book-open"></i></p>
                    <p class="font-weight-bold m-0 mb-1 text-primary">Build your portfolio</p>
                    <p class="font-weight-light w-60 pl-2 signika_linght font-weight-lighter">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                </article>

            </div>
        </section>

        <section class="mt-3 mb-3 my-auto  modal-dialog-centered" id="img_section_licensing">
            <div id="banner" class="p-5 text-center w-100 modal-dialog-centered">
                <h3 class="display-4 mb-3 w-100"><i class="fas fa-award"></i> Enjoy the best performance</h3>
            </div>
        </section>

        <section class="container mt-5 mb-3">
            <article class="w-100 row px-0 py-3 modal-dialog-centered">
                <div class="col-sm-4 mb-3">
                    <img src="img/jason-leung-z-EGaTPtXhk-unsplash.jpg" alt="" class="w-100" id="img_1" />

                </div>
                <div class="col-sm ml-3">
                    <h2 class="mb-3 text-right">Get paid for your work?</h2>
                    <p class="text-justify">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </p>
                    <a href="#" class="mt-4"><button class="btn btn-primary">Read more</button></a>
                </div>

            </article>

        </section>

        <section class="mt-3 mb-3 my-auto  modal-dialog-centered" id="img_section_best_picture">
            <div id="banner" class="p-5 text-center w-100 modal-dialog-centered">
                <h3 class="display-4 mb-3 w-100"><i class="fas fa-star"></i> Best picture today</h3>
            </div>
        </section>

        <section class="p-5  container" id="posts_main">
            <div class="row justify-content-center">

                <figure class="p-0 col-sm-5 mr-2 rounded  shadow">
                    
                        <div class="overflow-hidden p-0 ">
                            <a class="" href="Register.php">
                            <img src="img/roman-kraft-2ulXWQNjGlQ-unsplash.jpg" alt="Photo by Roman Kraft" class="w-100" />
                                 </a>
                        </div>
                        <figcaption class="p-3 pl-4 figcaption" >Photo by <a href="https://unsplash.com/@romankraft" class="ml-1"> Roman Kraft</a></figcaption>
                   
                </figure>


             <figure class=" p-0 col-sm-5 mr-2 rounded  shadow">
                   
                        <div class="overflow-hidden p-0 m-0">
                             <a class="" href="Register.php">
                            <img src="img/mona-miller-U2_E2VOuJks-unsplash.jpg" alt="Photo by Mona Miller" class="w-100" /></a></div>
                        <figcaption class="p-3 pl-4 figcaption" >Photo by <a href="https://unsplash.com/@m0ther_0f_memes" class="ml-1"> Mona Miller</a></figcaption>
                    
                </figure>

                <figure class="p-0 col-sm-5 mr-2 rounded shadow">

                    <div class="overflow-hidden p-0 m-0">
                        <a class="" href="Register.php">
                            <img src="img/europeana-YIfFVwDcgu8-unsplash.jpg" alt="Photo by Europeana" class="w-100" /></a></div>
                    <figcaption class="p-3 pl-4 figcaption">Photo by <a href="https://unsplash.com/@europeana" class="ml-1"> Europeana</a></figcaption>

                </figure>

                <figure class="p-0 col-sm-5 mr-2 rounded  shadow">
                    <div class="overflow-hidden p-0 m-0">
                        <a class="" href="Register.php">
                            <img src="img/richard-thomposn-PnMCRBRajFw-unsplash.jpg" alt="Photo by Richard Thomposn" class="w-100" /></a>
                    </div>
                    <figcaption class="p-3 pl-4 figcaption">Photo by <a href="https://unsplash.com/@bigchungus64" class="ml-1"> Richard Thomposn</a></figcaption>

                </figure>
            </div>

        </section>

    </main>

    <div id="btnTop" class="rounded-circle">
        <button class="btn-primary btn m-2 rounded-circle">
            <i class="fa fa-arrow-up"></i>
        </button>
    </div>

    <div id="bannerCookies" class="p-2">
        <div class="row pt-4 px-5">
            <div class="col-sm-9">
                <p>Utilizamos cookies para garantizarle la mejor experiencia en nuestro sitio web. Para obtener más información, conocer las cookies utilizadas por el sitio web y eventualmente deshabilitarlas, acceda a la Política sobre cookies. Si continúa con la navegación en este sitio web, permite el uso de las cookies.</p>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-outline-primary w-100" id="cerrar">Acepto</button>
            </div>
        </div>
    </div>

    <!--<section class="w-100 px-5 py-3 row justify-content-center m-0 mb-5" id="categories">

            <figure class=" p-0 col-sm-3 mr-2 mt-5">
                <div class="justify-content-center ">
                    <div class="overflow-hidden p-0 m-0 rounded-circle shadow mb-2">
                        <a class="w-100" href="Register.php">
                            <img src="img/stock-photo-1015162591.jpg" alt="Centro, Photo by A
Feliphe Schiarolli" class="w-100">
                        </a>
                    </div>
                    <figcaption class=" text-center"><a href="">Register Student</a></figcaption>
                </div>
            </figure>

            <figure class=" p-0 col-sm-3 mr-2 mt-5">
                <div class="justify-content-center ">
                    <div class="overflow-hidden p-0 m-0 rounded-circle shadow mb-2">
                        <a class="w-100" href="Register.php">
                            <img src="img/stock-photo-1015162591.jpg" alt="Centro, Photo by A
Feliphe Schiarolli" class="w-100">
                        </a>
                    </div>
                    <figcaption class=" text-center"><a href="">Register Student</a></figcaption>
                </div>
            </figure>


            <figure class=" p-0 col-sm-3 mr-2 mt-5">
                <div class="justify-content-center ">
                    <div class="overflow-hidden p-0 m-0 rounded-circle shadow mb-2">
                        <a class="w-100" href="Register.php">
                            <img src="img/stock-photo-1015162591.jpg" alt="Centro, Photo by A
Feliphe Schiarolli" class="w-100">
                        </a>
                    </div>
                    <figcaption class=" text-center"><a href="">Register Student</a></figcaption>
                </div>
            </figure>


            <figure class=" p-0 col-sm-3 mr-2 mt-5">
                <div class="justify-content-center ">
                    <div class="overflow-hidden p-0 m-0 rounded-circle shadow mb-2">
                        <a class="w-100" href="Register.php">
                            <img src="img/stock-photo-1015162591.jpg" alt="Centro, Photo by A
Feliphe Schiarolli" class="w-100">
                        </a>
                    </div>
                    <figcaption class=" text-center"><a href="">Register Student</a></figcaption>
                </div>
            </figure>


            <figure class=" p-0 col-sm-3 mr-2 mt-5">
                <div class="justify-content-center ">
                    <div class="overflow-hidden p-0 m-0 rounded-circle shadow mb-2">
                        <a class="w-100" href="Register.php">
                            <img src="img/stock-photo-1015162591.jpg" alt="Centro, Photo by A
Feliphe Schiarolli" class="w-100">
                        </a>
                    </div>
                    <figcaption class=" text-center"><a href="">Register Student</a></figcaption>
                </div>
            </figure>


            <figure class=" p-0 col-sm-3 mr-2 mt-5">
                <div class="justify-content-center ">
                    <div class="overflow-hidden p-0 m-0 rounded-circle shadow mb-2">
                        <a class="w-100" href="Register.php">
                            <img src="img/stock-photo-1015162591.jpg" alt="Centro, Photo by A
Feliphe Schiarolli" class="w-100">
                        </a>
                    </div>
                    <figcaption class=" text-center"><a href="">Register Student</a></figcaption>
                </div>
            </figure>

        </section>-->



    <footer class="mt-5 px-5 pt-5 pb-2">
        <div class="row">
            <div class="col-sm-4 px-4 pt-0 ">
                <div class="w-50 mx-auto">
                    <img src="img/logo.png" alt="logo" class="w-100" />
                </div>
                <p class="font-weight-light mt-3 text-center"> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                <p class="mt-2 text-center" id="social">
                    <a href="index.html"><i class="fab fa-twitter"></i></a>
                    <a href=""><i class="fab fa-facebook"></i></a>
                    <a href=""><i class="fab fa-instagram"></i></a>
                </p>
            </div>
            <div class="col-sm-2 text-center mt-3">
                <h4>Discover</h4>
                <ul class="ul p-0">
                    <li><a href="">Lorem Ipsum</a></li>
                    <li><a href="">Lorem Ipsum</a></li>
                    <li><a href="">Lorem Ipsum</a></li>
                </ul>
            </div>
            <div class="col-sm-2 text-center mt-3">
                <h4>Discover</h4>
                <ul class="ul p-0">
                    <li><a href="">Lorem Ipsum</a></li>
                    <li><a href="">Lorem Ipsum</a></li>
                    <li><a href="">Lorem Ipsum</a></li>
                </ul>
            </div>

            <div class="col-sm-4 text-center mt-3">
                <h4>Search</h4>
                <form class="row mt-4 justify-content-center">
                    <input type="text" class="form-control col-sm-6">
                    <button type="submit" class="btn btn-primary col-sm-1 ml-2"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <div class="row pt-3 mt-3 mx-0" id="footer_container_down">
            <p class="col-sm-6" id="copyright">©Copyright 2020, ArtClick ALL RIGHTS RESERVED</p>
            <ul class="col-sm nav justify-content-end" id="ul_privacidad">
                <li class="ml-3"><a href="">About us</a></li>
                <li class="ml-3"><a href="">Privacy Politic</a></li>
                <li class="ml-3"><a href="">Privacy Cookies</a></li>
            </ul>
        </div>
    </footer>

</body>

</html>
