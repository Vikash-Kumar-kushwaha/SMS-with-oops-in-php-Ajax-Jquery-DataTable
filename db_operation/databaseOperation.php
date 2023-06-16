<?php
include "../oopsLogic/WebContent.php";
require_once "../dbConnet/databaseConn.php";

// session_start();


class databaseOperation extends databaseConn
{
    public $response = array();
    public $errors = array();

    public $success = array();
    public function insert()
    {

        try {
            $fName = $_POST["FullName"];
            $fatherName = $_POST["fathername"];
            $motherName = $_POST["mothername"];
            $DOB = $_POST["dateofbirth"];
            $gender = $_POST["GenderVal"];
            $mail = $_POST["Email"];
            $mob = $_POST["mobNumber"];
            $address = $_POST["add"];
            $Skills = null;
            $skill = null;
            $educationlvl = $_POST["edulevel"];
            $dept = $_POST["dept"];
            $folderLocation = null;
            $target_file = null;
            foreach ($_POST["skill"] as $value) {
                $skill .= $value . ",";
                $Skills = $skill;
            }
            // File handling snippet
            $fileName = $_FILES["file"]["name"];
            $allowed_types = array("pdf");
            $profileFile = $_FILES["profilepic"]["name"];
            $profileFileTemp = $_FILES["profilepic"]["tmp_name"];
            $userMail = "";



            //backend form validation---------------
            $flag = 0;
            if (empty($_POST["FullName"])) {
                $this->errors[] = "* Student Full Name Required";
                $flag = 1;
            } else {
                $fName = $this->test_input($_POST["FullName"]);
            }

            if (empty($_POST["fathername"])) {
                $this->errors[] = "* Father Name Required";

                $flag = 1;
            } else {
                $fatherName = $this->test_input($_POST["fathername"]);
            }

            if (empty($_POST["mothername"])) {
                $this->errors[] = "* Mother Name Required";
                $flag = 1;
            } else {
                $motherName = $this->test_input($_POST["mothername"]);

            }

            if (empty($_POST["dateofbirth"])) {
                $this->errors[] = "* Date of Birth Required";
                $flag = 1;
            } else {
                $DOB = $this->test_input($_POST["dateofbirth"]);

            }

            if (empty($_POST["GenderVal"])) {
                $this->errors[] = "* Gender is Required";
                $flag = 1;
            } else {
                $gender = $this->test_input($_POST["GenderVal"]);

            }

            if (empty($_POST["Email"])) {
                $this->errors[] = "* Mail is Required";
                $flag = 1;
            } else {
                $mail = $this->test_input($_POST["Email"]);
                $userMail = strstr($mail, '@gmail.com', true);

            }

            if (empty($_POST["edulevel"])) {
                $this->errors[] = "* Education LEVEL is Required";
                $flag = 1;
            } else {
                $educationlvl = $this->test_input($_POST["edulevel"]);

            }

            if (empty($_POST["dept"])) {
                $this->errors[] = "* Dept is Required";
                $flag = 1;
            } else {
                $dept = $this->test_input($_POST["dept"]);

            }

            if (empty($_POST["mobNumber"])) {
                $this->errors[] = "* Mobile Number is Required";
                $flag = 1;
            } else {
                $mob = $this->test_input($_POST["mobNumber"]);

            }

            if (empty($_POST["add"])) {
                $this->errors[] = "* Address is Required";
                $flag = 1;
            } else {
                $address = $this->test_input($_POST["add"]);

            }

            if (empty($_POST["skill"])) {
                $this->errors[] = "* One Skill is Required";
                $flag = 1;
            } else {
                foreach ($_POST["skill"] as $value) {
                    $skill .= $value . ",";
                    $Skills = $this->test_input($skill);
                }
            }


            // Get the current year
            $year = date("Y");
            $fileExtension = "";
            $profilePicExt = "." . strtolower(pathinfo($_FILES["profilepic"]["name"], PATHINFO_EXTENSION));

            foreach ($_FILES["file"]["name"] as $key => $name) {
                $fileExtension = "." . strtolower(pathinfo($name, PATHINFO_EXTENSION));
            }

            if ($profilePicExt === ".jpg" || $profilePicExt === ".png" || $profilePicExt === ".jpeg") {
                // // Directory where the file will be uploaded
                $profilePicDIr = "../dynamic_folders/" . $year . "-profile-pic" . "/";

                // Create the target directory if it doesn"t exist
                if (!is_dir($profilePicDIr)) {
                    mkdir($profilePicDIr, 0777, true);
                }
            }
            if ($fileExtension === ".pdf") {
                // // Directory where the file will be uploaded
                $targetDirectory = "../dynamic_folders/" . $year . "-documents" . "/";
                // Create the target directory if it doesn"t exist
                if (!is_dir($targetDirectory)) {
                    mkdir($targetDirectory, 0777, true);
                }
            } else {
                $targetDirectory = "../dynamic_folders/" . $year . "/";
                // Create the target directory if it doesn"t exist
                if (!is_dir($targetDirectory)) {
                    mkdir($targetDirectory, 0777, true);
                }
            }

            // File handling snippet

            if (!empty($fileName)) {
                $list = array();

                foreach ($_FILES["file"]["name"] as $key => $name) {
                    $fileTemp = $_FILES["file"]["tmp_name"][$key];
                    $extension = pathinfo($name, PATHINFO_EXTENSION);

                    if (in_array($extension, $allowed_types)) {
                        $uniqueName = time() . "_" . rand(1000, 9999) . "." . $extension;
                        $localLocat = $targetDirectory . $uniqueName;
                        $list[] = $localLocat;
                        $folderLocation = implode(",", $list);
                        move_uploaded_file($fileTemp, $localLocat);
                    }
                }
            }

            if (!empty($profileFile)) {
                $target_file = $profilePicDIr . basename($profileFile);
                move_uploaded_file($profileFileTemp, $target_file);
            }

            if ($flag == 0) {
                $sql = "INSERT INTO STUDENT1 (StudName,fatherName,motherName,dob,gender,mail,educationlvl,dept_id,mob,addr,skills,uploadfile,profilePic,user) 
        VALUES('$fName','$fatherName','$motherName','$DOB','$gender','$mail','$educationlvl','$dept','$mob','$address','$Skills','$folderLocation','$target_file','$userMail')";
                $result = parent::query($sql);
                if (!$result) {
                    $this->errors[] = "Error occur while querying";
                }
            }

        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
            // exceptionHandler($e);
        }

        if (!empty($this->errors)) {
            $this->success[] = "Data successfully inserted";
        }



        if (empty($this->errors)) {
            // $this->response = array(
            //     "status" => "error",
            //     "message" => $this->errors,
            //     "error_code" => 500
            // );
            $this->success[] = "Data inserted successfully";
        }

        return $this->responses($this->errors, $this->success);
        // echo json_encode($this->response);

        // echo json_encode($fullName);
        // Close the database connection
        // mysqli_close($conn);


    }
    public function update()
    {
        session_start();

        // $response = array();
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
            $dept_name = $_POST['dept_name'];

            $data = array(
                'status' => ($this->errors ? 'error' : 'success'),
                'message' => ($this->errors ? $this->errors : ['Update successfully']),
                'data' => array(
                    'studid' => $id,
                    'StudName' => $fName,
                    'fatherName' => $fatherName,
                    'motherName' => $motherName,
                    'dob' => $dob,
                    'gender' => $gender,
                    'mail' => $mail,
                    'educationlvl' => $educationlvl,
                    'dept_id' => $dept,
                    'mob' => $mob,
                    'add' => $add,
                    'dept_name' => $dept_name
                )
            );
            if (isset($_SESSION["role"]) && $_SESSION["role"] === "user") {
                $u_name = $_POST['user_name'];
                $query = "UPDATE STUDENT1 SET StudName='$fName',fatherName='$fatherName',motherName='$motherName',gender='$gender',dob='$dob',mail='$mail',educationlvl='$educationlvl',dept_id='$dept',mob='$mob',addr='$add',user='$u_name' WHERE studid='$id'";
                $_SESSION["id"] = $u_name;

            } else {
                $query = "UPDATE STUDENT1 SET StudName='$fName',fatherName='$fatherName',motherName='$motherName',gender='$gender',dob='$dob',mail='$mail',educationlvl='$educationlvl',dept_id='$dept',mob='$mob',addr='$add' WHERE studid='$id'";

            }
            $result2 = parent::query($query);
            if (!$result2) {
                $error[] = "Error occur while querying";
                // $response["status"] = "success";
                // $response["message"] = "Update successful";
            }
            //  else {
            //     $error["status"] = "error";
            //     $response["message"] = "Error occur while querying";
            // }


        } catch (Exception $e) {
            // Update failed
            // $response["status"] = "error";
            $this->errors[] = "This username is already taken. Please try a different username.";
            // echo $e->getMessage();
        }

