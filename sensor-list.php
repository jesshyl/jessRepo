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
if (isset($_GET['pageNum'])) {
	if(isset($_POST['hidden'])&&@$_POST['hidden']=="cx"){
	  @$pageNum=0;
	  }else{
		 @$pageNum = @$_GET['pageNum']; }
  }
@$startRow = @$pageNum * @$maxRows;
$mysqli->set_charset('utf8');
@$all = "select * from sensors";
@$where="";$case="";@$sec_num="";@$se_num="";
if(isset($_POST['sensor_num'])){
	$se_num = GetSQLValueString(trim($_POST['sensor_num']),"text");
	$sec_num = GetSQLValueString(trim($_POST['section_mileage']),"date");
	if($_POST['sensor_num']!=""){
		$where = " where ";
		if($sec_num != 'blank'){
			$case = "sensor_num = ".$se_num." and section_mileage like '%".$sec_num."%'";	
		}else{
			$case = "sensor_num = ".$se_num;
		}
	}else{
		if($sec_num != 'blank'){
			$where = " where ";
			$case = "section_mileage like '%".$sec_num."%'";	
		}
	}
}
@$lim = sprintf(" order by id LIMIT %d, %d", 
					@$startRow, @$maxRows);                    //每页行数
@$query_Recordset1 = @$all.@$where.$case;
if(isset($_GET['recordset1'])){
	@$query_Recordset1 = urldecode($_GET['recordset1']);
}
//echo $query_Recordset1;
@$query_limit_Recordset1=@$query_Recordset1.@$lim;
@$Recordset1 = $mysqli->query(@$query_limit_Recordset1);
@$totalRecordset1 = $mysqli->query(@$query_Recordset1);
@$totalRows = $totalRecordset1->num_rows;	//当前条件数据总数
if(floor($totalRows/$maxRows)!=($totalRows/$maxRows)){
	$totalPages = floor($totalRows/$maxRows);					//总页数
}else{
	if($totalRows!=0){
		$totalPages=floor($totalRows/$maxRows)-1;
		}
	else{
		$totalPages=floor($totalRows/$maxRows);
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
<title>传感器管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 传感器列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<form id="form1" name="form1" action="sensor-list.php" method="post">
<input type="hidden" id="hidden" name="hidden" value="cx" />
<div class="page-container">
	<div class="text-c">断面号：
		<input type="hidden" name = "section_mileage" id="section_mileage" value="blank" />
		<select style="width:100px;height:30px" id="section_select" name="section_select">
			<option value="blank">请选择</option>
			<option value="JC1">JC1</option>
			<option value="JC2">JC2</option>
			<option value="JC3">JC3</option>
			<option value="JC4">JC4</option>
			<option value="JC5">JC5</option>
		</select>&nbsp;传感器编号：
		<input type="text" class="input-text" style="width:250px" placeholder="输入传感器编号" id="sensor_num" name="sensor_num" />
		<button class="btn btn-success radius" id="searchbtn" name="searchbtn"><i class="Hui-iconfont">&#xe665;</i> 搜索传感器</button>
		<a href="javascript:;" onclick="sensor_add('添加传感器','sensor-new.php','','510')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加传感器</a>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l">共有&nbsp;<font style="font-weight: bold"><?php echo $totalRows?></font>&nbsp;个传感器，&nbsp;当前为第&nbsp;<font style="font-weight: bold;color:blue;"><?php echo $pageNum+1;?></font>&nbsp;页&nbsp;&nbsp; </span>
    <span style="display:inline-block;float:right">
    	<a class="btn" href="<?php printf("%s?pageNum=%d&recordset1=%s", $currentPage, 0,urlencode($query_Recordset1)); ?>">首页</a> &nbsp;&nbsp; 
    	<a class="btn" href="<?php printf("%s?pageNum=%d&recordset1=%s", $currentPage, max(0, $pageNum - 1),urlencode($query_Recordset1)); ?>">上一页</a>&nbsp;&nbsp;
    	<a class="btn" href="<?php printf("%s?pageNum=%d&recordset1=%s", $currentPage, min($totalPages, $pageNum + 1),urlencode($query_Recordset1)); ?>
                    "> 下一页 </a> &nbsp;&nbsp; 
        <a class="btn" href="<?php printf("%s?pageNum=%d&recordset1=%s", $currentPage,$totalPages, urlencode($query_Recordset1)); ?>
                    "> 末页 </a> 
	</span>

	</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort" id="table1">
		<thead>
			<tr class="text-c">
				<th width="50">ID</th>
				<th width="100">操作</th>
                <th width="100">断面里程</th>
				<th width="100">管片编号</th>
				<th width="100">传感器编号</th>
				<th width="100">检测量说明</th>
				<th width="100">监测对象</th>
				<th width="100">物理量</th>
				<th width="100">测量方向</th>
                <th width="100">单位</th>
                <th width="100">预警值</th>
                <th width="100">报警值</th>
                <th width="100">传感器状态</th>
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

	$("#sensor_num").val("<?php if($se_num!=""){echo trim($_POST['sensor_num']);}?>");

	$("#section_mileage").val("<?php if($sec_num!=""){echo trim($_POST['section_mileage']);}?>");

	console.log($("#section_mileage").val());

	var section = $("#section_mileage").val();

	$("#section_select option:contains('<?php echo $sec_num; ?>')").attr("selected",true);

	$("#section_select").change(function(){
		$("#section_mileage").val($("#section_select option:selected").val());
	});


	<?php
		$st = $startRow+1; 
		while($sensor = @$Recordset1->fetch_assoc()){?>
			$("#table1 tbody").append("<tr class = 'text-c'><td><?php echo $st?></td><td><a title='编辑' href='javascript:;' onclick='sensor_edit(\"编辑&nbsp;<?php echo $sensor['sensor_num']?>\",\"sensor-edit.php?sid=<?php echo $sensor['id']?>\",\"4\",\"\",\"510\")' class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a><a title='删除' href='javascript:;' onclick='sensor_del(\"<?php echo $sensor['id'];?>\")' class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6e2;</i></a></td><td><?php echo $sensor['section_mileage']?></td><td><?php echo $sensor['segment_num']?></td><td><?php echo $sensor['sensor_num']?></td><td><?php echo trim($sensor['detection']);?></td><td><?php echo trim($sensor['obj']);?></td><td><?php echo $sensor['quantity']?></td><td><?php echo $sensor['direction']?></td><td><?php echo $sensor['unit']?></td><td><?php echo sprintf("%.3f", $sensor['warning'])?></td><td><?php echo sprintf("%.3f", $sensor['alarm'])?></td><td><?php echo $sensor['status']?></td></tr>");
	<?php $st++;};?>
	

});

/*上一页*/
function ppage(){
	var ppn = <?php echo $pageNum;?>;
	if(ppn>0){
		ppn = ppn-2;
	}
	window.location.href = "sensor-list.php"+"?pageNum="+ppn;
}

/*下一页*/
function npage(){
	var npn = <?php echo $pageNum;?>;
	var mpn =<?php echo $totalRows;?>;
	if(npn<mpn){
		window.location.href = "sensor-list.php"+"?pageNum="+npn;
		}
}

/*添加*/
function sensor_add(title,url,w,h){
	layer_show(title,url,w,h);
}

/*编辑*/
function sensor_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

/*删除*/
function sensor_del(id){
	layer.confirm('确认要删除吗？',function(){
		$.ajax({
			type: 'POST',
			url: 'sensor-delete.php',
			dataType: 'text',
			data:{sensorid:id},
			success: function(data){
				if(data == 'success'){
					layer.msg('已删除!即将刷新...',{icon:1,time:2000});
					setTimeout(refreshs,2000);
				}else{
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