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

if(isset($_POST['demod_name'])&&$_POST['demod_name']!=""){
  $dn = GetSQLValueString(trim($_POST['demod_name']),"text");
  $ip = GetSQLValueString(trim($_POST['ip']),"text");
  $mask = GetSQLValueString(trim($_POST['mask']),"text");
  $gate = GetSQLValueString(trim($_POST['gate']),"text");
  $rm = GetSQLValueString(trim($_POST['remarks']),"text");
  $id = GetSQLValueString(trim($_POST['sectionid']),"int");
  $query_str = SPRINTF("UPDATE demods SET demod_name = %s, ip = %s, mask = %s, gate = %s, remarks = %s where id = %d",$dn,$ip,$mask,$gate,$rm,$id);
 // echo $query_str;
  $result = $mysqli->query($query_str);
  if($mysqli->affected_rows){
    echo 'success';
  }
  else{
    echo 'fail';
  }

}

$mysqli->close();
?>