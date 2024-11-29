<?php
// 解決跨域問題
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");

try{
	require_once("./connect_cgd103g4.php");

    // $items = $_POST["items"];
    // 017,018

    // $items = array($_POST["items"]);
    // '017,018'

    // $items = array('014', '015'); // 測試可以刪除

    $items = explode(',', $_POST['items']);

    // sql 指令
    $sql = "delete from faq where faq_no = :faq_no;";
    $faq = $pdo->prepare($sql);
    foreach ($items as $item) {
        $faq->bindParam(":faq_no", $item);
        $faq->execute();
    }

	$msg = "已成功刪除多筆常見問題";
}
// 成功連上後，如果有錯會跳訊息
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}

// 輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>