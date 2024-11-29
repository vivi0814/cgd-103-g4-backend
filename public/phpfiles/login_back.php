<?php
// session_start();
$Origin = isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:"*";   // HTTP_HOST,HTTP_ORIGIN,SERVER_NAME
header("Access-Control-Allow-Origin: {$Origin}");           // 如果$origin为*号时,则跨域访问不支持cookie的发送
header("Access-Control-Allow-Methods:POST,GET,OPTIONS");    // 允许请求的类型
header("Access-Control-Allow-Credentials:true");            // 跨域访问是否允许带cookie的发送
header("Content-Type:application/json;charset=utf-8");      // cors请求时,谷歌浏览器包含的头信息
// header('Access-Control-Allow-Origin:*');
// header("Content-Type:application/json;charset=utf-8");
/**
 * 前台會員登陸接口
 * $_SESSION 參考網站:https://ithelp.ithome.com.tw/articles/10207241
 * CORS 參考網站:https://blog.huli.tw/2021/02/19/cors-guide-3/
*/
try{
  require_once("./connect_cgd103g4.php");
  $login_account = empty( $_GET["emp_id"] ) ? ( $_POST["emp_id"] ?? "" ) : $_GET["emp_id"];
  $login_psw = empty( $_GET["emp_psw"] ) ? ( $_POST["emp_psw"] ?? "" ) : $_GET["emp_psw"];

  if($login_account != "" && $login_psw != "") {

        $sql = " SELECT * FROM emp WHERE emp_id = '{$login_account}' OR emp_psw = '{$login_psw}'; ";
        $result = $pdo->query($sql);
        $resArray = $result->fetch(PDO::FETCH_ASSOC);
        $emp_psw = $resArray["emp_psw"]??"";
        if($emp_psw == $login_psw) {
            //產生一個令牌
            $nowTime = time();
            // $token = md5($resArray["mem_account"].$resArray["mem_psw"].$nowTime);
            session_start();
            // session_unset();
            $_SESSION = $resArray;
            // echo $resArray["mem_psw"];
            $result_array = ["code"=>"1", "msg"=>"登陸成功", "account" =>"{$login_account}", "emp_no" =>"{$resArray["emp_no"]}", "emp_name" =>"{$resArray["emp_name"]}",];//, "token"=>$token
            echo json_encode($result_array);
        }
        else {
            $result_array = ["code"=>"0","msg"=>"帳號或密碼錯誤"];
            echo json_encode($result_array);
        }
        // $connect -> close();
    // }
  }else {
    $result_array = ["code"=>"0", "msg"=>"帳號或密碼錯誤"];
    echo json_encode($result_array);
  }
}catch (PDOException $e) {
  $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
  echo $msg;
}	
//catch(PDOException $e){
//  echo $e->getMessage();
//} 

?>