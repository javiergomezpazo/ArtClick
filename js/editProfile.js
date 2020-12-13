var id=null;

$(document).ready(function () {
    loadData();
    $("#cancel").click(function (){
            var aux="Profile?id="+id;
            location.replace(aux); 
    });
    $("form").submit(sendData);
    $("#img_cabecera_input").change(change_image);
    $("#img_profile_input").change(change_image);
});


function loadData() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var data = JSON.parse(this.responseText);
            console.log(data);
            if (true) {
                id=data[0].idUsers;
                $("#name").val(data[0].name);
                $("#userName").val(data[0].user_name);
                $("#about").val(data[0].about);
                $("#web").val(data[0].web);
                $("#facebook").val(data[0].facebook);
                $("#instagram").val(data[0].instagram);
                $("#twitter").val(data[0].twitter);

                document.getElementById("img_profile_main").style.backgroundImage = "url(img/stock/" + data[0].profile_photo + ")";
                document.getElementById("img_cabecera").style.backgroundImage = "url(img/stock/" + data[0].image_layout + ")";

            }
            $("#loading_info").hide();
            $("#form").show();
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getUserProfile");



}

function sendData() {
    event.preventDefault();
    var img_profile;
    var img_cabecera;
    if ($("#img_profile_main input")[0].files[0] == undefined) {
        img_profile = "null"
    } else {
        img_profile = $("#img_profile_main input")[0].files[0];
    }
    if ($("#img_cabecera input")[0].files[0] == undefined) {
        img_cabecera = "null"
    } else {
        img_cabecera = $("#img_cabecera input")[0].files[0];
    }
    var f = $(this);
    var formData = new FormData();
    formData.append("function", "updateProfile");
    formData.append('name', $("#name").val());
    formData.append('userName', $("#userName").val());
    formData.append('about', $("#about").val());
    formData.append('biography', $("#biography").val());
    formData.append('web', $("#web").val());
    formData.append('facebook', $("#facebook").val());
    formData.append('instagram', $("#instagram").val());
    formData.append('twitter',  $("#twitter").val());
    formData.append('img_profile', img_profile);
    formData.append('img_cabecera', img_cabecera);
    $.ajax({
            url: "Actions.php",
            type: "post",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false
        })
        .done(function (res) {
            console.log(res);
            if (res == "true") {
                location.reload();
            } else {
                console.log(5);
                $(".modal h5").html("Error");
                $(".modal p").html("Not upload. Sorry.");
                $(".modal").modal('show');
            }
        });
}

function change_image() {
    var id = "#" + $(this).attr("id");
    var img_id;
    var loading_id;
    if (id == "#img_profile_input") {
        img_id = "img_profile_main";
        loading_id = "#loading_img_profile";
    } else {
        if (id == "#img_cabecera_input") {
            img_id = "img_cabecera";
            loading_id = "#loading_img_cabecera";
        }
    }

    console.log(id);
    var image_size = $(id)[0].files[0].size;
    var max_size = $(id).attr("size");
    console.log((image_size / 1024) / 1024);
    console.log($(id).val());

    var ext = $(id)[0].files[0].name;

    ext = ext.split(".");

    ext = ext[(ext.length - 1)];

    if (parseInt((image_size / 1024) / 1024) <= max_size) {
        if (ext == "jpg" || ext == "jpeg" || ext == "png" || ext=="JPG") {
            var reader = new FileReader();

            reader.onload = function (e) {
                // $("#img_post").css("background-image", "url('" + e.target.result + "')");
                console.log(e.target.result);
                 document.getElementById(img_id).style.backgroundImage = "url("+e.target.result+")";
                  $("#"+img_id).attr("src", e.target.result);
                  $("#"+img_id).on("load", function () {
                      console.log("we");
                  });
            };

            reader.readAsDataURL($(id)[0].files[0]);
        } else {
            $(".modal h5").html("Format Invalid.");
            $(".modal p").html("File format must be jpg, jpeg or png.");
            $(".modal").modal('show');
        }
    } else {
        $(".modal h5").html("Size Invalid.");
        $(".modal p").html("File size must be <= 16 MB");
        $(".modal").modal('show');
    }
}
