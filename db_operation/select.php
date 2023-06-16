<?php
session_start();
require_once "../db_operation/databaseOperation.php";


$obj = new databaseOperation();


$simpleQuery = "";

$simpleQuery = $obj->select();
if (mysqli_num_rows($simpleQuery) > 0) {
    while ($info = mysqli_fetch_assoc($simpleQuery)) {
        // Capture the output and assign it to the 'operation' column
        if ($_SESSION['role'] === 'admin') {
            $info['role'] = 'admin';
        } elseif ($_SESSION['role'] === 'user') {
            $info['role'] = 'user';
        }

        // if (isset($_GET['dept'])) {
        //     $info['get'] = $_GET['dept'];
        // }
        $data[] = $info;
    }
}
if (!empty($data)) {
    echo json_encode(['data' => $data]);
} else {
    echo "<h2>no record found</h2>";
}

?>