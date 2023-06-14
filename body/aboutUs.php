<?php
// $sport_images = array(
//     "basketBall" => "../fileUpload/card-images/basketball.avif",
//     "coPlayer" => "./fileUpload/card-images/coPlayer.avif",
//     "football" => "./fileUpload/card-images/football.avif",
//     "sport" => "./fileUpload/card-images/sport.jpg",
//     "cricket" => "../fileUpload/card-images/cricket.jpg",
//     "kho-kho" => "./fileUpload/card-images/kho-kho.jpg",
//     "kabbadi" => "./fileUpload/card-images/download.jpg",
//     "swiming" => "./fileUpload/card-images/swiming.jpg"

// );

// $len = sizeof($sport_images);
ob_start();
?>
<div class="container mt-2" id="main">
    <div class="banner text-center">
        <h2 class="h2 shadow p-1 mb-1 rounded">University activities</h2>
    </div>
    <form action="" class="d-flex gap-2 justify-content-center" data-activity="sport" enctype="multipart/form-data">
        <div class="form-group">
            <label for="sport-image">Put Image of sport</label>
            <input class="form-control" type="file" name="sportsFile" id="sport-image">
        </div>
        <div class="form-group">
            <label for="sport-heading">Heading</label>
            <input type="text" class="form-control" name="sport-heading" id="sport-heading">
        </div>
        <div class="form-group">
            <label for="sport-text">Content</label>
            <textarea class="form-control" name="sport-content" id="sport-text" cols="30" rows="1"></textarea>
            <!-- <input type="text" class="form-control" name="sport-content" id="sport-text"> -->
        </div>
        <div class="mt-4">
            <input type="submit" class="btn btn-primary" data-activity="sport" value="Submit">

        </div>
    </form>
    <div id="card-handle" class="d-flex justify-content-center align-items-center flex-row gap-2 flex-wrap mt-2">

    </div>
</div>


<?php $htmlElemnt = ob_get_contents(); ?>


<script>
    $(document).ready(function () {
        function loadCardData() {
            $.ajax({
                url: "../db_operation/sportInsert.php",
                type: "get",
                success: function (response) {
                    // var data = JSON.parse(response);
                    // console.log(data.file_path);
                    if (response.hasOwnProperty('error')) {
                        alert('Error occurred while fetching data.');
                    } else {
                        $('#card-handle').html(response);

                    }
                }
            });
        }

        loadCardData();


        $('form').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            console.log(formData);

            $.ajax({
                url: "../db_operation/sportInsert.php",
                type: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // var responses = JSON.parse(response);
                    // console.log(response);
                    alert(response);
                    $("form")[0].reset();
                    loadCardData();
                }
            });
        });
    });
</script>