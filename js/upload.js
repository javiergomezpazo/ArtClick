$(document).ready(function () {
    console.log(1);
    loadCategories();
    $("form").submit(function () {
        event.preventDefault();
    });
    $("#form").submit(uploadPost);
    $("#form input").val("");
    $("#form textarea").val("");
    $("#img").change(function () {
        var image_size = $("#img")[0].files[0].size;
        var max_size = $("#img").attr("size");
        console.log((image_size / 1024) / 1024);
        console.log($("#img").val());

        var ext = $("#img")[0].files[0].name;

        ext = ext.split(".");

        ext = ext[(ext.length - 1)];

        if (parseInt((image_size / 1024) / 1024) <= max_size) {
            if (ext == "jpg" || ext == "jpeg" || ext == "png"|| ext=="JPG") {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // $("#img_post").css("background-image", "url('" + e.target.result + "')");
                    console.log(e.target.result);
                    $("#img_post img").attr("src", e.target.result);
                    $("#img_post img").on("load", function () {
                        $("#loading_post").hide();
                        $("#img_post img").show();
                    });
                };

                reader.readAsDataURL($("#img")[0].files[0]);
                $("input[name='img_server']").attr("value", $("#img").val());

                $("#first_action").hide();
                $("#second_action").show();
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

    });
});


function loadCategories() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var categories = JSON.parse(this.responseText);
            var select = $("select[name='category']");
            for (var i = 0; i < categories.length; i++) {
                var option = $("<option value='" + categories[i].idCategorie + "'>" + categories[i].name + "</option>");
                option.appendTo(select);

            }
        }
    };
    xhttp.open("POST", "Actions.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("function=getCategories");

}

function uploadPost(e) {
    /* console.log(23);
     var title = $("input[name='title']").val();
     var description = $("textarea").val();
     console.log(description);
     var category = $("select[name='category']").val();
     var image_path= $("#img").val();
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function () {
         if (this.readyState == 4 && this.status == 200) {
             var respuesta = this.responseText;
             console.log(respuesta);
             if (respuesta == "true") {
                location.reload();
             } else {
                 console.log(5);
                 $(".modal h5").html("Error");
                 $(".modal p").html("Your file can not upload. Sorry.");
                 $(".modal").modal('show');
             }

         }
     };
     xhttp.open("POST", "Actions.php", true);
     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     xhttp.send("function=uploadPost" + "&&title=" + title + "&&description=" + description + "&&category=" + category + "&&image_path=" + image_path);*/


    e.preventDefault();
    var f = $(this);
    var formData = new FormData(document.getElementById("form"));
    formData.append("function", "uploadPost");
    formData.append('image_path', $("#img")[0].files[0]);
    formData.append('title', $("input[name='title']").val());
    formData.append('description', $("textarea").val());
    formData.append('category', $("select[name='category']").val());
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
                $(".modal p").html("Your file can not upload. Sorry.");
                $(".modal").modal('show');
            }
        });


}
