<?php
    header('Access-Control-Allow-Origin:*');
    header("Content-Type:application/json;charset=utf-8");

	const MY_DIR = "../../front/img/Scape"; //路徑  //for打包後的環境
	// const MY_DIR = "../img/abc"; //路徑  //for打包前的環境



	switch($_FILES["package_pic"]["error"] ){
		case UPLOAD_ERR_OK : 
			
			if( file_exists(MY_DIR) == false){ //如果資料夾不存在，就建立資料夾
				mkdir(MY_DIR); //make directory(建立目錄)
			}
			$from = $_FILES["package_pic"]["tmp_name"];
	
			//$_FILES["news_img"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
			$fileExt = pathinfo($_FILES["package_pic"]["name"],PATHINFO_EXTENSION); //取得副檔名
			$fileName = uniqid() . ".". $fileExt; //決定檔案名稱, 如a313feexrer.gif
			$to = MY_DIR . "/". $fileName; //決定路徑名稱
			if(copy( $from, $to)){
				$msg = "上傳成功";
			}else{
				$msg = "上傳失敗";
			}
			break;
		case UPLOAD_ERR_INI_SIZE:
			$msg = "上傳檔案太大,不能超過 ". ini_get("upload_max_filesize") ;	
			break;
		case UPLOAD_ERR_FORM_SIZE:
			$msg = "上傳檔案太大,不能超過 ".$_POST["MAX_FILE_SIZE"];			    
			break;
		case UPLOAD_ERR_PARTIAL:
			$msg = "上傳檔案不完整";
			break;
		case UPLOAD_ERR_NO_FILE:
			$msg = "没有上傳檔案";
			break;
		default:
			$msg = "上傳檔案失敗，錯誤代碼: ".$_FILES["error"]."請通知系統開發人員";
	}
	
	if( $_FILES["package_pic"]["error"] === 0){


    try{
		require_once("./connect_cgd103g4.php");
		//sql 指令
		$sql = "insert into `travel_package` values (
            null, 
            :package_name, 
            current_date(), 
            :package_status, 
            :package_price, 
            :package_title, 
			:package_subtitle,
            :package_des,
            :package_tag,
            :package_pic,
            :package_buy,
            :package_indes
			)";


		//編譯, 執行
		$items = $pdo->prepare($sql);	
		$items->bindValue(":package_name", $_POST["package_name"]);
		$items->bindValue(":package_status", $_POST["package_status"]);
		$items->bindValue(":package_price", $_POST["package_price"]);
		$items->bindValue(":package_title", $_POST["package_title"]);
		$items->bindValue(":package_subtitle", $_POST["package_subtitle"]);
		$items->bindValue(":package_des", $_POST["package_des"]);
		// $items->bindValue(":package_des", "123");
		$items->bindValue(":package_tag", $_POST["package_tag"]);
		$items->bindValue(":package_pic", $fileName);
		$items->bindValue(":package_buy", $_POST["package_buy"]);
		$items->bindValue(":package_indes", $_POST["package_indes"]);
		// $items->bindValue(":package_indes", "123");
		$items->execute();	

        $msg = "新增成功";
	} catch (PDOException $e) {
		$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
	}	
	}
    echo json_encode($msg)
?>