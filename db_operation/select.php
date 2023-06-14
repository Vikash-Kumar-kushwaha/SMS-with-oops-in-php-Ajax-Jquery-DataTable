<?php
session_start();
require_once "../db_operation/databaseOperation.php";


$obj = new databaseOperation();


$simpleQuery = "";

$simpleQuery = $obj->select();
if (mysqli_num_rows($simpleQuery) > 0) {
    while ($info = mysqli_fetch_assoc($simpleQuery)) {
        $fileNames = '';

        if (!empty($info['uploadfile'])) {
            $arrFile = explode(",", $info['uploadfile']);

            foreach ($arrFile as $value) {
                $file_name = basename($value);

                ob_start(); ?>
                <a class="btn btn-success py-1 px-1" title="Download file" href="<?php echo $value; ?>"
                    download="<?php echo $file_name; ?>">
                    <img class="text-white" src="../fileUpload/file-earmark-arrow-down.svg" alt="svg image">
                </a>
                <?php
                // Capture the output and append it to the variable
                $fileNames .= ob_get_clean();
            }
        } else {
            $fileNames = "No file avilable";
        }
        $info["uploadfile"] = $fileNames;

        ob_start();
        ?>
        <button name="viewEye" type="submit" class="eye-btn border-0 bg-body"
            data-student-id="<?php echo $info['studid']; ?>"><i class="fas fa-eye"></i></button>
        <?php
        // Capture the output and assign it to the 'view' column
        $info['view'] = ob_get_clean();

        // Start output buffering for Operation buttons
        ob_start();
        ?>
        <?php if ($_SESSION["role"] === "admin"): ?>
            <button data-delete-studid="<?php echo $info['studid']; ?>" class="btn btn-danger btn-sm" type="submit"
                name="deleteuser" value="deleteuser">
                <i class="fas fa-trash"></i>
            </button>
        <?php endif; ?>
        <button type="submit" name="update-btn" id="openButton" data-student-id="<?php echo $info['studid']; ?>"
            class="btn dialogbtn btn-sm btn-success">
            <i class="fas fa-edit"></i>
        </button>
        <?php
        // Capture the output and assign it to the 'operation' column
        $info['operation'] = ob_get_clean();

        $data[] = $info;
    }
}
if (!empty($data)) {
    echo json_encode(['data' => $data]);
} else {
    echo "<h2>no record found</h2>";
}

?>