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
if(isset($_GET['sid'])){
	$sensor_id = GetSQLValueString($_GET['sid'],"int");
	@$all = "select * from sensors";
	@$case = " where id = ".@$sensor_id;
	@$query_Recordset1 = @$all.@$case;
	@$Recordset1 = $mysqli->query(@$query_Recordset1);
	if(@$Recordset1->num_rows==0){
		echo "检索不到该传感器";
	}else{
		$sensor_get = @$Recordset1->fetch_assoc();
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

<title>编辑传感器</title>
</head>
<body>
<article class="page-container">
	<form method="post" class="form form-horizontal" id="form-member-add" enctype="multipart/form-data">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">初始密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="password" class="input-text" id="old_pwd" name="old_pwd"/>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">新密码</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input required="required" type="password" class="input-text" placeholder="" id="new_pwd" name="new_pwd" />
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">重复新密码</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text" placeholder="" name="new_pwd1" id="new_pwd1" 、>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="button" onclick="formsubmit()" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
		<input type="hidden" id="username" name="username" value="<?php echo $_SESSION['username'];?>"/>
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



function formsubmit(){
	var op = $.trim($("#old_pwd").val());
	var np = $.trim($("#new_pwd").val());
	var np1 = $.trim($("#new_pwd1").val());

	if(op == ""||np==""||np1==""){
		layer.msg("请填写所有项！",{icon:5,time:2000});
	}else{
		if(np!=np1){
			layer.msg("两次密码不一致！",{icon:5,time:2000});
		}else{

			$.ajax({				//调用ajax()函数，参数为选项object
					//traditional:true,
					url: 'password-update.php',	//url地址
					type: 'POST',		//HTTP请求的方法，这里是GET
					dataType: 'text',	//预期返回数据类型
					data: {"op":op,"np":np,"np1":np1},			//POST需要的数据
					error: function(){	//当发生错误时候的回调
						alert("error");
					},
					timeout: function(){//发生请求超时的回调
						alert('time out');
					},
					success: function(data){//成功以后的回调，也就是readyStatus=4且status=200
						console.log(data);
						if(data == 'success'){
							layer.msg('修改成功！',{icon:1,time:2000});
							setTimeout(closelayer,1000);
						}else if(data == 'fail'){
							layer.msg('未修改',{icon:2,time:2000});
							
						}else if(data == 'wrong'){
							layer.msg('原密码错误！',{icon:3,time:2000});
							
						}
					}
				});

		}
	}
	
	//var formdata = new FormData(document.forms[0]);
	

}

function closelayer(){

	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    parent.layer.close(index);

}


</script> 
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>
<?php $mysqli->close();?>