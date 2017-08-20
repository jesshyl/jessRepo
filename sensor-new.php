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
				<input required="required" type="text" class="input-text" placeholder="" id="section_mileage" name="section_mileage" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管片号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" id="segment_num" name="segment_num" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>传感器号：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" id="sensor_num" name="sensor_num" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">检测量说明：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="detection" id="detection" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">监测对象</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="obj" id="obj" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>物理量</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" name="quantity" id="quantity" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">量测方向</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="direction" id="direction" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>单位</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" name="unit" id="unit" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">预警值</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="warning" id="warning" />
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">报警值</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="alarm" id="alarm" />
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">温度补偿器编号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="compensation_num" id="compensation_num" />
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">二次项系数</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="para_two" id="para_two" />
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">一次项系数</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="para_one" id="para_one" />
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">常量</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="constant" id="constant" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">初始波长</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="wavelength" id="wavelength" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">初始温度</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="temperature" id="temperature" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">灵敏度</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="sensitivity" id="sensitivity" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">sm125编号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="sm_num" id="sm_num" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">sm041光开关编号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="switch_num" id="switch_num" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">通道号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="channel_num" id="channel_num" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">传感器状态</label>
			<div class="formControls col-xs-8 col-sm-9">
			<input type="hidden" name="status" id="status" value="1">
				<div class="radio-box">
					<input name="status_radio" type="radio" id="status_radio" value="1" checked/>
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
				<input type="text" class="input-text" placeholder="" name="remarks" id="remarks" />
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="button" onclick="formsubmit()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
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
	$("input[name='status_radio']").click(function(){
		$("#status").val($("input[name='status_radio']:checked").val());
	});
});

function refreshs(){
	window.parent.location.reload();
}

function formsubmit(){
	if(($("#section_mileage").val()!="")&&($("#segment_num").val()!="")&&($("#sensor_num").val()!="")&&($("#quantity").val()!="")&&($("#unit").val()!="")){
			var formdata = new FormData(document.forms[0]);
				$.ajax({				//调用ajax()函数，参数为选项object
					//traditional:true,
					url: 'sensor-add.php',	//url地址
					type: 'POST',		//HTTP请求的方法，这里是GET
					dataType: 'text',	//预期返回数据类型
					data: formdata,			//POST需要的数据
					contentType: false,
                	processData: false,
					error: function(){	//当发生错误时候的回调
						alert("error");
					},
					timeout: function(){//发生请求超时的回调
						alert('time out');
					},
					success: function(data){//成功以后的回调，也就是readyStatus=4且status=200
						console.log(data);
						if(data == 'success'){
							document.write("<b style='color:green;font-size:16px;'>添加成功,即将关闭...</b>");
							setTimeout(refreshs,2000);
							//window.parent.location.reload();
						}else if(data == 'fail'){
							document.write("<b style='color:red;font-size:16px;'>未添加，即将关闭...</b>");
							setTimeout(refreshs,2000);
						}
					}
				});

	}else{
		layer.msg('请补充未填写项，带 <b style=\"color:red\">*</b> 号为必填',{icon:5,time:3000});
	}
	
}


</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>
<?php $mysqli->close();?>