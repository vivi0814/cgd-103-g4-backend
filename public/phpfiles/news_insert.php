<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");


// const MY_DIR = "../img/News"; //路徑  //專案裡
const MY_DIR = "../../front/img/News"; //路徑  //for打包後的環境



switch($_FILES["news_img"]["error"] ){
	case UPLOAD_ERR_OK : 
		
		if( file_exists(MY_DIR) == false){ //如果資料夾不存在，就建立資料夾
			mkdir(MY_DIR); //make directory(建立目錄)
		}
		$from = $_FILES["news_img"]["tmp_name"];

		// $_FILES["news_img"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
		$fileExt = pathinfo($_FILES["news_img"]["name"],PATHINFO_EXTENSION); //取得副檔名
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

if( $_FILES["news_img"]["error"] === 0){
  	
	try{
		// require_once("connectG4.php");
		require_once("connect_cgd103g4.php");

		//sql 指令
		// $sql = "insert into news values (null, :news_time, :news_last_edit, :news_type, :news_title,:news_text_start, :news_text_middle, :news_text_trans, :news_text_end, null, :news_img_des, :news_status)";
		$sql = "insert into news values (
			null,
			CURDATE(),
			CURDATE(),
			:news_type, 
			:news_title,
			:news_text_start, 
			:news_text_middle, 
			:news_text_trans, 
			:news_text_end, 
			:news_img, 
			:news_img_des, 
			:news_status
			)";

		//編譯, 執行
		$news = $pdo->prepare($sql);	
		// $news->bindValue(":news_time", $_POST["news_time"]); //判斷如果news_status ==="上架"  // 註解的時候這段搬上去
		// $news->bindValue(":news_last_edit", $_POST["news_last_edit"]); mysql自己抓時間
		$news->bindValue(":news_type", $_POST["news_type"]);
		$news->bindValue(":news_title", $_POST["news_title"]);
		$news->bindValue(":news_text_start", $_POST["news_text_start"]);
		$news->bindValue(":news_text_middle", $_POST["news_text_middle"]);
		$news->bindValue(":news_text_trans", $_POST["news_text_trans"]);
		$news->bindValue(":news_text_end", $_POST["news_text_end"]);
		$news->bindValue(":news_img", $fileName);
		$news->bindValue(":news_img_des", $_POST["news_img_des"]);
		$news->bindValue(":news_status", $_POST["news_status"]);
		$news->execute();	

	    $msg = "新增成功";
	} catch (PDOException $e) {
		$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
	}	
}
//輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>    