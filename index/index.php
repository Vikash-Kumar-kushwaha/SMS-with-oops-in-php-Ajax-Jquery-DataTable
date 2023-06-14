<?php
session_start();
require_once '../ExceptionHandling/error_handler.php';
include '../oopsLogic/WebContent.php';

$obj = new WebContent();

WebContent::header();

// WebContent::initDatabase();

WebContent::Content();

WebContent::footer();

// var obj = new WebContent();
// $response = obj->getDeptData()
?>