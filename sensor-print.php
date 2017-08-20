<?php

include 'back/gpr.php';
$task = get::_('task', 'sensor_print');
date_default_timezone_set('PRC');
$controller = new controller();
if(method_exists($controller, $task)) $controller->$task();
class controller

{
	function __CONSTRUCT(){
		require_once('back/conn.php'); 
		$mysqli->set_charset('utf8');
		$query_all = $mysqli->query("select * from sensors");
		if($query_all->num_rows>0){
			$sensors_all=array();
			}
		while($sensor = $query_all->fetch_assoc()){
			$user1 = array();
			$user1["id"]=$sensor["id"];
			array_push($sensors_all,$user1);
			}
		$this->data = $sensors_all;
	}
	
	private $data ;
	
	public function sensor_print()
	{
		?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8" />
<title>传感器打印</title>
</head>
<body>
<form action="sensor-print.php./?task=download" method="post">
<p style="text-align:center;">
	打印传感器名单
</p>
<p style="text-align:center;">
	<input type="submit" value="生成" />
</p>
</form>
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