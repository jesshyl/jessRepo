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

<title>添加解调仪</title>
</head>
<body>
<article class="page-container">
	<form method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">解调仪</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" id="demod_name" name="demod_name"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">IP：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="text" class="input-text" placeholder="" id="ip" name="ip"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">子网掩码</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="mask" id="mask"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网关</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="" name="gate" id="gate" />
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
		<input type="hidden" id="sectionid" name="sectionid" value="<?php echo $section_get['id'];?>"/>
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

function refreshs(){
	window.parent.location.reload();
}

function closelayer(){

	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    parent.layer.close(index);

}

function formsubmit(){
	if($("#section_mileage").val()!=""){
			var formdata = new FormData(document.forms[0]);
				$.ajax({				//调用ajax()函数，参数为选项object
					//traditional:true,
					url: 'section-add.php',	//url地址
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
							setTimeout(closelayer,2000);
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