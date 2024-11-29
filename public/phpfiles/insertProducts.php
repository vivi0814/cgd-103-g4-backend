<?php 
header('Access-Control-Allow-Origin:*');
header("Content-Type:application/json;charset=utf-8");
$msg = "nothing";
//圖片
const MY_DIR = "../../front/img/products"; //路徑  //for打包後的環境
// const MY_DIR = "images"; //路徑  
//董董測試用的
// foreach($_FILES as $i=>$data){
// 	var_dump($i);
// 	echo "-------";
// 	var_dump($data);
// }
// exit();
// var_dump($_FILES);
// exit();

//三張照片
$ok = 0;
$i=0;
foreach ($_FILES as $key=>$new_file) {
	//$temp = "prod_pic_intro_".$i;
	//$new_file = $_FILES[$temp];
	
	switch($new_file["error"] ){
		case UPLOAD_ERR_OK : 
			
			if( file_exists(MY_DIR) == false){
				mkdir(MY_DIR); //make directory
			}
			$from = $new_file["tmp_name"];
	
	 		//$_FILES["image"]["name"]; //smile.gif,  sara.smile.gif, a313feexrer.gif
			$fileExt = pathinfo($new_file["name"],PATHINFO_EXTENSION); //取得副檔名

			$fileName[$i] = uniqid() . ".". $fileExt; //決定檔案名稱, 如a313feexrer.gif
			$to = MY_DIR . "/". $fileName[$i]; //決定路徑名稱
			if(copy( $from, $to)){
				$msg = "上傳成功";
				$ok++;
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
			$msg = "上傳檔案失敗，錯誤代碼: ".$new_file["error"]."請通知系統開發人員";
	}
	$i++;
}
//-------------------------
if( $ok === 3){
// if( ["prod_pic_intro_0"]["error"] === 0){
		
	try{
		require_once("./connect_cgd103g4.php");
		//sql 指令
		//圖片先用null
		$sql = "insert into product values (
			null, 
			:prod_name, 
			:prod_intro, 
			:prod_price, 
			:prod_pic_intro_0, 
			:prod_pic_intro_1, 
			:prod_pic_intro_2, 
			:prod_status, 
			:prod_series_idx, 
			:prod_type_id
			)";
		//編譯, 執行
		$product = $pdo->prepare($sql);	
		$product->bindValue(":prod_name", $_POST["prod_name"]);
		$product->bindValue(":prod_intro", $_POST["prod_intro"]);
		$product->bindValue(":prod_price", $_POST["prod_price"]);
		$product->bindValue(":prod_pic_intro_0",$fileName[0]);
		$product->bindValue(":prod_pic_intro_1", $fileName[1]);
		$product->bindValue(":prod_pic_intro_2", $fileName[2]);
		$product->bindValue(":prod_status", $_POST["prod_status"]);
		$product->bindValue(":prod_series_idx", $_POST["prod_series_idx"]);
		$product->bindValue(":prod_type_id", $_POST["prod_type_id"]);
		// $product->bindValue(":image", $fileName);
		$product->execute();	

		$msg = "新增成功";
	} catch (PDOException $e) {
		$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
	}	
}

//輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>    