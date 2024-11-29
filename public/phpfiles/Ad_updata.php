<?php
// 解決跨域問題
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try{
	require_once("connect_cgd103g4.php");
	// sql 指令
	// 跟資料庫表格的欄位數目必須相同
	// $id = $_POST['emp_id'];
	$sql = "update emp 
			set emp_name = :emp_name, 
				emp_email = :emp_email,  
				emp_status = :emp_status
			where emp_no = :emp_no";	
	// 編譯, 執行
	$Ad = $pdo->prepare($sql);
	$Ad->bindValue(":emp_no", $_POST["emp_no"]);
	// $Ad->bindValue(":emp_psw", $_POST["emp_psw"]);
	$Ad->bindValue(":emp_name", $_POST["emp_name"]);
	$Ad->bindValue(":emp_email", $_POST["emp_email"]);
	$Ad->bindValue(":emp_status", $_POST["emp_status"]);
	$Ad->execute();

	$msg = "編輯成功";
}
// 成功連上後，如果有錯會跳訊息
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}

// 輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>