<?php
// 解決跨域問題
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try{
	// require_once("connect_G4.php");
	require_once("connect_cgd103g4.php");
	// sql 指令
	$sql = "update `news` 
			set news_last_edit = :news_last_edit,  
				news_type = :news_type, 
				news_title = :news_title, 
				news_text_start = :news_text_start, 
				news_text_middle = :news_text_middle, 
				news_text_trans = :news_text_trans,
				news_text_end = :news_text_end, 
				news_img_des = :news_img_des, 
				news_status = :news_status,
				news_time = :news_time
			where news_no = :news_no";

			

	// 編譯, 執行  
	$news = $pdo->prepare($sql);
	$news->bindValue(":news_no", $_POST["news_no"]);
	$news->bindValue(":news_last_edit", $_POST["news_last_edit"]); //抓取時間函式待寫 
	$news->bindValue(":news_time", $_POST["news_time"]); //上架
	$news->bindValue(":news_type", $_POST["news_type"]);
	$news->bindValue(":news_title", $_POST["news_title"]);
	$news->bindValue(":news_text_start", $_POST["news_text_start"]);
	$news->bindValue(":news_text_middle", $_POST["news_text_middle"]);
	$news->bindValue(":news_text_trans", $_POST["news_text_trans"]);
	$news->bindValue(":news_text_end", $_POST["news_text_end"]);
	// $news->bindValue(":news_img", $_POST["news_img"]); //圖片問題待處理，上方還沒新增
	$news->bindValue(":news_img_des", $_POST["news_img_des"]);
	$news->bindValue(":news_status", $_POST["news_status"]);


	$news->execute();

	$msg = "已成功編輯資料";
}
// 成功連上後，如果有錯會跳訊息
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}

// 輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>