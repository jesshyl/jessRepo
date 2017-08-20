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
$mysqli->query("set names utf8");
$result4_str = "select * from sensors where detection like '%位移%'";
$result4 = $mysqli->query($result4_str);

$result5_str = "select * from sensors where detection like '%温度%'";
$result5 = $mysqli->query($result5_str);

$result6_str = "select * from sensors where detection like '%高差%'";
$result6 = $mysqli->query($result6_str);
/*
$get_sensors_str = "select * from sensors group by section_mileage";
$get_sensors_result = $mysqli->query($get_sensors_str);
$sections_arr = array();
$sections_count = $get_sensors_result->num_rows;
while($sensor = $get_sensors_result->fetch_assoc()){
	preg_match_all("/(\w+)/",$sensor['section_mileage'],$m);
	$sec = $m[1][0];
	array_push($sections_arr,$sec);
}
sort($sections_arr);

//print_r($sections_arr);
$case1 = " and section_mileage like '%JK1%' ";
$case2 = " and section_mileage like '%JK2%' ";
$case3 = " and section_mileage like '%JK3%' ";
$case4 = " and section_mileage like '%JK4%' ";
$case5 = " and section_mileage like '%JK5%' ";
*/
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
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/style.css" />
<link rel="stylesheet" href="lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>实时显示</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 实时数据 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<table class="table" style="height:100%">
	<tr>
		<td width="180px" class="va-t"><ul id="treeDemo" class="ztree"></ul></td>
		<td class="va-t"><iframe ID="testIframe" Name="testIframe" FRAMEBORDER=0 SCROLLING=AUTO width=100% height=1000px src="real-time-figure.php"></iframe></td>
	</tr>
</table>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/zTree/v3/js/jquery.ztree.all-3.5.min.js"></script> 
<script type="text/javascript">

var setting = {
	view: {
		dblClickExpand: false,
		showLine: false,
		selectedMulti: false
	},
	data: {
		simpleData: {
			enable:true,
			idKey: "id",
			pIdKey: "pId",
			rootPId: ""
		}
	},
	callback: {
		beforeClick: function(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("tree");
			if (treeNode.isParent) {
				return false;
			} else {
				if(treeNode.name.indexOf('JC')<0){
					demoIframe.attr("src","real-time-figure.php?sensor_num="+encodeURIComponent(treeNode.name));
				}
				return true;
			}
		}
	}
};


var rootNode =[
	{ id:1, pId:0, name:"南京过江隧道", open:true},
];
		
var code;
function showCode(str) {
	if (!code) code = $("#code");
	code.empty();
	code.append("<li>"+str+"</li>");
}
		
