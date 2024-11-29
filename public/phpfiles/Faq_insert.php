<?php
// 解決跨域問題
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try{
	require_once("./connect_cgd103g4.php");
	// sql 指令
	// 跟資料庫表格的欄位數目必須相等
	$sql = "insert into faq values (
			null,
			:faq_type,
			:faq_q,
			:faq_a,
			:faq_status
			)";
	// 編譯, 執行
	$faq = $pdo->prepare($sql);
	$faq->bindValue(":faq_type", $_POST["faq_type"]);
	$faq->bindValue(":faq_q", $_POST["faq_q"]);
	$faq->bindValue(":faq_a", $_POST["faq_a"]);
	$faq->bindValue(":faq_status", $_POST["faq_status"]);
	$faq->execute();

	$msg = "已成功新增一筆常見問題";
}
// 成功連上後，如果有錯會跳訊息
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine()."<br>錯誤訊息 : ".$e->getMessage();
}

// 輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>