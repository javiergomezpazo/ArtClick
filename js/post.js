var months = ["January",
"February",
"March",
"April",
"May",
"June",
"July",
"August",
"September",
"October",
"November",
"December"];

var title;

var image_post;

var pageComments = 1;

var total_page_comments;

var n = 0;

$(document).ready(function () {
    console.log(1);
    loadComments();
    uploadPost();
    $("form").submit(function () {
        event.preventDefault();
    });
    $("#form").submit(uploadPost);
    $("#form_comment").submit(sendComment);
    $("#expand_image").click(function () {
        var img = $("#img_post").attr("src");
        console.log(img);
    });
    $("#expand_image").click(openExpandImage);
    $("#contraer_img").click(closeExpandImage);
});


$(document).resize(function () {
    container.css("height", screen.height);
});

function loadComments() {
    var id = getParameterUrl();
    $('#comments').html('');
    if (id == null) {

    } else {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                console.log(JSON.parse(this.responseText));
                if (this.responseText == "<empty string>") {

                } else {
                    if (pageComments > 1) {
                        $("#section_more_comment").remove();
                    }
                    var comments = JSON.parse(this.responseText);
                    console.log(comments);
                    for (var i = 0; i < comments[0].length; i++) {
                        var date = dates_post(comments[0][i].date);
                        $("<div class='comment mb-4'>                        <div class='row w-100 mb-3'>         <a href='profile?id=" + comments[0][i].idUser + "'> <div class='overflow-hidden rounded-circle col-sm ml-3 img_profile_coments' id=' img_profile_coments_" + n + "'>                             </div></a> <div class='col-sm my-auto mr-0 text-LEFT'>                                <a href='profile?id=" + comments[0][i].idUser + "'><h5 class=' mb-0 name_user_comment'>" + comments[0][i].name + "</h5></a>                                <p class='mb-0 nick_user_comment' >@" + comments[0][i].user_name + "</p>                            </div>                            <p class='col-sm-1 text-right font-weight-light'>" + date + "</p>   </div>              <p class='mb-3'>" + comments[0][i].text + "</p></div>").appendTo($("#comments"));
                        var id = " img_profile_coments_" + n;
                        var img = comments[0][i].profile_photo
                        document.getElementById(id).style.backgroundImage = "url(img/stock/" + img + ")";

                        n++;
                    }

                    if (pageComments == 1) {
                        total_page_comments = comments.number_page;
                    }
                    if (pageComments < total_page_comments) {
                        $('<div class="text-center" id="section_more_comment"><button type="button" class="btn btn-outline-secondary" id="more_comment">Load more comments</button></div>').appendTo("#comments");
                        $("#more_comment").click(loadComments);
                    }

                    pageComments++;

                }

            }
        };
        xhttp.open("POST", "Actions.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("function=getComments&&id=" + id + "&&page=" + pageComments);
    }
}

function dates_post(d) {
    var date_post = new Date(d);
    var date_now = new Date();
    var date_return;
    console.log(date_now.getUTCDate());
    console.log(date_post.getDay());
    if (date_now.getYear() == date_post.getYear()) {
        if (date_now.getMonth() == date_post.getMonth()) {
            if (date_now.getUTCDate() == date_post.getUTCDate()) {
                if (date_now.getHours() == date_post.getHours()) {
                    if (date_now.getMinutes() == date_post.getMinutes()) {
                        date_return = "0min";
                    } else {
                        date_return = (date_now.getMinutes() - date_post.getMinutes()) + "min";
                    }
                } else {
                    date_return = (date_now.getHours() - date_post.getHours()) + "h";
                }
            } else {
                date_return = (date_now.getUTCDate() - date_post.getUTCDate()) + "d";
            }
        } else {
            date_return = (date_now.getMonth() - date_post.getMonth()) + "m";
        }
    } else {
        date_return = (date_now.getYear() - date_post.getYear()) + "y";
    }
    return date_return;
}