$(function(){
	
	
	var zNode4 = [{ id:14, pId:1, name:"管片接缝位移监测项"}];
	var zNode41 = [{ id:141, pId:14, name:"JC1"}];
	var zNode42 = [{ id:142, pId:14, name:"JC2"}];
	var zNode43 = [{ id:143, pId:14, name:"JC3"}];
	var zNode44 = [{ id:144, pId:14, name:"JC4"}];
	var zNode45 = [{ id:145, pId:14, name:"JC5"}];
	
	var zNode5 = [{ id:15, pId:1, name:"管片温度监测项"}];
	var zNode51 = [{ id:151, pId:15, name:"JC1"}];
	var zNode52 = [{ id:152, pId:15, name:"JC2"}];
	var zNode53 = [{ id:153, pId:15, name:"JC3"}];
	var zNode54 = [{ id:154, pId:15, name:"JC4"}];
	var zNode55 = [{ id:155, pId:15, name:"JC5"}];
	
	var zNode6 = [{ id:16, pId:1, name:"差异沉降监测项"}];
	var zNode61 = [{ id:161, pId:16, name:"JC1"}];
	var zNode62 = [{ id:162, pId:16, name:"JC2"}];
	var zNode63 = [{ id:163, pId:16, name:"JC3"}];
	var zNode64 = [{ id:164, pId:16, name:"JC4"}];
	var zNode65 = [{ id:165, pId:16, name:"JC5"}];

	var zNodes;

//添加管片接缝监测项的分支
	<?php while($res1 = $result4->fetch_assoc()) {?>
		var sensorid = <?php echo $res1['id'];?>;
		var sensor_section = <?php echo "'".$res1['section_mileage']."'";?>;
		var sensorname1 = <?php echo "'".$res1['sensor_num']."'";?>;
		if(sensor_section.indexOf('JC1')>=0){
			sensorid1 = '141'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode41.push({id:sensorid1,pId:141,name:sensorname1});
		}else if(sensor_section.indexOf('JC2')>=0){
			sensorid1 = '142'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode42.push({id:sensorid1,pId:142,name:sensorname1});
		}else if(sensor_section.indexOf('JC3')>=0){
			sensorid1 = '143'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode43.push({id:sensorid1,pId:143,name:sensorname1});
		}else if(sensor_section.indexOf('JC4')>=0){
			sensorid1 = '144'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode44.push({id:sensorid1,pId:144,name:sensorname1});
		}else if(sensor_section.indexOf('JC5')>=0){
			sensorid1 = '145'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode45.push({id:sensorid1,pId:145,name:sensorname1});
		}
	<?php }?>	

//添加温度监测项的分支
	<?php while($res1 = $result5->fetch_assoc()) {?>
		var sensorid = <?php echo $res1['id'];?>;
		var sensor_section = <?php echo "'".$res1['section_mileage']."'";?>;
		var sensorname1 = <?php echo "'".$res1['sensor_num']."'";?>;
		if(sensor_section.indexOf('JC1')>=0){
			sensorid1 = '151'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode51.push({id:sensorid1,pId:151,name:sensorname1});
		}else if(sensor_section.indexOf('JC2')>=0){
			sensorid1 = '152'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode52.push({id:sensorid1,pId:152,name:sensorname1});
		}else if(sensor_section.indexOf('JC3')>=0){
			sensorid1 = '153'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode53.push({id:sensorid1,pId:153,name:sensorname1});
		}else if(sensor_section.indexOf('JC4')>=0){
			sensorid1 = '154'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode54.push({id:sensorid1,pId:154,name:sensorname1});
		}else if(sensor_section.indexOf('JC5')>=0){
			sensorid1 = '155'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode55.push({id:sensorid1,pId:155,name:sensorname1});
		}
	<?php }?>	

//添加差异沉降监测项的分支
	<?php while($res1 = $result6->fetch_assoc()) {?>
		var sensorid = <?php echo $res1['id'];?>;
		var sensor_section = <?php echo "'".$res1['section_mileage']."'";?>;
		var sensorname1 = <?php echo "'".$res1['sensor_num']."'";?>;
		if(sensor_section.indexOf('JC1')>=0){
			sensorid1 = '161'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode61.push({id:sensorid1,pId:161,name:sensorname1});
		}else if(sensor_section.indexOf('JC2')>=0){
			sensorid1 = '162'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode62.push({id:sensorid1,pId:162,name:sensorname1});
		}else if(sensor_section.indexOf('JC3')>=0){
			sensorid1 = '163'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode63.push({id:sensorid1,pId:163,name:sensorname1});
		}else if(sensor_section.indexOf('JC4')>=0){
			sensorid1 = '164'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode64.push({id:sensorid1,pId:164,name:sensorname1});
		}else if(sensor_section.indexOf('JC5')>=0){
			sensorid1 = '165'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode65.push({id:sensorid1,pId:165,name:sensorname1});
		}
	<?php }?>	

	zNode4 = zNode4.concat(zNode41,zNode42,zNode43,zNode44,zNode45);
	zNode5 = zNode5.concat(zNode51,zNode52,zNode53,zNode54,zNode55);
	zNode6 = zNode6.concat(zNode61,zNode62,zNode63,zNode64,zNode65);
	zNodes = rootNode.concat(zNode4,zNode5,zNode6);
	
	var t = $("#treeDemo");
	t = $.fn.zTree.init(t, setting, zNodes);
	demoIframe = $("#testIframe");
	//demoIframe.on("load", loadReady);
	var zTree = $.fn.zTree.getZTreeObj("tree");
	//zTree.selectNode(zTree.getNodeByParam("id",'11'));
});
</script>
</body>
</html>
<?php $mysqli->close();?>