<?php
require_once 'Actions/InsertData.php';
require_once 'Actions/session.php';

if (!comprobarSession()) {
    header("Location: index");
}
?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <title>Edit profile ~ ArtClick</title>
    <meta name="author" content="ArtClick">
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
    <script src="js/editProfile.js" crossorigin="anonymous"></script>
    <script src="js/index.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/editProfile.css" />
    <link rel="stylesheet" href="css/index.css" />
</head>

<body>
    <header></header>

     <nav class="navbar navbar-expand-lg navbar-light bg p-3 px-5">

        <a class="navbar-brand ml-5" href="home" id="logo"><img src="img/logo.png" alt="logo" class="w-100 text-center" /></a>

        <div class="row" id="phone">
            <div id="logo_phone" class="mx-auto col-6"><a class="navbar-brand" href="home"><img src="img/logo.png" alt="logo" class="w-100 text-center" /></a></div>
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


    <main class="container">
        <h1 class="h1 mt-4">Edit profile</h1>
        <section id="edit" class="my-auto py-5 my-4 container">
            <div class="text-center" id="loading_info">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div id="form">
                
                <div id="cabecera" class="p-0 m-0">
                <div id="img_cabecera" class="overflow-hidden mx-auto text center">
                    <div class="text-center justify-content-center" id="loading_img_cabecera">
                <div class="spinner-border text-primary text-center" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
                    <input type="file" id="img_cabecera_input" name="img_cabecera" accept="imag/*" size="16">
                            <div class="w-100 container_input p-3">
                           <p class="w-100 text-right m-0"> <i class="fas fa-pencil-alt"></i></p>
                                    </div>
                </div>
                <div id="info_cabecera" class=" px-5 pt-3 pb-1   my-auto text-center">
                    <div class="mb-2">
                        <div id="img_profile_main" class="overflow-hidden rounded-circle mx-auto text center ">
                            <div class="text-center justify-content-center" id="loading_img_profile">
                <div class="spinner-border text-primary text-center" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
                            <input type="file" id="img_profile_input" name="img_profile" accept="imag/*" size="16">
                            <div class="w-100 container_input">
                                <div class="w-100 my-auto">
                           <p class="w-100 text-center m-0"> <i class="fas fa-pencil-alt"></i></p>
                                    </div>
                                </div>
                        </div>
                    </div>
                    </div>
                    </div>
                <form class="form mt-4">
                <div class="form-row mt-4">
                    <div class="form-group col-md-6 text-left mx-auto">
                        <label for="user">Name</label>
                        <input type="text" name="name" class="form-control" id="name" maxLength="45" required />
                    </div>
                    <div class="form-group col-md-6 text-left mx-auto">
                        <label for="user">User name</label>
                        <input type="text" name="userName" class="form-control" id="userName" required maxLength="25" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="about">About</label>
                    <textarea class="form-control" id="about" rows="3" maxLength="250"></textarea>
                </div>
                    <div class="form-group">
                    <label for="biography">Biography</label>
                    <textarea class="form-control" id="biography" rows="3" maxLength="160"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 text-left mx-auto">
                        <label for="web">Web</label>
                        <input type="text" name="web" class="form-control" id="web" maxLength="175" />
                    </div>
                    <div class="form-group col-md-6 text-left mx-auto">
                        <label for="facebook">Facebook</label>
                        <input type="text" name="facebook" class="form-control" id="facebook" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 text-left mx-auto">
                        <label for="instagram">Instagram</label>
                        <input type="text" name="instagram" class="form-control" id="instagram" />
                    </div>
                    <div class="form-group col-md-6 text-left mx-auto">
                        <label for="twitter">Twitter</label>
                        <input type="text" name="twitter" class="form-control" id="twitter" />
                    </div>
                </div>
                    <div class="btn-group text-right" role="group">
                    <button type="button" class="btn btn-secondary mt-2" id="cancel">Cancel</button>
                    <button type="submit" id="saveChanges" class="btn btn-primary mt-2 ml-2">Save changes</button>
                    </div>
                </form>
            </div>

        </section>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>

                    </div>
                    <div class="modal-body">
                        <p class="text-center"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>

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
