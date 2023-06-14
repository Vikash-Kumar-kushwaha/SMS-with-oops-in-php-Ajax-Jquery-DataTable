<?php

$conn = mysqli_connect("localhost", "root", "", "studentinfo") or die("connection failed: " . mysqli_connect_error());
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['sportsFile']['name']) && isset($_POST['sport-heading']) && isset($_POST['sport-content'])) {
        //file handler
        $imgName = $_FILES['sportsFile']['name'];
        $imgTempName = $_FILES['sportsFile']['tmp_name'];
        $target_file = '../fileUpload/card-images' . basename($imgName);
        move_uploaded_file($imgTempName, $target_file);

        $heading = $_POST['sport-heading'];
        // $textContent = $_POST['sport-content'];
        $textContent = mysqli_real_escape_string($conn, $_POST["sport-content"]);

        $sql = "INSERT INTO curriculum_vitae (img,heading,text) VALUES ('$target_file', '$heading', '$textContent')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error occur while querying";
        } else {
            echo "data inserted succesfully";
        }

    } else {
        echo "Wrong data force to error";
    }
} else {

    $sql = "SELECT img, heading, text FROM curriculum_vitae"; // Modify the query to suit your table structure
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ob_start();
            ?>
            <div class="card" style="width: 18rem; height: 23rem;">
                <img src="<?php echo $row['img'] ?>" class='card-img-top' alt='...' width=286 height=189>
                <div class='card-body overflow-auto'>
                    <h4 id='title'><?php echo $row['heading'] ?></h4>
                    <p class='card-text'><?php echo $row['text'] ?></p>
                </div>
            </div>
            <?php
        }
        ob_get_contents();
        // ob_clean();
        // echo json_encode($htmlElement);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
}

?>