function uploadPost() {
    console.log(23);
    var id = getParameterUrl();
    if (id == null) {

    } else {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var post = JSON.parse(this.responseText);
                console.log(post);
                if (post.you_id == null) {
                    $("#follow").html("");
                } else {
                    if (post.you_follower == 0) {
                        $("#follow").html("Follow")
                    } else {
                        $("#follow").html("Following")
                    }
                }
                if (post.liked != null) {
                    $("#like").toggleClass("like");
                    $("#like").toggleClass("liked");
                }
                $("title").html(post.title + " by " + post.name_user)
                $("#like").click(updateLikePost);
                console.log(post.date_create);
                var date = new Date(Date.parse(post.date_create));
                console.log(date.getDay());
                $("#number_likes").html(post.likes);
                $("#date_post").html(date.getDate() + " " + months[(date.getMonth())] + " " + date.getFullYear());
                $("#title").html(post.title);
                $("#description").html(post.description);
                $("#category").html(post.category);
                $("#category").attr("href", "category?id='" + post.idCategory + "'");
                $("#name_user").html(post.name_user);
                $("#nick_user").html("@" + post.user_name);
                $("#number_comments").html(post.number_comment);
                $("#profile_link").attr("href", "profile?id=" + post.Users_idUsers);

                title = post.title;
                img_post = post.image_path;

                var img = post.profile_photo;

                $("#wallpaper_img").attr("src", "img/stock/" + post.image_path);
                document.getElementById("img_profile_follow").style.backgroundImage = "url(img/stock/" + img + ")";
                document.getElementById("img_profile_write_coments").style.backgroundImage = "url(img/stock/" + img + ")";

                $("#img_post").attr("src", "img/stock/" + post.image_path);
                $("#loading_img").hide();
                $("#container_img_post").css("height", "auto");
                $("#img_post").fadeIn("slow");
                $("#loading_info").hide();
                $("#info").fadeIn("slow");
            }
        };
        xhttp.open("POST", "Actions.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("function=getPost&&id=" + id);

    }

}


function sendComment() {
    console.log(23);
    var id = getParameterUrl();
    var text = $("input[name='text']").val();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var ok = (this.responseText);
            console.log(ok);

            if (ok == "true") {
                $("#number_comments").html(parseInt($("#number_comments").html()) + 1);
                pageComments = 1;
                loadComments();
            }

        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=insertComment&&text=" + text + "&&title=" + title + "&&image_post=" + img_post + "&&id=" + id);



}

function getParameterUrl() {
    var url = window.location.search.substring(1);
    var aux = url.split('?');
    if (aux[0] != undefined) {
        if (aux[0].substring(0, 2) == "id") {
            return aux[0].substring(3, aux[0].length);
        }
    } else {

        return null;
    }
}


function updateLikePost() {
    console.log(55);
    var element = $(this);
    var id = getParameterUrl();
    console.log(id);
    var aux = "";
    if (element.hasClass("liked") == true) {
        aux = "unlike";
    } else {
        aux = "like";
    }
    $.ajax({
            url: "Actions.php",
            type: "POST",
            data: {
                "function": aux,
                "id": id
            }
        })
        .done(function (data) {
            var respuesta = (data);
            console.log(respuesta);
            if (respuesta == "true") {
                if (aux == "like") {
                    element.toggleClass("like");
                    element.toggleClass("liked");
                    element.prev().html(parseInt(element.prev().html()) + 1);
                } else {
                    element.toggleClass("liked");
                    element.toggleClass("like");
                    element.prev().html(parseInt(element.prev().html()) - 1);
                    $(".like").attr("color", "red");

                }


            }

        })

}

/*Expand image post*/

function openExpandImage() {
    var elem = document.documentElement;
    var container = $("#container_img_wallpaper");

    container.css("height", screen.height);
    container.css("display", "flex");
    $('html, body').css({

        'overflow': 'hidden',

        'height': '100%'

    });

    //Mozilla
    if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
    }
    // Google Chrome
    else {
        if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen();
        } else {
            if (elem.requestFullScreen) {
                elem.requestFullScreen();
            }
        }
    }

}

function closeExpandImage() {
    var elem = document.documentElement;
    $("#container_img_wallpaper").css("display", "none");
    $('html, body').css({
        'overflow': 'visible',
        'height': 'auto'
    });


    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.webkitExitFullscreen) {
        /* Safari */
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) {
        /* IE11 */
        document.msExitFullscreen();
    } else if (document.mozExitFullscreen) {
        /* mozilla */
        document.mozExitFullscreen();
    } else if (document.webkitExitFullscreen) {
        /* Google Chrome */
        document.webkitExitFullscreen();
    }

}
