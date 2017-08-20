<?php
require_once('back/conn.php');
if (!isset($_SESSION)) {
     session_start();
  }
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "pwd":
      $theValue = ($theValue != "") ? "" . $theValue . "" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return @$theValue;
}
}

$mysqli->set_charset('utf8');

if(isset($_POST['np'])){
  $np = GetSQLValueString($_POST['np'],"pwd");
  $np = md5(md5($np));
  //$np1 = GetSQLValueString($_POST['np1'],"pwd");
  $op = GetSQLValueString(trim($_POST['op']),"pwd");
  $op = md5(md5($op));
  $checkuser_string = "select * from users where username = '".$_SESSION['username']."' and pwd = '".$op."'";
  $checkuser = $mysqli->query($checkuser_string);
  $checkuser_find = $checkuser->num_rows;
  if($checkuser_find == 0){
    //echo $checkuser_string;
    echo "wrong";
  }else{
      $checkuser_user = $checkuser->fetch_assoc();
      $checkuser_id = $checkuser_user['id']; 
      $query_str = SPRINTF("UPDATE users SET pwd = '%s' where id = %d",$np,$checkuser_id);
      //echo $query_str;
      $result = $mysqli->query($query_str);
        if($mysqli->affected_rows){
          echo 'success';
        }
        else{
          echo 'fail';
        }
    }
}else{
  var_dump($_POST);
}

$mysqli->close();

?>