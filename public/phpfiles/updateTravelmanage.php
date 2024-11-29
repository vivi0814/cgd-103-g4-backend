<?php
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:application/json;charset=utf-8");

    try{
		require_once("./connect_cgd103g4.php");
		//sql 指令
		$sql = "update `package_group` set 
            departure_date = :departure_date, 
            package_price = :package_price, 
            max_attendees = :max_attendees, 
            registration_date = :registration_date,
            closing_date = :closing_date

            where group_id = :group_id";
		//編譯, 執行
		$items = $pdo->prepare($sql);	
		$items->bindValue(":departure_date", $_POST["departure_date"]);
		$items->bindValue(":package_price", $_POST["package_price"]);
		$items->bindValue(":max_attendees", $_POST["max_attendees"]);
		$items->bindValue(":registration_date", $_POST["registration_date"]);
		$items->bindValue(":closing_date", $_POST["closing_date"]);
		$items->bindValue(":group_id", $_POST["group_id"]);
		$items->execute();	

        $msg = "新增成功";
	} catch (PDOException $e) {
		$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
	}	
    echo json_encode($msg)
?>