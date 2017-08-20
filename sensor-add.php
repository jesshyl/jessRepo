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
$query_all = $mysqli->query("select * from sensors");
$totalNumber = $query_all->num_rows;
  $secm = GetSQLValueString(trim($_POST['section_mileage']),"text");
  $segn = GetSQLValueString(trim($_POST['segment_num']),"text");
  $sesn = GetSQLValueString(trim($_POST['sensor_num']),"text");
  $dt = GetSQLValueString(trim($_POST['detection']),"text");
  $ob = GetSQLValueString(trim($_POST['obj']),"text");
  $qtt = GetSQLValueString(trim($_POST['quantity']),"text");
  $dr = GetSQLValueString(trim($_POST['direction']),"text");
  $un = GetSQLValueString(trim($_POST['unit']),"text");
  $wn = GetSQLValueString(trim($_POST['warning']),"double");
  $al = GetSQLValueString(trim($_POST['alarm']),"double");
  $cn = GetSQLValueString(trim($_POST['compensation_num']),"int");
  $p2 = GetSQLValueString(trim($_POST['para_two']),"double");
  $p1 = GetSQLValueString(trim($_POST['para_one']),"double");
  $ct = GetSQLValueString(trim($_POST['constant']),"double");
  $wl = GetSQLValueString(trim($_POST['wavelength']),"double");
  $tp = GetSQLValueString(trim($_POST['temperature']),"double");
  $ss = GetSQLValueString(trim($_POST['sensitivity']),"double");
  $smn = GetSQLValueString(trim($_POST['sm_num']),"int");
  $swn = GetSQLValueString(trim($_POST['switch_num']),"int");
  $chn = GetSQLValueString(trim($_POST['channel_num']),"int");
  $st = GetSQLValueString(trim($_POST['status']),"int");
  $rm = GetSQLValueString(trim($_POST['remarks']),"text");
  $query_str = SPRINTF("INSERT INTO sensors (section_mileage, segment_num, sensor_num, detection, obj, quantity , direction, unit, warning, alarm, compensation_num, para_two, para_one, constant, wavelength, temperature, sensitivity, sm_num, switch_num, channel_num, status, remarks) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%f,%f,%d,%f,%f,%f,%f,%f,%f,%d,%d,%d,%d,%s)",$secm,$segn,$sesn,$dt,$ob,$qtt,$dr,$un,$wn,$al,$cn,$p2,$p1,$ct,$wl,$tp,$ss,$smn,$swn,$chn,$st,$rm);
  //echo $query_str;
  $result = $mysqli->query($query_str);
  if($mysqli->affected_rows){
    echo 'success';
  }
  else{
    echo 'fail';
  }

$mysqli->close();


?>