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
@$currentPage = 'statistics-list-2.php';
@$currentPage1 = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
@$maxRows = 40;
@$pageNum = 0;
//echo $currentPage1."<br>";
if (isset($_GET['pageNum'])) {
	@$pageNum = @$_GET['pageNum']; 
}

@$startRow = @$pageNum * @$maxRows;
$mysqli->set_charset('utf8');
@$all = "select * from events";
$case="";@$datemin="";@$datemax="";

@$lim = sprintf(" order by id desc LIMIT %d, %d", 
					@$startRow, @$maxRows);                    //每页行数
@$query_Recordset1 = @$all;

$form_get = false;
$caseString = "";

if(isset($_GET['det'])||isset($_GET['dmin'])||
   isset($_GET['dmax'])||isset($_GET['sec'])||
   isset($_GET['sta'])){
	   $form_get = true;
	   }

if($form_get){
	$where = " ";
	$case0 = " detection like '%".$_GET['det']."%'";
	$case1 = " rec_time > '".$_GET['dmin']."' ";
	$case2 = " rec_time < '".date("Y-m-d",strtotime($_GET['dmax']." + 1 day"))."' ";
	$case3 = " section_mileage like '%".$_GET['sec']."%' ";
	$case4 = " status = '".$_GET['sta']."' ";
	$case5 = " sensor_num = '".$_GET['ses']."' ";
	$case_arr = array();
	$case_str_arr = array();
	$case_arr[0] = $_GET['det'];
	$case_arr[1] = $_GET['dmin'];
	$case_arr[2] = $_GET['dmax'];
	$case_arr[3] = $_GET['sec'];
	$case_arr[4] = $_GET['sta'];
	$case_arr[5] = $_GET['ses'];
	$case_str_arr[0] = $case0;
	$case_str_arr[1] = $case1;
	$case_str_arr[2] = $case2;
	$case_str_arr[3] = $case3;
	$case_str_arr[4] = $case4;
	$case_str_arr[5] = $case5;
	$caseString = "";
	for($i=0;$i<6;$i++){
		if($case_arr[$i]!=""){
			for($j=$i+1;$j<6;$j++){
				$case_str_arr[$j] = " and ".$case_str_arr[$j];
				}
			break;
			}
		}
	for($k=0;$k<6;$k++){
		if($case_arr[$k]!=""){
			$caseString = $caseString.$case_str_arr[$k];
			}
		}
	if(trim($caseString)!=""){
		$where = " where ";
	}
}

@$query_Recordset1 = @$query_Recordset1.$where.$caseString;
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
//echo $currentPage1."<br>";
//var_dump($_GET);
$pos = strpos($currentPage1,'pageNum');
//echo $pos."<br>";
if($pos!=""){
	$currentPage2 = substr($currentPage1,0,$pos-1);
	}else{
		$currentPage2 = $currentPage1;
		}
//echo $currentPage2;
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
<style>
	body{
		min-width:992px;}