        if (empty($errors)) {
            $this->success[] = "Update successfully";
            $response = json_encode($data);

            // Echo the response

        }
        echo $response;
        // return $this->responses($this->errors, $this->success);

    }
    public function delete()
    {
        // $result = "";
        if (isset($_POST["id"]) && $_POST["id"] > 0) {
            $sql = "delete from student1 where studid = " . $_POST["id"];
            $deleteDone = parent::query($sql);

            if (!$deleteDone) {
                // $this->[] = "data deleted successfully";
                $this->errors[] = "Data can not deleted";
                die;
            } else {
                $this->success[] = "Data successfully deleted";
            }
        }
        return $this->responses($this->errors, $this->success);
    }


    public function sorting($column, $sort)
    {
        $sql = "SELECT * FROM student1, department WHERE student1.dept_id = department.dept_id ORDER BY ";
        if ($column === 'studid') {
            $sql .= "student1.studid ";
        } else if ($column === 'StudName') {
            $sql .= "student1.StudName ";
        }

        if ($sort === 'idAsc' || $sort === 'nameAsc') {
            $sql .= "ASC";
        } else if ($sort === 'idDesc' || $sort === 'nameDesc') {
            $sql .= "DESC";
        }
        $result = parent::query($sql);
        return $result;
    }
    public function select()
    {
        $departmentId = isset($_POST['dept']) ? $_POST['dept'] : '';
        $simpleQuery = "";
        if (isset($_SESSION['id']) && $_SESSION['role'] === 'admin') {
            if (!empty($departmentId)) {
                $simpleQuery = "SELECT s.studid,s.StudName,s.mail,s.motherName,s.fatherName,s.dob,d.dept_name,s.uploadfile,s.profilePic, s.gender,s.educationlvl,s.mob,s.addr,s.user,d.dept_id FROM student1 as s, department as d where s.dept_id='$departmentId' AND d.dept_id=s.dept_id";
            } else {
                $simpleQuery = "SELECT s.studid,s.StudName,s.mail,s.motherName,s.fatherName,s.dob,d.dept_name,s.uploadfile,s.profilePic, s.gender,s.educationlvl,s.mob,s.addr,s.user,d.dept_id FROM student1 as s, department as d WHERE s.dept_id = d.dept_id";
            }
        } elseif (isset($_SESSION['id']) && $_SESSION['role'] === 'user') {
            $mail = $_SESSION['id'];
            if (strpos($mail, '@') !== false) {
                $simpleQuery = "SELECT * FROM student1, department WHERE student1.dept_id = department.dept_id AND student1.mail =
            '$mail'";
            } else {
                $simpleQuery = "SELECT * FROM student1, department WHERE student1.dept_id = department.dept_id AND student1.user =
            '$mail'";
            }
        }

        $result = parent::query($simpleQuery);

        return $result;


    }

    public function adminLoginHandler()
    {
        session_start();
        $flag = 0;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['role']) && $_POST['role'] === 'admin' && isset($_POST["username"])) {
            $userNameAd = "";
            $passwordAd = "";
            $sql = "SELECT * FROM admin where role='admin'";
            // echo "in admin";
            $query = parent::query($sql);
            $info = mysqli_fetch_assoc($query);
            $role = $_POST['role'];
            if (!$query) {
                $this->errors[] = "failed connection";
            }
            if (empty($_POST["username"])) {
                $this->errors[] = "*Username is Required";
                $flag = 1;
            } else {
                $userNameAd = $this->test_input($_POST["username"]);
            }

            if (empty($_POST["pswd"])) {
                $this->errors[] = "*Password is Required";
                $flag = 1;
            } else {
                $passwordAd = $this->test_input($_POST["pswd"]);
            }

            if ($flag == 0) {
                $check1 = 0;
                if ($userNameAd == $info['username'] && $role == $info['role']) {

                    $check1 += 1;
                } else {
                    $this->errors[] = "*Wrong Username";
                }

                if ($passwordAd == $info['password'] && $role == $info['role']) {

                    $check1 += 1;
                } else {
                    $this->errors[] = "*Wrong Password";
                }

                if ($check1 === 2) {
                    $_SESSION['id'] = $userNameAd;
                    $_SESSION['role'] = $role;
                    $_SESSION['pass'] = $passwordAd;
                }


            }
        }

        if (empty($this->errors)) {
            $this->success[] = "Operation Successfull";
        }

        return $this->responses($this->errors, $this->success);
    }

    public function userLoginHandler()
    {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['role']) && $_POST['role'] === 'user') {
            $userName = "";
            $password = "";
            $role = $_POST['role'];
            $flag = 0;
            $check = 0;
            if (empty($_POST["userid"])) {
                $this->errors[] = "*Username is Required";
                $flag = 1;
            } else {
                $userName = $this->test_input($_POST["userid"]);
            }

            if (empty($_POST["pass"])) {
                $this->errors[] = "*Password is Required";
                $flag = 1;
            } else {
                $password = $this->test_input($_POST["pass"]);
            }
            if (strpos($userName, '@') !== false) {
                $sql = "SELECT * FROM student1 WHERE mail='$userName'";
            } else {
                $sql = "SELECT * FROM student1 WHERE user='$userName'";
            }
            $query = parent::query($sql);
            if (!$query) {
                echo "SQL Query Error:";
            }
            if ($flag == 0) {
                if (mysqli_num_rows($query) > 0) {
                    while ($info = mysqli_fetch_assoc($query)) {
                        if ($userName === $info['mail'] || $userName === $info['user']) {
                            $check++;
                            // echo "success username";
                        } else {
                            // echo "success username else part";
                            $this->errors[] = "*Wrong Username";
                        }
                        if ($password === $info['mob']) {
                            $check++;
                            // echo "success pass";
                        } else {
                            $this->errors[] = "*Wrong Password";
                        }

                        if ($check === 2) {
                            // echo "success check-2";
                            $_SESSION['id'] = $userName;
                            $_SESSION['pass'] = $password;
                            $_SESSION['role'] = $role;
                            break;
                        }
                    }

                } else {
                    $this->errors[] = "No matching records found";
                }
            }
            // mysqli_close($conn);
        } else {
            $this->errors[] = "server request method failed";
        }
        if (empty($this->errors)) {
            $this->success[] = "Operation Successfull";
        }

        return $this->responses($this->errors, $this->success);
    }

    public function responses(array $errors, array $success)
    {
        if (!empty($this->errors)) {
            $this->response = array(
                "status" => "error",
                "message" => $this->errors,
                "error_code" => 500
            );
        } else {
            $this->response = array(
                "status" => "success",
                "message" => $this->success
            );
        }
        echo json_encode($this->response);
    }


    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}


$dbOperation = new databaseOperation();

if (isset($_POST['action'])) {
    switch ($_POST["action"]) {
        case "insert":
            $dbOperation->insert();
            break;
        case "update":
            $dbOperation->update();
            break;
        case "delete":
            $dbOperation->delete();
            break;
        case "adminLogin":
            $dbOperation->adminLoginHandler();
            break;
        case "userLogin":
            $dbOperation->userLoginHandler();
            break;
        // case "sorting":
        //     $column = $_GET['column'];
        //     $sort = $_GET['sort'];
        //     $dbOperation->sorting($column, $sort);
        //     break;
        // case "read":
        //     $dbOperation->select();
        //     break;
    }
}

?>