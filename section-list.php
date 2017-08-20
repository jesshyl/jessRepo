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
@$currentPage = $_SERVER["PHP_SELF"];
@$maxRows = 40;
@$pageNum = 0;
@$startRow = @$pageNum * @$maxRows;
$mysqli->set_charset('utf8');
@$all = "select * from demods";
@$Recordset1 = $mysqli->query(@$all);
@$totalRows = @$Recordset1->num_rows;
?>
<!DOCTYPE HTML>
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
<title>解调仪管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 解调仪列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<form id="form1" name="form1" action="section-list.php" method="post">
<input type="hidden" id="hidden" name="hidden" value="cx" />
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">共有&nbsp;<font style="font-weight: bold"><?php echo $totalRows?></font>&nbsp;个解调仪&nbsp;&nbsp;<a href="javascript:;" onclick="section_add('添加断面','section-new.php','','400')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加解调仪</a>&nbsp;&nbsp; </span>
	</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort" id="table1">
		<thead>
			<tr class="text-c">
				<th width="50">序号</th>
				<th width="50">操作</th>
				<th width="100">解调仪</th>
				<th width="100">IP地址</th>
				<th width="100">子网掩码</th>
				<th width="100">网关</th>
                <th width="100">备注</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
    </div>
</div>
</form>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
$(function(){

	<?php
		$st = $startRow+1; 
		while($demod = @$Recordset1->fetch_assoc()){?>
			$("#table1 tbody").append("<tr class = 'text-c'><td><?php echo $st?></td><td><a title='编辑' href='javascript:;' onclick='section_edit(\"编辑&nbsp;<?php echo $demod['id']?>\",\"section-edit.php?sid=<?php echo $demod['id']?>\",\"4\",\"\",\"380\")' class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a><a title='删除' href='javascript:;' onclick='section_del(\"<?php echo $demod['id'];?>\")' class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6e2;</i></a></td><td><?php echo $demod['demod_name']?></td><td><?php echo $demod['ip']?></td><td><?php echo $demod['mask']?></td><td><?php echo $demod['gate']?></td><td><?php echo $demod['remarks']?></td></tr>");
	<?php $st++;};?>
	

});

/*添加*/
function section_add(title,url,w,h){
	layer_show(title,url,w,h);
}

/*编辑*/
function section_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*删除*/
function section_del(id){
	layer.confirm('确认要删除吗？',{offset:'20px'},function(){
		$.ajax({
			type: 'POST',
			url: 'section-delete.php',
			dataType: 'text',
			data:{sectionid:id},
			success: function(data){
				console.log(data);
				if(data == 'success'){
					layer.msg('已删除!即将刷新...',{icon:1,time:2000});
					setTimeout(refreshs,2000);
				}else if(data == 'fail'){
					layer.msg('删除失败',{icon:2,time:2000});
				}
			},
			error:function(data) {
				console.log(data.msg);
			},
		});		
	});
}

function refreshs(){
	window.location.reload();
}
</script> 
</body>
</html>
<?php $mysqli->close();?>