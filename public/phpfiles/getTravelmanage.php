<?php
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:application/json;charset=utf-8");

    
    require_once("./connect_cgd103g4.php");
		//sql 指令
    $sql = "select 
    f.package_order_no, e.package_name, f.package_total, d.mem_no, d.mem_name, f.package_pay_status, f.package_order_date, f.package_ticket_amount 
    from package_order f
    join travel_package e on(e.package_no = f.package_no_fk) 
	  join member d on (f.mem_no = d.mem_no) order by package_order_no";
    //編譯, 執行
    $items = $pdo->query($sql);
    $itemsRow = $items->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($itemsRow);
?>