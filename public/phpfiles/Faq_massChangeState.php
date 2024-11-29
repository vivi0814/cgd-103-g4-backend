<?php
// 解決跨域問題
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try{
	require_once("./connect_cgd103g4.php");
	
	$items = explode(',', $_POST['items']);
	$status = $_POST['status'];

    // sql 指令
	$sql = "update faq
			set faq_status = :status
			where faq_no = :faq_no";
	$faq = $pdo->prepare($sql);
    foreach ($items as $item) {
		$faq->bindParam(":faq_no", $item);
		$faq->bindParam(":status", $status);
        $faq->execute();
    }
	$msg = "已成功修改多筆常見問題";

}
// 成功連上後，如果有錯會跳訊息
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}

// 輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>