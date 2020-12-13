var page = 1;
var page_follower = 1;
var page_following = 1;
var id = getParameterUrl();

/*inicio*/

$(document).ready(function () {

    $("#close_num_seguidos").click(hideFollower);

    if (id == null) {
        console.log(id);
    } else {
        console.log(id);
        loadProfile(id);
        loadPosts(id);
    }

    $("#a_followers").click(loadFollowers);
    $("#a_following").click(loadFollowing);


});


/*tamaño imagenes. si imagen maior px = 20%, imagen > = 35%*/


function image_size(src) {
    var img = new Image();
    img.src = src;
    document.images[0].src = img.src;
    console.log(img.width);
    if (img.width >= 900) {
        return 35;
    } else {
        return 20;
    }
}

/**/

function hideFollower() {
    page_follower = 1;
    page_following = 1;
        $('html, body').css({
            'overflow': 'visible',
            'height': 'auto'
        });
    $("#section_seguidos").hide();
}

/**/

function loadProfile(id) {
    console.log(23);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var profile = JSON.parse(this.responseText);
            console.log(profile);
            
            var aux="";

            if (parseInt(profile[0].you_id) == parseInt(profile[0].idUsers)) {
                $("#button_follow").html("Edit profile");
                $("#a_btn_profile").attr("href", "EditProfile.php");
            } else {
                if (profile[0].you_follower == 0 || profile[0].you_id == null) {
                    $("#button_follow").html("Follow");
                    $("#button_follow").attr("class", $("#button_follow").attr("class") + "  btnFollow follow");

                } else {
                    $("#button_follow").html("Following");
                    $("#button_follow").attr("class", $("#button_follow").attr("class") + "  btnFollow unfollow");
                    $(".unfollow").hover(function () {
                        console.log(3);
                        $(this).attr("class", "btn btn-outline-danger btnFollow unfollow");
                        $(this).html("Unfollow");
                    });
                    $(".unfollow").mouseleave(function () {
                        console.log(3);
                        $(this).attr("class", "btn btn-secondary btnFollow unfollow");
                        $(this).html("Following");
                    });
                }
                $(".btnFollow").click(updateFollow);
                    
            }
            $("#a_btn_profile input").val(parseInt(profile[0].idUsers));
            $("title").html(profile[0].name+" ("+profile[0].user_name+")");
            $("#user_nick").html("@" + profile[0].user_name);
            $("#user_name").html(profile[0].name);
            $("#about").html(profile[0].about);            
            if (profile[0].web != "") {
                aux="<i class='fas fa-globe ml-1'></i> " + profile[0].web;
            }
            if (profile[0].location != "") {
                $("#location").html("<i class='fas fa-map-marker-alt'></i> " + profile[0].location+aux);
            }
            $("#num_post").html(profile[0].num_post);
            $("#num_follower").html(profile[0].followers);
            $("#num_following").html(profile[0].following);
            var img = profile[0].profile_photo;
            document.getElementById("img_profile_main").style.backgroundImage = "url(img/stock/" + img + ")";
            document.getElementById("img_cabecera").style.backgroundImage = "url(img/stock/" + profile[0].image_layout + ")";
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getUserProfile&&id=" + id);



}

