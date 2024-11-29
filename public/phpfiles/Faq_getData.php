<?php
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:application/json;charset=utf-8");
    
	require_once("./connect_cgd103g4.php");
    // sql 指令
    $sql = "select * from `faq`";
    $faq = $pdo->query($sql);
    $faqs = $faq->fetchAll();
    $data=[];
    // foreach($faqs as $i=> $page){
    //       $data[]=$page;
    // }
    foreach($faqs as $i=> $page){
        $data[]=[
            'faq_no' => strval($page['faq_no']),
            'faq_type' => $page['faq_type'],
            'faq_q' => $page['faq_q'],
            'faq_a' => $page['faq_a'],
            'faq_status' => intval($page['faq_status'])
        ];
    }
    echo json_encode($data);
?>