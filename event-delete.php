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
    case "date":
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
//echo $_POST['eventid'];
if(isset($_POST['eventid'])&&$_POST['eventid']!=""){
  $delid = GetSQLValueString(trim($_POST['eventid']),"int");
  $query_str = "DELETE FROM events where id =".$delid;
  //echo $query_str;
  $result = $mysqli->query($query_str);
  if($result){
    echo 'success';
  }
  else{
    echo 'fail';
  }


}else{echo "error";echo $_POST['eventid'];}

//echo $query_str;

?>