function loadPosts(id) {
    console.log(23);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var post = JSON.parse(this.responseText);
            var aux = 0;
            console.log(post[0].length);
            
            if(post[0].length>0){
            
            for (var i = 0; i < post[0].length; i++) {
                if (post[0][i].you_like == 1) {
                    var aux_id = "liked";
                } else {
                    var aux_id = "like";
                }
                $('<div class="col-sm-5 rounded p-0 mb-3 mr-3 rounded container_post"><a href=post.html?id=' + post[0][i].idPost + '><img src="img/stock/' + post[0][i].image_path + '" alt="post1" class="w-100" /> </a> <div class="m-0 px-3 pt-2 pb-2 row description w-100">                    <p class="col-sm text-left mb-0 p-0"><a href="post.html?id=' + post[0][i].idPost + '">' + post[0][i].title + '</a></p>                    <form class="col-sm p-0 m-0 text-right">                        <p class="pl-3 p-0 icons mb-0"><span id="number_likes" class="m-0 my-auto">' + post[0][i].likes + '</span><i class="fas fa-heart ml-2 mr-3 btnLike ' + aux_id + '"></i><span id="number_comments" class="mr-2 my-auto">' + post[0][i].comments + '</span><i class="fas fa-comment-alt" id="comment"></i></p><input type="hidden" id="idPost" value="' + post[0][i]['idPost'] + '"/>   </form></div></div>').appendTo($("#posts"));

                // console.log($("#posts .container_post"));
                console.log($("#posts img").last()[0].naturalWidth);
                if ($("#posts img").last()[0].naturalWidth < 1000) {
                    //console.log(i+"-"+$("#posts img").last()[0].naturalWidth);
                    $("#posts .container_post").last().attr("class", "col-sm-5 rounded p-0 mb-3 mr-3 rounded container_post sm");
                }

                if (i == (post[0].length - 1) && post[0].length % 3 != 0) {
                    $("#posts .container_post").last().attr("class", "col-sm-5 rounded p-0 mb-3 mr-3 rounded container_post");
                }
            }
            $("#loading_post").hide();
            $(".container_post").fadeIn("slow");
            $(".btnLike").on("click", updateLike);
            page++;
            }else{
            $("#loading_post").hide();
                $("#noPost").show();
                
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getAllPostsUsers&&page=" + page + "&&id=" + id);



}



function loadFollowers() {
    var top = ($(document).scrollTop());
    $("#div_followers").html("");
        $('<div class="spinner-border text-primary" role="status" id="loading_section_seguidos">  <span class="sr-only">Loading...</span></div>').appendTo($("#div_followers"));
    event.preventDefault();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var follower = JSON.parse(this.responseText);
            console.log(follower[0]);
            var button;
            var flag;
            $("#num_seguidos h1").html("Followers");

            if (follower[0].length == 0) {
                aux = $('<div class="row my-5 justify-content-center">  <p class="text-center">User don´t have user followers.</p></div>');
                aux.appendTo($("#div_followers"));
            }

            for (var i = 0; i < follower[0].length; i++) {

                var aux;
                flag = true
                if (parseInt(follower[0][i].you_id) == parseInt(follower[0][i].idUsers)) {
                    console.log("pasou");
                    aux = $('<div class="row my-5 justify-content-center container_seguidos">             <a href="profile?id=' + follower[0][i].idUsers + '"><div id="img_profile_follow' + i + '" class="overflow-hidden rounded-circle col-sm-1 mr-3 mb-2  img_profile_follow">      </div> </a>               <div class="col-sm-3 my-auto mr-4 text-center"><a href="profile?id=' + follower[0][i].idUsers + '"><h3 class=" mb-0">' + follower[0][i].name + '</h3></a><p class=" mb-0">@' + follower[0][i].user_name + '</p>                  </div>                <div class="col-sm-1 my-auto  text-center">                               </div>          </div>');
                    flag = false;
                } else {
                    if (follower[0][i].you_follower == 0 || follower[0][i].you_id == null) {
                        aux = $('<div class="row my-5 justify-content-center container_seguidos">         <a href="profile?id=' + follower[0][i].idUsers + '">    <div id="img_profile_follow' + i + '" class="overflow-hidden rounded-circle col-sm-1 mr-3 mb-2  img_profile_follow">      </div>  </a>              <div class="col-sm-3 my-auto mr-4 text-center"><a href="profile?id=' + follower[0][i].idUsers + '"><h3 class=" mb-0">' + follower[0][i].name + '</h3></a><p class=" mb-0">@' + follower[0][i].user_name + '</p>                  </div>                <div class="col-sm-1 my-auto  text-center">                    <form>            <input type="hidden" name="id" value="' + follower[0][i].idUsers + '"/> <button type="button" class="btn btn-secondary btnFollow follow">Follow</button> </form>           </div>          </div>');

                    } else {
                        aux = $('<div class="row my-5 justify-content-center container_seguidos">             <a href="profile?id=' + follower[0][i].idUsers + '"><div id="img_profile_follow' + i + '" class="overflow-hidden rounded-circle col-sm-1 mr-3 mb-2  img_profile_follow">      </div>    </a>            <div class="col-sm-3 my-auto mr-4 text-center"><a href="profile?id=' + follower[0][i].idUsers + '"><h3 class=" mb-0">' + follower[0][i].name + '</h3></a><p class=" mb-0">@' + follower[0][i].user_name + '</p>                  </div>                <div class="col-sm-1 my-auto   text-center">                    <form>            <input type="hidden" name="id" value="' + follower[0][i].idUsers + '"/> <button type="submit" class="btn btn-secondary btnFollow unfollow">Following</button> </form>           </div>          </div>');

                    }
                    $("form").submit(function () {
                        event.preventDefault();
                    });
                }


                aux.appendTo($("#div_followers"));

                if (flag == true) {

                    $(".btnFollow").click(updateFollow);
                    $(".unfollow").hover(function () {
                        console.log(3);
                        $(this).attr("class", "btn btn-outline-danger btnFollow unfollow");
                        $(this).html("Unfollow");
                    });
                    $(".unfollow").mouseleave(function () {
                        console.log(3);
                        $(this).attr("class", "btn btn-secondary btnFollow unfollow");
                        $(this).html("Following");
                    });

                }


                var id = "img_profile_follow" + i;
                var img = follower[0][i].profile_photo;
                document.getElementById(id).style.backgroundImage = "url(img/" + img + ")";

            }            
            $("#loading_section_seguidos").hide();
            $(".container_seguidos").css("display", "flex");
            page_follower++;
            $("#section_seguidos").css("top", top + "px");
            /* $('html, body').css({

    'overflow': 'hidden',

    'height': '100%'

});*/
                    $('body').css({
            'overflow': 'hidden',
            'height': '100%'
        });
            $("html").css("height", "100%");
            $("#section_seguidos").show();
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getFollowers&&page=" + page_follower + "&&id=" + id);



}

function loadFollowing() {
    var top = ($(document).scrollTop());
    $("#div_followers").html("");
    $('<div class="spinner-border text-primary" role="status" id="loading_section_seguidos">  <span class="sr-only">Loading...</span></div>').appendTo($("#div_followers"));
    event.preventDefault();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var follower = JSON.parse(this.responseText);
            console.log(follower[0].length);
            var button;
            var flag;
            $("#num_seguidos h1").html("Following");

            if (follower[0].length == 0) {
                aux = $('<div class="row my-5 justify-content-center container_seguidos">  <p class="text-center">User don´t have user following.</p></div>');
                aux.appendTo($("#div_followers"));
            }

            for (var i = 0; i < follower[0].length; i++) {

                var aux;
                flag = true
                if (parseInt(follower[0][i].you_id) == parseInt(follower[0][i].idUsers)) {
                    aux = $('<div class="row my-5 justify-content-center container_seguidos">             <a href="profile?id=' + follower[0][i].idUsers + '"><div id="img_profile_follow' + i + '" class="overflow-hidden rounded-circle col-sm-1 mr-3 mb-2   img_profile_follow">      </div></a>                <div class="col-sm-3 my-auto mr-4 text-center"><a href="profile?id=' + follower[0][i].idUsers + '"><h3 class=" mb-0">' + follower[0][i].name + '</h3></a><p class=" mb-0">@' + follower[0][i].user_name + '</p>                  </div>                <div class="col-sm-1 my-auto  text-center">                               </div>          </div>');
                    flag = false;
                } else {
                    if (follower[0][i].you_follower == 0 || follower[0][i].you_id == null) {
                        aux = $('<div class="row my-5 justify-content-center container_seguidos">             <a href="profile?id=' + follower[0][i].idUsers + '"><div id="img_profile_follow' + i + '" class="overflow-hidden rounded-circle col-sm-1 mr-3 mb-2  img_profile_follow">      </div>     </a>           <div class="col-sm-3 my-auto mr-4 text-center"><a href="profile?id=' + follower[0][i].idUsers + '"><h3 class=" mb-0">' + follower[0][i].name + '</h3></a><p class=" mb-0">@' + follower[0][i].user_name + '</p>                  </div>                <div class="col-sm-1 my-auto text-center">                    <form>            <input type="hidden" name="id" value="' + follower[0][i].idUsers + '"/> <button type="button" class="btn btn-secondary btnFollow follow">Follow</button> </form>           </div>          </div>');

                    } else {
                        aux = $('<div class="row my-5 justify-content-center container_seguidos">             <a href="profile?id=' + follower[0][i].idUsers + '"><div id="img_profile_follow' + i + '" class="overflow-hidden rounded-circle col-sm-1 mr-3 mb-2  img_profile_follow">      </div>  </a>              <div class="col-sm-3 my-auto mr-4 text-center"><a href="profile?id=' + follower[0][i].idUsers + '"><h3 class=" mb-0">' + follower[0][i].name + '</h3></a><p class=" mb-0">@' + follower[0][i].user_name + '</p>                  </div>                <div class="col-sm-1 my-auto text-center">                    <form>            <input type="hidden" name="id" value="' + follower[0][i].idUsers + '"/> <button type="submit" class="btn btn-secondary btnFollow unfollow">Following</button> </form>           </div>          </div>');

                    }
                    $("form").submit(function () {
                        event.preventDefault();
                    });
                }


                aux.appendTo($("#div_followers"));


                if (flag == true) {
                    $(".btnFollow").click(updateFollow);
                    $(".unfollow").hover(function () {
                        console.log(3);
                        $(this).attr("class", "btn btn-outline-danger btnFollow unfollow");
                        $(this).html("Unfollow");
                    });

                    $(".unfollow").mouseleave(function () {
                        console.log(3);
                        $(this).attr("class", "btn btn-secondary btnFollow unfollow");
                        $(this).html("Following");
                    });
                }

                var id = "img_profile_follow" + i;
                var img = follower[0][i].profile_photo;
                document.getElementById(id).style.backgroundImage = "url(img/" + img + ")";

            }
                                $("#loading_section_seguidos").hide();
            $(".container_seguidos").css("display", "flex");
            page_follower++;
            $("#section_seguidos").css("top", top + "px");
              $('body').css({
            'overflow': 'hidden',
            'height': '100%'
        });
            $("html").css("height", "100%");
            $("#section_seguidos").show();
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getFollowing&&id=" + id + "&&page=" + page_follower);



}
/*
function follow() {
    event.preventDefault();
    var id = $(this).prev().val();
    console.log(id);
    var element = $(this);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var ok = (this.responseText);
            console.log(ok);
            if (ok == "true") {
                console.log(this);
                element.attr("class", "btn btn-secondary unfollow");
                element.html("Following");
                $(".unfollow").hover(function () {
                    console.log(3);
                    $(this).attr("class", "btn btn-outline-danger unfollow");
                    $(this).html("Unfollow");
                });
                $(".unfollow").mouseleave(function () {
                    console.log(3);
                    $(this).attr("class", "btn btn-secondary unfollow");
                    $(this).html("Following");
                });
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=follow&&page=" + page_follower + "&&idFollower=" + id);



}

function unfollow() {
    event.preventDefault();
    var id = $(this).prev().val();
    console.log(id);
    var element = $(this);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var ok = (this.responseText);
            console.log(ok);
            if (ok === "true") {
                element.attr("class", "btn btn-secondary unfollow");
                element.html("Follow");
            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=unFollow&&idFollower=" + id);
}*/

function updateFollow() {
    event.preventDefault();
    var element = $(this);
    var id = $(this).prev().val();
    var aux = "";
    if (element.hasClass("unfollow") == true) {
        aux = "unFollow";
    } else {
        aux = "follow";
    }
    $.ajax({
            url: "Actions.php",
            type: "POST",
            data: {
                "function": aux,
                "idFollower": id
            }
        })
        .done(function (data) {
            var respuesta = (data);
            console.log(respuesta);
            if (respuesta == "true") {
                if (aux == "follow") {
                    console.log(3);
                    element.toggleClass("follow");
                    element.toggleClass("unfollow");
                    element.html("Following");
                    $(".unfollow").hover(function () {
                        if ($(this).hasClass("unfollow") == true) {
                            $(this).attr("class", "btn btn-outline-danger btnFollow unfollow");
                            $(this).html("Unfollow");
                        }
                    });
                    $(".unfollow").mouseleave(function () {
                        console.log(3);
                        if ($(this).hasClass("unfollow") == true) {
                            $(this).attr("class", "btn btn-secondary btnFollow unfollow");
                            $(this).html("Following");
                        }else{
                             $(this).attr("class", "btn btn-secondary btnFollow follow");
                        }
                    });
                } else {
                    console.log(33);
                    element.toggleClass("unfollow");
                    element.toggleClass("follow");
                    element.html("Follow");
                }
            }
        });


}

function comprobarSession() {
    event.preventDefault();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var ok = JSON.parse(this.responseText);
            console.log(ok[0]);
            if (ok[0] === "false") {
                $("#modal").remove();
                $('<div class="modal" tabindex="-1" id="modal">  <div class="modal-dialog">    <div class="modal-content">      <div class="modal-header">        <h5 class="modal-title">Join to</h5>        <button type="button" class="close" data-dismiss="modal" aria-label="Close">          <span aria-hidden="true">&times;</span>        </button>      </div>      <div class="modal-body">        <p>Discover more art work in a comunnity over 20.000 users.</p>      </div>      <div class="modal-footer">        <a href="SignUp"><button type="button" class="btn btn-primary">Sign Up</button></a>                      </div>  <p>Do you have an account? <a href="Login" class="text-primary">Login</a></p>   </div>  </div></div>').appendTo($("main"));
                $(".close").click(function () {
                    $("#modal").hide();
                });
                $("#modal").show();
            } else {

            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=comprobarSession_AJAX");



}

function getParameterUrl() {
    var url = window.location.search.substring(1);
    var aux = url.split('?');
    console.log(aux[4]);
    if (aux[0] != undefined) {
        if (aux[0].substring(0, 2) == "id") {
            return aux[0].substring(3, aux[0].length)
        }
    } else {

        return null;
    }
}

/* Formtatea celda cuando tamaño de pantalla es el mas grande */

function changeSize(img, num) {
   if(screen.width<=950){
       
   }else{
       if(screen.width<=558){
           
       }else{
           
       }
   }
}
