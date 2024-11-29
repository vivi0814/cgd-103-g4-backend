<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

require_once("./connect_cgd103g4.php");
$sql = "select * from emp";
$emp = $pdo->query($sql);
$empRows = $emp->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($empRows);
?>