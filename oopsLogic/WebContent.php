<?php
// session_start();
include '../dbConnet/databaseConn.php';

?>


<?php
class WebContent extends databaseConn
{
    // private static $db;
    public $conn = "";
    public $obj;

    function __construct()
    {

    }

    static function header()
    {

        return include('../head/header.php');
    }
    static function sidebar()
    {
        return include '../sidebar/sidebar.php';
    }
    static function topbar()
    {
        return include '../sidebar/topbar.php';
    }
    static function footer()
    {
        return include '../foot/footer.php';
    }
    static function bodyContent()
    {
        return include '../body/content.php';
    }
    static function adminContent()
    {
        self::sidebar();

        if (isset($_GET["page"])) {
            switch ($_GET['page']) {
                case 'registration':
                    include '../body/registration.php';
                    break;
                case 'totalDeptCount':
                    // $name="Kumar";
                    // $arr = array(
                    //     "name='".$name."'",
                    //     "dept='123'",
                    // );
                    // $deptData = $this->getDeptData("insert_data_dept",$arr);
                    include '../body/totalDept.php';
                    break;
                case 'aboutUs':
                    include '../body/aboutUs.php';
                    break;
                default:
                    self::bodyContent();
                    break;
            }
        } else {
            self::bodyContent();
        }
    }
    static function userContent()
    {
        self::bodyContent();
    }
    static function content($page = '', $id = null, $ajaxResponse = false)
    {
        // $conn = self::$db->getConnection();\

        //index file content
        if (isset($_SESSION["id"]) && isset($_SESSION["pass"])) {
            self::topbar();
            if ($_SESSION["role"] === "admin") {
                self::adminContent();
                self::update();
            } elseif ($_SESSION["role"] === "user") {
                self::userContent();
                self::update();
            } else {
                self::login();
            }
        } else {
            self::login();
        }
        //index file content
    }
    static function login()
    {
        return include '../body/login.php';
    }
    static function update()
    {
        return include '../body/update_modal.php';
    }


    // public function getDeptData($tableName, $dataSet=[]) {
    //     // select query
    //     // $data = [];
    //     // return $data;
    //     return $this->content();
    //     if ($tableName !='' && count($dataSet) > 0) {
    //         $query = "INSERT into ".$tableName." set " . implode(',',$dataSet);

    //     }
    // }




}






?>