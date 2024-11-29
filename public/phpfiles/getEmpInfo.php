<?php 
session_start();
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./connect_cgd103g4.php");

$empId=$_REQUEST['empId'];
$sql = "select * from emp where emp_no = {$empId}";
$empber = $pdo->query($sql);
$empRows = $empber->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($empRows);
?>