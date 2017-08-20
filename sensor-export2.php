<?php
require_once('back/conn.php');
$mysqli->set_charset('utf8');
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

date_default_timezone_set('PRC');
$caseString = "";$where = "";
$form_post = (isset($_POST['sensor_num'])||isset($_POST['section_mileage']));
if($form_post){
	$case0 = " sensor_num = '".$_POST['sensor_num']."' ";
	$case1 = " section_mileage like '%".$_POST['section_mileage']."%' ";
	$case_arr = array();
	$case_str_arr = array();
	$case_arr[0] = $_POST['sensor_num'];
	$case_arr[1] = $_POST['section_mileage'];
	$case_str_arr[0] = $case0;
	$case_str_arr[1] = $case1;
	$caseString = "";
	for($i=0;$i<2;$i++){
		if($case_arr[$i]!=""){
			for($j=$i+1;$j<2;$j++){
				$case_str_arr[$j] = " and ".$case_str_arr[$j];
				}
			break;
			}
		}
	for($k=0;$k<2;$k++){
		if($case_arr[$k]!=""){
			$caseString = $caseString.$case_str_arr[$k];
			}
		}
	if($caseString!=""){
		$where = " where ";
	}
	
}
$qs = "select * from sensors ".$where.$caseString;
$query_res = $mysqli->query($qs);

$all_sensors = array();
if($query_res->num_rows>0){
	while($sensor = $query_res->fetch_assoc()){
			$user1 = array();
			$user1["id"]=$sensor["id"];
			$user1["section_mileage"]=$sensor["section_mileage"];
			$user1["segment_num"]=$sensor["segment_num"];
			$user1["sensor_num"]=$sensor["sensor_num"];
			$user1["detection"]=$sensor["detection"];

			$user1["obj"]=$sensor["obj"];
			$user1["quantity"]=$sensor["quantity"];
			$user1["direction"]=$sensor["direction"];
			$user1["unit"]=$sensor["unit"];
			$user1["warning"]=$sensor["warning"];

			$user1["alarm"]=$sensor["alarm"];
			$user1["compensation_num"]=$sensor["compensation_num"];
			$user1["para_two"]=$sensor["para_two"];
			$user1["para_one"]=$sensor["para_one"];
			$user1["constant"]=$sensor["constant"];

			$user1["wavelength"]=$sensor["wavelength"];
			$user1["temperature"]=$sensor["temperature"];
			$user1["sensitivity"]=$sensor["sensitivity"];
			$user1["sm_num"]=$sensor["sm_num"];
			$user1["switch_num"]=$sensor["switch_num"];

			$user1["channel_num"]=$sensor["channel_num"];
			$user1["status"]=$sensor["status"];
			$user1["remarks"]=$sensor["remarks"];
			array_push($all_sensors,$user1);
			}
}

$hl = array('编号','断面里程','管片号','传感器编号'
	,'监测量','量测对象','物理量','量测方向','单位'
	,'预警值','报警值','补偿系数','参数1','参数2'
	,'常量','波长','初始温度','灵敏度','sm125编号'
	,'光开关编号','sm041通道号','状态','备注');
//print_r($hl);
function csv_export($data = array(), $headlist = array(), $fileName) {
  
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
    header('Cache-Control: max-age=0');
  
    //打开PHP文件句柄,php://output 表示直接输出到浏览器
    $fp = fopen('php://output', 'a');
    
    //输出Excel列名信息
    foreach ($headlist as $key => $value) {
        //CSV的Excel支持GBK编码，一定要转换，否则乱码
        $headlist[$key] = iconv('utf-8', 'gbk', $value);
    }
  
    //将数据通过fputcsv写到文件句柄
    fputcsv($fp, $headlist);
    
    //计数器
    $num = 0;
    
    //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
    $limit = 30000;
    
    //逐行取出数据，不浪费内存
    $count = count($data);
    for ($i = 0; $i < $count; $i++) {
    
        $num++;
        
        //刷新一下输出buffer，防止由于数据过多造成问题
        if (($limit == $num)||($i == $count-1)) { 
            ob_flush();
            flush();
            $num = 0;
        }
        
        $row = $data[$i];

        foreach ($row as $key => $value) {
            $row[$key] = iconv('utf-8', 'gbk', $value);
        }

        fputcsv($fp, $row);
    }
  }

csv_export($all_sensors,$hl,"传感器数据".date("y-m-d"));

?>