</style>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 历史数据 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<form method="get" name="form1" id="form1" action="<?php echo $currentPage;?>">
<div class="page-container">
    <div class="container-fluid" style="margin-bottom:15px">
    	<div class="row">
    		<span style="display: inline-block;width:80px">断面号：</span>
		<span style="display: inline-block;width:100px">
		<select name="sec" id="sec" style="width:80px;height:30px">
        	<option value="">-请选择-</option>
            <option value="JC1">JC1</option>
            <option value="JC2">JC2</option>
            <option value="JC3">JC3</option>
            <option value="JC4">JC4</option>
            <option value="JC5">JC5</option>
        </select>
    </span><span style="display: inline-block;width:80px">
    监测项：</span><span style="display: inline-block;width:100px">
		<select name="det" id="det" style="width:90px;height:30px">
        	<option value="">-请选择-</option>
            <option value="位移">接缝位移</option>
            <option value="温度">温度</option>
            <option value="高差">差异沉降</option>
        </select>
    </span><span style="display: inline-block;width:80px">
    传感器号：</span><span style="display: inline-block;width:100px">
		<select name="ses" id="ses" style="width:100px;height:30px">
        	<option value="">-请选择-</option>
        </select>
    </span>
    	</div>
    </div>
    <div class="container-fluid">
    	<div class="row">
    	<span style="display: inline-block;width:80px">日期范围：</span>
    	<span style="display: inline-block;width:120px">
    		<input type="text" value="<?php echo @$datemin?>" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'dmax\')||\'%y-%M-%d\'}' })" id="dmin" name="dmin" class="input-text Wdate" style="width:120px;"></span><span style="display: inline-block;width:30px">&nbsp;&nbsp;&nbsp;-&nbsp;</span><span style="display: inline-block;width:130px">
		<input type="text" value="<?php echo @$datemax?>" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'dmin\')}',maxDate:'%y-%M-%d' })" id="dmax" name="dmax" class="input-text Wdate" style="width:120px;">
		</span><span style="display: inline-block;width:80px">状态：</span><span style="display: inline-block;width:100px">
        <select style="width:100px;height:30px" id="sta" name="sta">
			<option value=''>-请选择-</option>
			<option value='0'>正常</option>
			<option value='1'>预警</option>
			<option value='2'>报警</option>
		</select></span>
		<span style="display: inline-block;width:80px">
			<button class="btn btn-success radius" id="searchbtn" name="searchbtn" ><i class="Hui-iconfont">&#xe665;</i> 搜索</button></span>
	</div>
	</div>
	<div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-bottom: 10px">共有&nbsp;<font style="font-weight: bold"><?php echo @$totalRows?></font>&nbsp;条数据，&nbsp;当前为第&nbsp;<font style="font-weight: bold;color:blue;"><?php echo @$pageNum+1;?></font>&nbsp;页&nbsp;&nbsp; </span>
    <span style="display:inline-block;float:right">
    	<a class="btn" href="<?php printf("%s&pageNum=%d", $currentPage2, 0); ?>">首页</a> &nbsp;&nbsp; 
    	<a class="btn" href="<?php printf("%s&pageNum=%d", $currentPage2, max(0, $pageNum - 1)); ?>">上一页</a>&nbsp;&nbsp;
    	<a class="btn" href="<?php printf("%s&pageNum=%d", $currentPage2, min($totalPages, $pageNum + 1)); ?>
                    "> 下一页 </a> &nbsp;&nbsp; 
        <a class="btn" href="<?php printf("%s&pageNum=%d", $currentPage2,$totalPages, urlencode($query_Recordset1)); ?>
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
	$("#sta option[value='<?php echo @$_GET['sta']; ?>']").prop("selected",true);
	$("#sec option:contains('<?php echo @$_GET['sec']; ?>')").prop("selected",true);
	$("#det option[value='<?php echo @$_GET['det']; ?>']").prop("selected",true);
	//$("#ses option[value='<?php echo @$_GET['ses']; ?>']").prop("selected",true);
	$("#dmin").val('<?php echo @$_GET['dmin']?>');
	$("#dmax").val('<?php echo @$_GET['dmax']?>');

	<?php
		$st = $startRow+1; 
		while($event = @$Recordset1->fetch_assoc()){?>
			$("#table1 tbody").append("<tr class = 'text-c'><td><?php echo $st?></td><td><a title='编辑' href='javascript:;' onclick='event_edit(\"编辑\",\"event-edit.php?eid=<?php echo $event['id']?>\",\"4\",\"\",\"410\")' class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a><a title='删除' href='javascript:;' onclick='event_del(\"<?php echo $event['id'];?>\")' class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6e2;</i></a></td><td><a title='传感器' href='javascript:;' onclick='sensor_show(\"查看传感器\",\"sensor-show.php?snum=<?php echo trim($event['sensor_num'])?>\",\"4\",\"\",\"510\")' ><?php echo trim($event['sensor_num'])?></td></a><td><?php echo $event['value']?></td><td><?php echo $event['unit']?></td><td><?php echo $event['warning']?></td><td><?php echo $event['alarm']?></td><td><?php echo $event['status']?></td><td><?php echo $event['rec_time']?></td><td><?php echo $event['remarks']?></td></tr>");
	<?php $st++;};?>

	$.get("sensor-section.php",{sn:"<?php echo @$_GET['sec']?>",dt:"<?php echo @$_GET['det']?>"},function(data){
				//console.log(data);
				$("#ses").empty();
				$("#ses").append("<option value=''>-请选择-</option>");
				var data1 = JSON.parse(data);
				//console.log(data1);
				for(var ii in data1){
					$("#ses").append("<option value='"+data1[ii]+"'>"+data1[ii]+"</option>");
				}
				$("#ses option[value='<?php echo @$_GET['ses']; ?>']").prop("selected",true);
			});

	$("#sec,#det").change(function(){
			//console.log($("#det").val());
			//if($("#ses option:selected").val())
			var sn1 = $("#sec").val();
			var sn2 = $("#ses").val();
			var dt = $("#det").val();
			$("#ses").empty();
			$("#ses").append("<option value=''>-请选择-</option>");
			
			$.get("sensor-section.php",{sn:sn1,dt:dt},function(data){
				//console.log(data);
				var data1 = JSON.parse(data);
				for(var ii in data1){
					$("#ses").append("<option value='"+data1[ii]+"'>"+data1[ii]+"</option>");
				}
				$("#ses option[value="+sn2+"]").prop("selected",true);
			});	
	});

	
	$("#ses").change(function(){
			//console.log('change');
			//if($("#ses option:selected").val())
			var sn1 = $("#sec").val();
			var dt = $("#det").val();
			var sn2 = $(this).val();
			$.get("sensor-section.php",{sn1:sn2},function(data){
				//console.log(data);
				var data1 = JSON.parse(data);
				$("#sec option[value="+data1[0].slice(0,3)+"]").prop("selected",true);
				$("#det option[value="+data1[2].slice(0,2)+"]").prop("selected",true);

			});	
	});
	
	/*
	$("#det").change(function(){
			//console.log('change');
			//if($("#ses option:selected").val())
			var sn1 = $("#sec").val();
			var sn2 = $("#ses").val();
			var dt = $("#det").val();
			$("#ses").empty();
			$("#ses").append("<option value=''>-请选择-</option>");
			$.post("sensor-section.php",{sn:sn1,dt,dt},function(data){
				console.log(data);
				var data1 = JSON.parse(data);
				for(var ii in data1){
					$("#ses").append("<option value='"+data1[ii][1]+"'>"+data1[ii][1]+"</option>");
				}
				$("#ses option[value="+sn2+"]").prop("selected",true);
			});	
	});
	*/

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