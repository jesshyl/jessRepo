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
$cantfind="";
if(isset($_GET['snum'])){
	$sensor_num = GetSQLValueString($_GET['snum'],"text");
	@$all = "select * from sensors";
	@$case = " where sensor_num = ".@$sensor_num;
	@$query_Recordset1 = @$all.@$case;
	@$Recordset1 = $mysqli->query(@$query_Recordset1);
	if(@$Recordset1->num_rows==0){
		$cantfind = "cantfind";
	}else{
		$sensor_get = @$Recordset1->fetch_assoc();
	}
	//echo $_GET['snum'];
}



?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
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
<!--/meta 作为公共模版分离出去-->

<title>编辑传感器</title>
</head>
<body>
<article class="page-container">
	<form method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>断面里程：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" id="section_mileage" name="section_mileage" value="<?php echo @$sensor_get['section_mileage'];?>"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管片号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" id="segment_num" name="segment_num" value="<?php echo @$sensor_get['segment_num'];?>"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>传感器号：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" id="sensor_num" name="sensor_num" value="<?php echo @$sensor_get['sensor_num'];?>"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">检测量说明：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="detection" id="detection" value="<?php echo @$sensor_get['detection'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">监测对象</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="obj" id="obj" value="<?php echo @$sensor_get['obj'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>物理量</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" name="quantity" id="quantity" value="<?php echo @$sensor_get['quantity'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">量测方向</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="direction" id="direction" value="<?php echo @$sensor_get['direction'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>单位</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" name="unit" id="unit" value="<?php echo @$sensor_get['unit'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">预警值</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="warning" id="warning" value="<?php echo @$sensor_get['warning'];?>">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">报警值</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="alarm" id="alarm" value="<?php echo @$sensor_get['alarm'];?>">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">温度补偿器编号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="compensation_num" id="compensation_num" value="<?php echo @$sensor_get['compensation_num'];?>">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">二次项系数</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="para_two" id="para_two" value="<?php echo @$sensor_get['para_two'];?>">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">一次项系数</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="para_one" id="para_one" value="<?php echo @$sensor_get['para_one'];?>">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">常量</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="constant" id="constant" value="<?php echo @$sensor_get['constant'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">初始波长</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="wavelength" id="wavelength" value="<?php echo @$sensor_get['wavelength'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">初始温度</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="temperature" id="temperature" value="<?php echo @$sensor_get['temperature'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">灵敏度</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="sensitivity" id="sensitivity" value="<?php echo @$sensor_get['sensitivity'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">sm125编号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="sm_num" id="sm_num" value="<?php echo @$sensor_get['sm_num'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">sm041光开关编号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="switch_num" id="switch_num" value="<?php echo @$sensor_get['switch_num'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">通道号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="channel_num" id="channel_num" value="<?php echo @$sensor_get['channel_num'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">传感器状态</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="hidden" name="status" id="status" value="<?php echo @$sensor_get['status'];?>">
				<div class="radio-box">
					<input name="status_radio" type="radio" id="status_radio" value="1" />
					<label>好</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="status_radio" name="status_radio" value="0" />
					<label>坏</label>
				</div>
				
				
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="remarks" id="remarks" value="<?php echo @$sensor_get['remarks'];?>">
			</div>
		</div>
		<input type="hidden" id="sensorid" name="sensorid" value="<?php echo $sensor_get['id'];?>"/>
	</form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本--> 
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
$(function(){

	$("input[name='status_radio'][value=<?php echo @$sensor_get['status'];?>]").attr("checked",true);
	
	<?php if($cantfind=='cantfind'){?>
		document.write("找不到该传感器");
	<?php }?>

});
</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>
<?php $mysqli->close();?>