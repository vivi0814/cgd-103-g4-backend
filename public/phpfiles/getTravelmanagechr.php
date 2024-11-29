<?php
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:application/json;charset=utf-8");

    
    require_once("./connect_cgd103g4.php");
		//sql 指令
    $sql = "select *
    from package_group";
    //編譯, 執行
    $items = $pdo->query($sql);
    $itemsRow = $items->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($itemsRow);
?>