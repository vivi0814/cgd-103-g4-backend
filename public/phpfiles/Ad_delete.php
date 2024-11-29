<?php
// 解決跨域問題
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try{
	require_once("./connect_cgd103g4.php");
	// sql 指令
    // $id = $_POST['emp_no'];
    $sql = "delete from emp where emp_no = :emp_no;";
	// 編譯, 執行
	$emp = $pdo->prepare($sql);
	$emp->bindValue(":emp_no", $_POST["emp_no"]);
	$emp->execute();

	$msg = "已刪除一筆管理者帳號";
}
// 成功連上後，如果有錯會跳訊息
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}

// 輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>