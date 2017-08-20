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

$ssnum = "";$date1 = "";$date2 = "";
$secm = "";$where = "";$caseString="";

$form_post = (isset($_POST['sensor_num'])||isset($_POST['datemin'])||isset($_POST['datemax'])||
			  isset($_POST['section_mileage'])||isset($_POST['detection']));
if($form_post){
	$where = " ";
	$case0 = " sensor_num = '".$_POST['sensor_num']."' ";
	$case1 = " rec_time > '".$_POST['datemin']."' ";
	$case2 = " rec_time < '".date("Y-m-d",strtotime($_POST['datemax']." + 1 day"))."' ";
	$case3 = " section_mileage like '%".$_POST['section_mileage']."%' ";
	$case4 = " detection like '%".$_POST['detection']."%' ";
	$case_arr = array();
	$case_str_arr = array();
	$case_arr[0] = $_POST['sensor_num'];
	$case_arr[1] = $_POST['datemin'];
	$case_arr[2] = $_POST['datemax'];
	$case_arr[3] = $_POST['section_mileage'];
	$case_arr[4] = $_POST['detection'];
	$case_str_arr[0] = $case0;
	$case_str_arr[1] = $case1;
	$case_str_arr[2] = $case2;
	$case_str_arr[3] = $case3;
	$case_str_arr[4] = $case4;
	$caseString = "";
	for($i=0;$i<5;$i++){
		if(($case_arr[$i]!="")&&($case_arr[$i]!="blank")){
			for($j=$i+1;$j<5;$j++){
				$case_str_arr[$j] = " and ".$case_str_arr[$j];
				}
			break;
			}
		}
	for($k=0;$k<5;$k++){
		if($case_arr[$k]!=""){
			$caseString = $caseString.$case_str_arr[$k];
			}
		}
	if(trim($caseString)!=""){
		$where = " where ";
	}
	
}

$qs = "select * from events ".$where.trim($caseString);
$query_res = $mysqli->query($qs);

$all_sensors = array();
if($query_res->num_rows>0){
	while($event = $query_res->fetch_assoc()){
			$user1 = array();
					$user1["id"]=$event["id"];
					$user1["section_mileage"]=$event["section_mileage"];
					$user1["segment_num"]=$event["segment_num"];
					$user1["sensor_num"]=$event["sensor_num"];
					$user1["current_wl"]=$event["current_wl"];
					$user1["detection"]=$event["detection"];
					$user1["obj"]=$event["obj"];
					$user1["quantity"]=$event["quantity"];
					$user1["value"]=$event["value"];
					$user1["unit"]=$event["unit"];
					$user1["warning"]=$event["warning"];
					$user1["alarm"]=$event["alarm"];
					$user1["status"]=$event["status"];
					$user1["rec_time"]=$event["rec_time"];
					$user1["remarks"]=$event["remarks"];
					array_push($all_sensors,$user1);
			}
}

$hl = array('编号', '断面里程', '管片号', '传感器编号'
	, '当前波长','监测量', '量测对象', '物理量'
	, '当前值', '单位', '预警值', '报警值', '状态'
	, '记录时间', '备注');
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

csv_export($all_sensors,$hl,"历史数据".date("y-m-d"));

?>