<?php
include 'back/gpr.php';
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
	<form action="history-export1.php./?task=download" method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
  <div class="row cl">
      <label class="form-label col-xs-3 col-sm-3">断面里程：</label>
      <div class="formControls col-xs-9 col-sm-9">
        <select class="select" placeholder="" id="section_mileage" name="section_mileage">
                  <option name="sm_num" value="">全部</option>
                    <option name="sm_num" value="JC1">JC 1</option>
                    <option name="sm_num" value="JC2">JC 2</option>
                    <option name="sm_num" value="JC3">JC 3</option>
                    <option name="sm_num" value="JC4">JC 4</option>
                    <option name="sm_num" value="JC5">JC 5</option>
                </select>
      </div>
    </div>
    <div class="row cl">
      <label class="form-label col-xs-3 col-sm-3">监测项：</label>
      <div class="formControls col-xs-9 col-sm-9">
        <select class="select" placeholder="" id="detection" name="detection">
                    <option value="">全部</option>
                    <option value="位移">管片位移</option>
                    <option value="温度">温度</option>
                    <option value="高差">高差计</option>
                </select>
      </div>
    </div>
		<div class="row cl">
			<label class="form-label col-xs-3 col-sm-3">传感器号：</label>
			<div class="formControls col-xs-9 col-sm-9">
				<input type="text" class="input-text" placeholder="不填表示全部" id="sensor_num" name="sensor_num" />
			</div>
		</div>
        <div class="row cl">
			<label class="form-label col-xs-3 col-sm-3">时间范围：</label>
			<div class="formControls col-xs-4 col-sm-4">
				<input type="text" value="<?php echo @$datemin?>" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="datemin" class="input-text Wdate" style="width:100%;">
			</div>
            <div class="formControls col-xs-1 col-sm-1">到</div>
            <div class="formControls col-xs-4 col-sm-4">
				<input type="text" value="<?php echo @$datemax?>" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="datemax" class="input-text Wdate" style="width:100%;">	
            </div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-3 col-sm-offset-3">
				<input  disabled="disabled" name="subbtn" id="subbtn" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;导出&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="lib/echarts.js"></script>  
<script type="text/javascript" src="lib/macarons.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
<script>
	$(function(){
		$("#subbtn").removeAttr("disabled");
	});
  $("#subbtn").click(function(){
    $("#subbtn").addClass("disabled");
    var iii = 30;
    var dis = setInterval(function(){
      if(iii>0){
        $("#subbtn").val("数据量较大，请耐心等待");
        iii--;
      }else{
        $("#subbtn").removeClass("disabled");
        $("#subbtn").val(" 导出 ");
        clearInterval(dis);
      }
    },1000);
  });
</script>
</body>
</html>