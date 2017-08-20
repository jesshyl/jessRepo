<?php
set_time_limit(0);
include 'back/gpr.php';
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

$task = get::_('task', 'sensor_print');
date_default_timezone_set('PRC');

$ssnum = "";
$date1 = "";
$date2 = "";
$secm = "";
$where = "";

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
	$GLOBALS['cs'] = trim($caseString);
	$GLOBALS['where'] = $where;
	$controller = new controller();	
	if(method_exists($controller, $task)) $controller->$task();
}



class controller

{
	function __CONSTRUCT(){
		require_once('back/conn.php');
		$mysqli->set_charset('utf8');
		$query_str = "select * from events".$GLOBALS['where'].$GLOBALS['cs'];
		$query_all = $mysqli->query($query_str);
		//echo "select * from events".$GLOBALS['where'].$GLOBALS['cs'];
		$rows_num = $query_all->num_rows;
		$max_num = 50000;
		$sheets_num = ceil($rows_num/$max_num);
		$events_all=array();

		if($query_all){
			for($ct=0;$ct<$sheets_num;$ct++){
				$start = $ct*$max_num;
				$query_str1 = $query_str."limit ".$start.",".$max_num; 
				while($event = $query_all->fetch_assoc()){
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
					array_push($events_all,$user1);
					}
					$this->data[$ct] = $events_all;
					$events_all = array();
		}
		$this->sheets_num = $sheets_num;
	}
		
		
		
	}
	
	private $data ;
	private $sheets_num ;
	
	public function sensor_print()
	{
		?>


<!Doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>导出历史数据</title>
</head>
<body>
<article class="page-container">
	正在导出，请稍等...
</article>
</body>
</html>
<?php		
	}


	public function download()
	{
		include 'back'.DIRECTORY_SEPARATOR.'Classes'.DIRECTORY_SEPARATOR.'PHPExcel.php';
		$php_excel = new PHPExcel();
		$properties = $php_excel->getProperties();
		$properties->setCreator("yms");
		$properties->setLastModifiedBy("yms");
		$properties->setTitle("历史数据");

		for($sn = 1;$sn<$this->sheets_num;$sn++){
			$php_excel->createsheet();
			$php_excel->getSheet($sn)->setTitle('历史数据列表');
		}

		for($sn = 0;$sn<$this->sheets_num;$sn++){

		$php_excel->setActiveSheetIndex($sn);
		$active_sheet = $php_excel->getActiveSheet();

		$active_sheet->setTitle('历史数据列表');

		// 自动调节大小
		$active_sheet->getColumnDimension('A')->setWidth(15);
		$active_sheet->getColumnDimension('B')->setWidth(15);
		$active_sheet->getColumnDimension('C')->setWidth(30);
		$active_sheet->getColumnDimension('D')->setWidth(30);
		$active_sheet->getColumnDimension('E')->setWidth(15);
		$active_sheet->getColumnDimension('F')->setWidth(30);
		$active_sheet->getColumnDimension('G')->setWidth(30);
		$active_sheet->getColumnDimension('H')->setWidth(30);
		$active_sheet->getColumnDimension('I')->setWidth(15);
		$active_sheet->getColumnDimension('J')->setWidth(15);
		$active_sheet->getColumnDimension('K')->setWidth(15);
		$active_sheet->getColumnDimension('L')->setWidth(15);
		$active_sheet->getColumnDimension('M')->setWidth(30);
		$active_sheet->getColumnDimension('N')->setWidth(30);
		$active_sheet->getColumnDimension('O')->setWidth(15);
		$active_sheet->setCellValue('A1', '历史数据列表('.Date("Y-m-d H:i:s").')' );    
		$active_sheet->mergeCells('A1:O1');	// 合并表头单元格
		$active_sheet->getRowDimension(1)->setRowHeight(30);	// 设置表头1高度
		$style = array(
			'font' => array(
				'size' => 20
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
			'borders' => array(
				'bottom' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$active_sheet->getStyle('A1:W1')->applyFromArray($style);	// 设置表头1样式
		$active_sheet->getRowDimension(2)->setRowHeight(20);	// 设置表头2高度
		// 设置表头2名称
		$active_sheet->setCellValue('A2', '编号');
		$active_sheet->setCellValue('B2', '断面里程');
		$active_sheet->setCellValue('C2', '管片号');
		$active_sheet->setCellValue('D2', '传感器编号');
		$active_sheet->setCellValue('E2', '当前波长');
		$active_sheet->setCellValue('F2', '监测量');
		$active_sheet->setCellValue('G2', '量测对象');
		$active_sheet->setCellValue('H2', '物理量');
		$active_sheet->setCellValue('I2', '当前值');
		$active_sheet->setCellValue('J2', '单位');
		$active_sheet->setCellValue('K2', '预警值');
		$active_sheet->setCellValue('L2', '报警值');
		$active_sheet->setCellValue('M2', '状态');
		$active_sheet->setCellValue('N2', '记录时间');
		$active_sheet->setCellValue('O2', '备注');
		// 表头样式
		$style = array(
			'font' => array(
				'bold' => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
			'borders' => array(
				'bottom'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
		$active_sheet->getStyle('A2:W2')->applyFromArray($style);

		// 表头(备注)样式
		$style = array(
			'font' => array(
				'bold' => true
			),
			'borders' => array(
				'bottom'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		// 内容样式
		$style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
		$active_sheet->getStyle('A:W')->applyFromArray($style);
		$i = 3;
		$sizeofdata = count($this->data);
		foreach($this->data[$sn] as $aevent)
				{		
						$active_sheet->setCellValue('A'.$i, $aevent['id']);
						$active_sheet->setCellValue('B'.$i, $aevent['section_mileage']);
						$active_sheet->setCellValue('C'.$i, $aevent['segment_num']);
						$active_sheet->setCellValue('D'.$i, $aevent['sensor_num']);
						$active_sheet->setCellValue('E'.$i, $aevent['current_wl']);
						$active_sheet->setCellValue('F'.$i, $aevent['detection']);
						$active_sheet->setCellValue('G'.$i, $aevent['obj']);
						$active_sheet->setCellValue('H'.$i, $aevent['quantity']);
						$active_sheet->setCellValue('I'.$i, $aevent['value']);
						$active_sheet->setCellValue('J'.$i, $aevent['unit']);
						$active_sheet->setCellValue('K'.$i, $aevent['warning']);
						$active_sheet->setCellValue('L'.$i, $aevent['alarm']);
						$active_sheet->setCellValue('M'.$i, $aevent['status']);
						$active_sheet->setCellValue('N'.$i, $aevent['rec_time']);
						$active_sheet->setCellValue('O'.$i, $aevent['remarks']);


						$i++;
					}

		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="历史数据'.Date("YmdHis").'.xls"');
		$writer = PHPExcel_IOFactory::createWriter($php_excel, 'Excel5');
		$writer->save('php://output');
		exit;
	}

}
?>