<?php
session_start();
// echo "in update.php";
$conn = mysqli_connect("localhost", "root", "", "studentinfo") or die("connection failed: " . mysqli_connect_error());

$response = array();


// $skill = "";

// foreach ($_POST["skill"] as $value) {
//     $skill .= $value . ",";
// }
try {
    $id = $_POST['Studid'];
    $fName = $_POST['FullName'];
    $fatherName = $_POST['fathername'];
    $motherName = $_POST['mothername'];
    $dob = $_POST['dateofbirth'];
    $gender = $_POST['GenderVal'];
    $mail = $_POST['Email'];
    $educationlvl = $_POST["edulevel"];
    $dept = $_POST["dept"];
    $mob = $_POST['mobNumber'];
    $add = $_POST['add'];

    if ($_SESSION["role"] === "user") {
        $u_name = $_POST['user_name'];
        $query = "UPDATE STUDENT1 SET StudName='$fName',fatherName='$fatherName',motherName='$motherName',gender='$gender',dob='$dob',mail='$mail',educationlvl='$educationlvl',dept_id='$dept',mob='$mob',addr='$add',user='$u_name' WHERE studid='$id'";
        $_SESSION["id"] = $u_name;
    } else {
        $query = "UPDATE STUDENT1 SET StudName='$fName',fatherName='$fatherName',motherName='$motherName',gender='$gender',dob='$dob',mail='$mail',educationlvl='$educationlvl',dept_id='$dept',mob='$mob',addr='$add' WHERE studid='$id'";

    }
    $result2 = mysqli_query($conn, $query);
    if ($result2) {
        $response["status"] = "success";
        $response["message"] = "Update successful";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error occur while querying";
    }


} catch (Exception $e) {
    // Update failed
    $response["status"] = "error";
    $response["message"] = "This username is already taken. Please try a different username.";
    // echo $e->getMessage();
}

echo json_encode($response);

// if ($result2) {
//     echo "<script>alert('Data Updated successfully'); window.location='index.php'</script>";
// } else {
//     echo mysqli_error($conn);
// }
?>