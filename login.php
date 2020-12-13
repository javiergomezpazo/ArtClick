<?php
require_once 'Actions/InsertData.php';
require_once 'Actions/session.php';

if (!comprobarSession()) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $valido = login($_POST['user'], $_POST['password']);
        if ($valido === false) {
            $error = true;
        } else {
            
            session_start();
            $_SESSION['user'] = $valido;
            header("Location: home");
        }
    }
} else {
    header("Location: home");
}
?>

<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <title>Log In</title>
    <meta name="author" content="Javier Gomez">
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
</head>

<body>
    <header>
    </header>


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


    <div id="btnTop" class="">
        <button class="btn-primary btn m-2">
            <i class="fa fa-arrow-up"></i>
        </button>
    </div>

    <main>

        <section class="container text-center mb-4 mt-3 p-5">
            <div class="mt-0"><img src="img/logo.png" alt="logo" class="w-50 text-center" /></div>
            <h1 class="mt-4">Login</h1>
            <form class="form px-5 pt-4 pb-5" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <div class="form-group col-md-6 text-left mx-auto">
                    <label for="email">Email</label>
                    <input type="email" name="user" class="form-control" id="user" required/>
                </div>
                <div class="form-group col-md-6 text-left mt-4 mx-auto">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required/>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Login</button>
            </form>
            <div>
                <p>Don't you have an account? <a href="SignUp.html" class="text-primary">Sign up</a></p>
            </div>
        </section>

    </main>


    <footer class="mt-5 px-5 pt-5 pb-2">
        <div class="row">
<div class="col-sm-4 px-4 pt-0 ">
    <div class="w-50 mx-auto">
            <img src="img/logo.png" alt="logo" class="w-100"/>
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
