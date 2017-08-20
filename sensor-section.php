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
//if(true){
if(isset($_GET['sn'])){
	$sn = @$_GET['sn'];
	$dt = @$_GET['dt'];
	//$dt = '温度';
	//$sn = 'JC1';
	//echo "sn:".trim($sn)." dt:".trim($dt);
	$where = "";
	if(trim($sn)!=""){
		$where =  "where section_mileage like '%".$sn."%'";
		if(trim($dt)!=""){
			$where =  "where section_mileage like '%".$sn."%' and detection like '%".$dt."%'";
		}
	}else{
		if(trim($dt)!=""){
			$where =  "where detection like '%".$dt."%'";
		}
	}
	$res = $mysqli->query("select section_mileage,sensor_num,detection from sensors ".$where) or die("query error");
	//echo "select sensor_num from sensors where section_mileage like '%".$sn."%'";
	//echo $where;
	$arr = array();
	$arr1 = array();
	//echo $res->num_rows;
	if($res->num_rows>0){
		while($num = $res->fetch_assoc()){
			//array_push($arr,$num['section_mileage']);
			array_push($arr,$num['sensor_num']);
			//array_push($arr,$num['detection']);
			//array_push($arr,$arr1);
			//$arr1 = array();
		}
	}

	echo json_encode($arr);
	
}


if(isset($_GET['sn1'])){
	$sn1 = $_GET['sn1'];
	//$sn = 'JC1';
	$res = $mysqli->query("select section_mileage,sensor_num,detection from sensors where sensor_num ='".$sn1."' LIMIT 1");
	//echo "select sensor_num from sensors where section_mileage like '%".$sn."%'";
	$arr = array();
	$arr1 = array();
	//echo $res->num_rows;
	if($res->num_rows>0){
		$num = $res->fetch_assoc();
		array_push($arr,$num['section_mileage']);
		array_push($arr,$num['sensor_num']);
		array_push($arr,$num['detection']);
			//array_push($arr,$arr1);
			//$arr1 = array();
	}

	echo json_encode($arr);
	
}

?>

<?php $mysqli->close();?>