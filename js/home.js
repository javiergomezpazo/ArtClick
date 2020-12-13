var page = 1;

$(document).ready(function () {
    loadPosts();
    console.log(1);
    $("form").submit(function () {
        event.preventDefault();
    });

});

window.onresize = function (event) {
    if ($("footer").css("position") == "absolute") {
        if ($(window).width() < 577) {
            $("footer").css("position", "relative");
        }
    }
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

function loadPosts() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var post = JSON.parse(this.responseText);
            console.log(post.number_page);
            if (post.number_page != 0) {
                for (var i = 0; i < post[0].length; i++) {
                    console.log(post[0][i]['idUsers']);
                    if (post[0][i]['you_like'] == 1) {
                        var aux = "liked";
                    } else {
                        var aux = "like";
                    }
                    $('<div class="post rounded col-sm-5 mt-3 p-0 pb-0 ml-3"><div class="row mt-1 w-100 p-3 ">                        <a href="profile?id=' + post[0][i]['idUsers'] + '" class="col-sm-2 ml-1 mr-2 ">                            <div class="img_profile_post overflow-hidden rounded-circle " id="img_profile_post_' + i + '">                            </div>  </a>   <div class="col-sm m-0">                            <h3 class="title mb-1"><a href="post?id=' + post[0][i]['idPost'] + '">' + post[0][i]['title'] + '</a></h3> <p class="font-weight-light mb-0 ml-2 mt-0">by <a href="profile?id=' + post[0][i]['idUsers'] + '">@' + post[0][i]['user_name'] + '</a></p>                        </div>   <p class="col-sm-1 p-0 m-0 text-right font-weight-light pt-2">5h</p> </div>  <div class="container_img"><a href="post?id=' + post[0][i]['idPost'] + '"><img src="img/' + post[0][i]['image_path'] + '" alt="" class="w-100" /></a>   </div>  <div class="mt-0 p-3 pt-4 row">  <form class="col-sm p-0 m-0">                            <p class="pl-3 p-0 icons"><span id="number_likes" class="m-0 my-auto">' + post[0][i]['numberLikes'] + '</span><i class="fas fa-heart ml-2 mr-3 btnLike ' + aux + '"></i><span id="number_comments" class="mr-2 my-auto">' + post[0][i]['numberComment'] + '</span><i class="fas fa-comment-alt" id="comment"></i></p>  <input type="hidden" id="idPost" value="' + post[0][i]['idPost'] + '"/>                        </form> <div class="dropdown col-sm text-right">                            <a class="" type="button" id="dropdownShareButton" data-toggle="dropdown"> <i class="fas fa-share ml-2" id="share"></i>                            </a>                            <div class="dropdown-menu" aria-labelledby="dropdownShareButton">                                <a class="dropdown-item" href="https://twitter.com/share">Share in  <i class="fab fa-twitter ml-2"></i></a>                                <a class="dropdown-item" href="http://www.facebook.com/sharer.php?u=post?id=' + post[0][i]['idPost'] + '">Share in  <i class="fab fa-facebook-f ml-2"></i></a>                                <a class="dropdown-item" href="post?id=' + post[0][i]['idPost'] + '" onclick="copyToClipboard(this)">Copy link  <i class="fas fa-link ml-2"></i></a>       </div>                        </div>               </div>      </div>').appendTo($("#div_container_post"));

                    var img = post[0][i]['profile_photo'];
                    var id = 'img_profile_post_' + i;
                    document.getElementById(id).style.backgroundImage = "url(img/" + img + ")";
                }

                $(".btnLike").on("click", updateLike);

                $("footer").css("position", "relative");


            } else {
                $("<p class='text-center'><a href='##'>Discover new artist</a></p>").appendTo($("#div_container_post"));
                if ($(window).width() < 577) {
                    $("footer").css("position", "relative");
                }
            }

            $("#loading").hide();
            $("#div_container_post").css("display", "flex");
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('function=getPostsHome&&page=' + page);

}
