<?php
// 解決跨域問題
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try{
	require_once("connect_cgd103g4.php");
	// require_once("connectG4.php");
	// sql 指令
    $sql = "delete from news where news_no = :news_no;";
	// 編譯, 執行
	$news = $pdo->prepare($sql);
	$news->bindValue(":news_no", $_POST["news_no"]);
	$news->execute();

	$msg = "刪除資料成功";
}
// 成功連上後，如果有錯會跳訊息
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}

// 輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>