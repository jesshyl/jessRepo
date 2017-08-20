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
@$currentPage = 'statistics-list.php';;
@$maxRows = 40;
@$pageNum = 0;
if (isset($_GET['pageNum'])) {
	if(isset($_POST['rs'])){
	  @$pageNum=0;
	  }else{
		 @$pageNum = @$_GET['pageNum']; }
  }

@$startRow = @$pageNum * @$maxRows;
$mysqli->set_charset('utf8');
@$all = "select * from events";
$case="";@$datemin="";@$datemax="";
if(isset($_GET['sensor_num'])&&$_GET['sensor_num']!=""){
	$where = " where ";$case = "sensor_num = '".$_GET['sensor_num']."'";
	//$currentPage = $currentPage."?sensor_num=".$_GET['sensor_num']."&";
}

if(isset($_POST['datemin'])){
	$status = trim($_POST['status_select']);
	$datemin = trim($_POST['datemin']);
	$datemax = trim($_POST['datemax']);
		if($datemin!=""){
			if($datemax!=""){
				if($status!=9){//都不为空
					$case = "and rec_time >= '".$datemin."' and rec_time <= '".date('Y-m-d',strtotime($datemax." + 1 day"))."' and status = ".$status;
				}else{//status空
					$case = "and rec_time >= '".$datemin."' and rec_time <= '".date('Y-m-d',strtotime($datemax." + 1 day"))."'";
				}
			}else{
				if($status!=9){//datemax空
					$case = "and rec_time >= '".$datemin."' and status = ".$status;
				}else{//datemax和status空
					$case = "and rec_time >= '".$datemin."'";
				}
			}
	}else{
		if($datemax!=""){
			if($status!=9){//datemin空
				$case = "and rec_time <= '".date('Y-m-d',strtotime($datemax." + 1 day"))."' and status = ".$status;
			}else{//datemin和status空
				$case = "and rec_time <= '".date('Y-m-d',strtotime($datemax." + 1 day"))."'";
			}
		}else{
			if($status!=9){//datemin和datemax空
				$case = "and status = ".$status;
			}else{//全空
				$case = "";
			}
		}
	}	

}
	

@$lim = sprintf(" order by id desc LIMIT %d, %d", 
					@$startRow, @$maxRows);                    //每页行数
@$query_Recordset1 = @$all;
if(isset($_GET['recordset2'])){
	$_SESSION['recordset'] = $_GET['recordset2'];
	@$query_Recordset1 = urldecode($_GET['recordset2']);
}else if(isset($_GET['sensor_num'])){
	$_SESSION['recordset'] = "select * from events where sensor_num = '".$_GET['sensor_num']."' ";
	@$query_Recordset1 = $_SESSION['recordset'];
}
if(isset($_GET['recordset1'])){
	@$query_Recordset1 = urldecode($_GET['recordset1']);
}
if(isset($_POST['rs'])){
	@$query_Recordset1 = $_SESSION['recordset'].@$case;	
}
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
//echo $query_limit_Recordset1;
//var_dump($_POST);

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
<title>历史数据列表</title>
</head>
<body>
<form method="post" name="form1" id="form1" action="<?php echo $currentPage;?>">
<div class="page-container">
	<div class="text-c"> 日期范围：
		<input type="text" value="<?php echo @$datemin?>" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
		-
		<input type="text" value="<?php echo @$datemax?>" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
		<select style="width:100px;height:30px" id="status_select" name="status_select">
			<option value='9'>---状态---</option>
			<option value='0'>正常</option>
			<option value='1'>预警</option>
			<option value='2'>报警</option>
		</select>
		<button class="btn btn-success radius" id="searchbtn" name="searchbtn" ><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-bottom: 10px">共有&nbsp;<font style="font-weight: bold"><?php echo @$totalRows?></font>&nbsp;条数据，&nbsp;当前为第&nbsp;<font style="font-weight: bold;color:blue;"><?php echo @$pageNum+1;?></font>&nbsp;页&nbsp;&nbsp; </span>
    <span style="display:inline-block;float:right">
    	<a class="btn" href="<?php printf("%s?pageNum=%d&recordset1=%s", $currentPage, 0,urlencode($query_Recordset1)); ?>">首页</a> &nbsp;&nbsp; 
    	<a class="btn" href="<?php printf("%s?pageNum=%d&recordset1=%s", $currentPage, max(0, $pageNum - 1),urlencode($query_Recordset1)); ?>">上一页</a>&nbsp;&nbsp;
    	<a class="btn" href="<?php printf("%s?pageNum=%d&recordset1=%s", $currentPage, min($totalPages, $pageNum + 1),urlencode($query_Recordset1)); ?>
                    "> 下一页 </a> &nbsp;&nbsp; 
        <a class="btn" href="<?php printf("%s?pageNum=%d&recordset1=%s", $currentPage,$totalPages, urlencode($query_Recordset1)); ?>
                    "> 末页 </a> 
	</span>

	</div>
	<table class="table table-border table-bordered table-bg" id="table1" name="table1">
		<thead>
			<tr class="text-c">
				<th width="50">序号</th>
				<th width="50">操作</th>
				<th width="100">传感器号</th>
				<th width="100">当前值</th>
				<th width="50">单位</th>
				<th width="100">预警值</th>
				<th width="100">警报值</th>
				<th width="100">报警状态</th>
				<th width="200">记录时间</th>
				<th width="100">备注</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
<input type="hidden" name="rs" id="rs" value='rs'>
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
		

	$("#status_select option[value='<?php echo @$status; ?>']").prop("selected",true);

	<?php
		$st = $startRow+1; 
		while($event = @$Recordset1->fetch_assoc()){?>
			$("#table1 tbody").append("<tr class = 'text-c'><td><?php echo $st?></td><td><a title='编辑' href='javascript:;' onclick='event_edit(\"编辑\",\"event-edit.php?eid=<?php echo $event['id']?>\",\"4\",\"\",\"410\")' class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a><a title='删除' href='javascript:;' onclick='event_del(\"<?php echo $event['id'];?>\")' class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6e2;</i></a></td><td><a title='传感器' href='javascript:;' onclick='sensor_show(\"查看传感器\",\"sensor-show.php?snum=<?php echo trim($event['sensor_num'])?>\",\"4\",\"\",\"510\")' ><?php echo trim($event['sensor_num'])?></td></a><td><?php echo $event['value']?></td><td><?php echo $event['unit']?></td><td><?php echo $event['warning']?></td><td><?php echo $event['alarm']?></td><td><?php echo $event['status']?></td><td><?php echo $event['rec_time']?></td><td><?php echo $event['remarks']?></td></tr>");
	<?php $st++;};?>

});


/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*删除*/
function event_del(id){
	layer.confirm('确认要删除吗？',{offset:'20px'},function(){
		$.ajax({
			type: 'POST',
			url: 'event-delete.php',
			dataType: 'text',
			data:{eventid:id},
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

/*管理员-编辑*/
function event_edit(title,url,id,w,h){
	layer_show(title,url,w,h);
}

function sensor_show(title,url,id,w,h){
	layer_show(title,url,w,h);
}

</script>
</body>
</html>
<?php $mysqli->close();?>