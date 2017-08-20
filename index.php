<?php require_once('back/conn.php'); 
if (!isset($_SESSION)) {
 		 session_start();
	}
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //$theValue = htmlspecialchars($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
	case "pwd":
      $theValue = ($theValue != "") ? $theValue : "NULL";
      break;    
    case "long":
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
    	break;
	case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//echo $_POST['islogin'];

if(isset($_POST['islogin'])&&($_POST['islogin']=='login')){
	
	$mysqli->set_charset('utf8');
	$username = GetSQLValueString(strtolower(trim($_POST['username'])),"text");
	$pwd = GetSQLValueString(strtolower(trim($_POST['pwd'])),"pwd");
	//echo $pwd;
	$find_user_s = "select * from users where username = ".$username." and pwd = '".md5(md5($pwd))."'";
	//echo $find_user_s;
	$find_user = $mysqli->query($find_user_s);
	if($find_user->num_rows>0){
		$user = $find_user->fetch_assoc();
		$user_level = $user['user_level'];
		$_SESSION['username'] = $user['username'];
		if($user_level == 1){
			$_SESSION['user_level'] = 1;
			header("Location:main.php");
			}else{
				$_SESSION['user_level'] = 0;
				header("Location:user_main.php");}
		}else{
			echo "<script>alert('用户名或密码错误');</script>";
			}
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>过江隧道监测系统</title>
        <meta name="keywords" content="过江隧道管理系统">
        <meta name="description" content="TMS">
		<link href="img/tunnel.ico" rel="shortcut icon">
		<link rel="stylesheet" href="css/login.css" />
		<script src="lib/jquery-1.8.1.min.js"></script>
        <script src="lib/layer/layer.js"></script>
	</head>
	<body>
		<div id="login">
			<DIV id="login_title" align="center"><img src="img/title.png" height="130px"/></DIV>
                <form name="logform" id="logform" action="index.php" enctype="multipart/form-data" method="post">
                	<input type="hidden" name="islogin" id="islogin" value="login"/>
                    <div class="login_box">
                        <input class="admin" id="username" name="username" type="text" maxlength="21"/>
                        <input class="passWord" id="pwd" name="pwd" type="password"  />
                        <input class="submit" type="button" onClick="log_submit()" />
                    </div>
                </form>
			</div>
		<div id="copyright">Copyright@SWJTU</div>
        <script>
        	function log_submit(){	
				if(($("#username").val()=="")||($("#pwd").val()=="")){
					alert("用户名和密码不能为空！");
					}else{
						document.getElementById("logform").submit();	
						}
					}
			$("input").on("keyup",function(e){
				if(e.keyCode == '13'){
					log_submit();
				}
			});
        </script>
	</body>
</html>
