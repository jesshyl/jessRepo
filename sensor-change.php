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

if(isset($_POST['sensorid'])&&$_POST['sensorid']!=""){
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
  $id = GetSQLValueString(trim($_POST['sensorid']),"int");
  $query_str = SPRINTF("UPDATE sensors SET section_mileage = %s, segment_num = %s, sensor_num = %s, detection = %s, obj = %s, quantity = %s, direction = %s, unit = %s, warning = %f, alarm = %f, compensation_num = %d, para_two = %f, para_one = %f, constant = %f, wavelength = %f, temperature = %f, sensitivity = %f, sm_num = %d, switch_num = %d, channel_num = %d, status = %d, remarks = %s where id = %d",$secm,$segn,$sesn,$dt,$ob,$qtt,$dr,$un,$wn,$al,$cn,$p2,$p1,$ct,$wl,$tp,$ss,$smn,$swn,$chn,$st,$rm,$id);
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