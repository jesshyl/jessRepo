<?php
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
		$query_str = "select * from sensors".$GLOBALS['where'].$GLOBALS['cs'];
		$query_all = $mysqli->query("select * from sensors".$GLOBALS['where'].$GLOBALS['cs']);
		//echo $query_str;
		$sensors_all=array();
		if($query_all){
		while($sensor = $query_all->fetch_assoc()){
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
			array_push($sensors_all,$user1);
			}
		}
		$this->data = $sensors_all;
		
	}
	
	private $data ;
	
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
<title>导出传感器数据</title>
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
		$properties->setTitle("传感器信息");

		$php_excel->setActiveSheetIndex(0);
		$active_sheet = $php_excel->getActiveSheet();

		$active_sheet->setTitle('传感器列表');

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
		$active_sheet->getColumnDimension('P')->setWidth(30);
		$active_sheet->getColumnDimension('Q')->setWidth(30);
		$active_sheet->getColumnDimension('R')->setWidth(30);
		$active_sheet->getColumnDimension('S')->setWidth(15);
		$active_sheet->getColumnDimension('T')->setWidth(15);
		$active_sheet->getColumnDimension('U')->setWidth(15);
		$active_sheet->getColumnDimension('V')->setWidth(15);
		$active_sheet->getColumnDimension('W')->setWidth(15);
		$active_sheet->setCellValue('A1', '传感器列表('.Date("Y-m-d H:i:s").')' );    
		$active_sheet->mergeCells('A1:W1');	// 合并表头单元格
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
		$active_sheet->setCellValue('E2', '监测量');
		$active_sheet->setCellValue('F2', '量测对象');
		$active_sheet->setCellValue('G2', '物理量');
		$active_sheet->setCellValue('H2', '量测方向');
		$active_sheet->setCellValue('I2', '单位');
		$active_sheet->setCellValue('J2', '预警值');
		$active_sheet->setCellValue('K2', '报警值');
		$active_sheet->setCellValue('L2', '补偿系数');
		$active_sheet->setCellValue('M2', '参数1');
		$active_sheet->setCellValue('N2', '参数2');
		$active_sheet->setCellValue('O2', '常量');
		$active_sheet->setCellValue('P2', '波长');
		$active_sheet->setCellValue('Q2', '初始温度');
		$active_sheet->setCellValue('R2', '灵敏度');
		$active_sheet->setCellValue('S2', 'sm125编号');
		$active_sheet->setCellValue('T2', '光开关编号');
		$active_sheet->setCellValue('U2', 'sm041通道号');
		$active_sheet->setCellValue('V2', '状态');
		$active_sheet->setCellValue('W2', '备注');
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
		foreach($this->data as $asensor)
				{		
						$active_sheet->setCellValue('A'.$i, $asensor['id']);
						$active_sheet->setCellValue('B'.$i, $asensor['section_mileage']);
						$active_sheet->setCellValue('C'.$i, $asensor['segment_num']);
						$active_sheet->setCellValue('D'.$i, $asensor['sensor_num']);
						$active_sheet->setCellValue('E'.$i, $asensor['detection']);
						$active_sheet->setCellValue('F'.$i, $asensor['obj']);
						$active_sheet->setCellValue('G'.$i, $asensor['quantity']);
						$active_sheet->setCellValue('H'.$i, $asensor['direction']);
						$active_sheet->setCellValue('I'.$i, $asensor['unit']);
						$active_sheet->setCellValue('J'.$i, $asensor['warning']);
						$active_sheet->setCellValue('K'.$i, $asensor['alarm']);
						$active_sheet->setCellValue('L'.$i, $asensor['compensation_num']);
						$active_sheet->setCellValue('M'.$i, $asensor['para_two']);
						$active_sheet->setCellValue('N'.$i, $asensor['para_one']);
						$active_sheet->setCellValue('O'.$i, $asensor['constant']);
						$active_sheet->setCellValue('P'.$i, $asensor['wavelength']);
						$active_sheet->setCellValue('Q'.$i, $asensor['temperature']);
						$active_sheet->setCellValue('R'.$i, $asensor['sensitivity']);
						$active_sheet->setCellValue('S'.$i, $asensor['sm_num']);
						$active_sheet->setCellValue('T'.$i, $asensor['switch_num']);
						$active_sheet->setCellValue('U'.$i, $asensor['channel_num']);
						$active_sheet->setCellValue('V'.$i, $asensor['status']);
						$active_sheet->setCellValue('W'.$i, $asensor['remarks']);
						$i++;
					}
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="传感器信息'.Date("YmdHis").'.xls"');
		$writer = PHPExcel_IOFactory::createWriter($php_excel, 'Excel5');
		$writer->save('php://output');
		exit;
	}

}
?>