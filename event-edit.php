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
if(isset($_GET['eid'])){
	$event_id = GetSQLValueString($_GET['eid'],"int");
	@$all = "select * from events";
	@$case = " where id = ".@$event_id;
	@$query_Recordset1 = @$all.@$case;
	@$Recordset1 = $mysqli->query(@$query_Recordset1);
	if($Recordset1->num_rows==0){
		echo "检索不到该记录";
	}else{
		$event_get = $Recordset1->fetch_assoc();
	}
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

<title>编辑记录</title>
</head>
<body>
<article class="page-container">
	<form method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>断面里程：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input disabled="disabled" required="required" type="text" class="input-text" placeholder="" id="section_mileage" name="section_mileage" value="<?php echo @$event_get['section_mileage'];?>"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管片号</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input disabled="disabled" required="required" type="text" class="input-text" placeholder="" id="segment_num" name="segment_num" value="<?php echo @$event_get['segment_num'];?>"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>传感器号：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input disabled="disabled" required="required" type="text" class="input-text" placeholder="" id="sensor_num" name="sensor_num" value="<?php echo @$event_get['sensor_num'];?>"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">当前波长：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="current_wl" id="current_wl" value="<?php echo @$event_get['current_wl'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">监测对象</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input disabled="disabled" type="text" class="input-text" placeholder="" name="obj" id="obj" value="<?php echo @$event_get['obj'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>物理量</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input disabled="disabled" required="required" type="text" class="input-text" placeholder="" name="quantity" id="quantity" value="<?php echo @$event_get['quantity'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">当前值</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="value" id="value" value="<?php echo @$event_get['value'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>单位</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input disabled="disabled" required="required" type="text" class="input-text" placeholder="" name="unit" id="unit" value="<?php echo @$event_get['unit'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">预警值</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input disabled="disabled" type="text" class="input-text" placeholder="" name="warning" id="warning" value="<?php echo @$event_get['warning'];?>">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">报警值</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input disabled="disabled" type="text" class="input-text" placeholder="" name="alarm" id="alarm" value="<?php echo @$event_get['alarm'];?>">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">传感器状态</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="status" id="status" value="<?php echo @$event_get['status'];?>">
			</div>
		</div>

		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">记录时间</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input disabled="disabled" type="text" class="input-text" placeholder="" name="rec_time" id="rec_time" value="<?php echo @$event_get['rec_time'];?>">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="remarks" id="remarks" value="<?php echo @$event_get['remarks'];?>">
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="button" onclick="formsubmit()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
		<input type="hidden" id="eventid" name="eventid" value="<?php echo $event_get['id'];?>"/>
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
	
});

function refreshs(){
	window.parent.location.reload();
}

function closelayer(){

	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    parent.layer.close(index);

}

function formsubmit(){

	var formdata = new FormData(document.forms[0]);
	$.ajax({				//调用ajax()函数，参数为选项object
					//traditional:true,
					url: 'event-change.php',	//url地址
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
							document.write("<b style='color:green;font-size:16px;'>更新成功,即将关闭...</b>");
							setTimeout(refreshs,2000);
							//window.parent.location.reload();
						}else if(data == 'fail'){
							document.write("<b style='color:red;font-size:16px;'>数据未修改，即将关闭...</b>");
							setTimeout(closelayer,1000);
						}
					}
				});

}


</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>