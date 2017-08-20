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
@$currentPage = $_SERVER["PHP_SELF"];
@$Recordset1 = $mysqli->query(@$query_limit_Recordset1);
$result1_str = "select * from sensors where obj = '钢筋' and quantity = '应变' ";
$result1 = $mysqli->query($result1_str);
$result2_str = "select * from sensors where obj = '混凝土' and quantity = '应变' ";
$result2 = $mysqli->query($result2_str);
$result3_str = "select * from sensors where quantity = '温度' ";
$result3 = $mysqli->query($result3_str);
$result4_str = "select * from sensors where obj = '管片接缝' and quantity = '位移' ";
$result4 = $mysqli->query($result4_str);
$result5_str = "select * from sensors where obj = '螺栓' and quantity = '应变' ";
$result5 = $mysqli->query($result5_str);

$events1_str = "select * from events where obj = '钢筋' and quantity = '应变'";
$events2_str = "select * from events where obj = '混凝土' and quantity = '应变' ";
$events3_str = "select * from events where quantity = '温度' ";
$events4_str = "select * from events where obj = '管片接缝' and quantity = '位移' ";
$events5_str = "select * from events where obj = '螺栓' and quantity = '应变' ";

$case1 = " and section_mileage like '%JK1%' ";
$case2 = " and section_mileage like '%JK2%' ";
$case3 = " and section_mileage like '%JK3%' ";
$case4 = " and section_mileage like '%JK4%' ";
$case5 = " and section_mileage like '%JK5%' ";
$case6 = " and section_mileage like '%JK6%' ";
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
<title>数据管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 数据管理 <span class="c-gray en">&gt;</span> 历史数据 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<table class="table" style="height:100%">
	<tr>
		<td width="180px" class="va-t"><ul id="treeDemo" class="ztree"></ul></td>
		<td class="va-t"><iframe ID="testIframe" Name="testIframe" FRAMEBORDER=0 SCROLLING=AUTO width=100%  height=1700 SRC="statistics-list.php" ></iframe></td>
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

$(function(){


});


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
				//zTree.expandNode(treeNode);
				//return false;
				console.log("statistics-list.php?recordset1="+encodeURIComponent(treeNode.qstr));
				demoIframe.attr("src","statistics-list.php?recordset2="+encodeURIComponent(treeNode.qstr));
				return true;
			} else {
				demoIframe.attr("src","statistics-list.php?sensor_num="+encodeURIComponent(treeNode.name));
				return true;
			}
		}
	}
};


var rootNode =[
	{ id:1, pId:0, name:"南京过江隧道", open:true, qstr:"select * from events"},
];
		
var code;
function showCode(str) {
	if (!code) code = $("#code");
	code.empty();
	code.append("<li>"+str+"</li>");
}
		
$(function(){
	
	var zNode1 = [{ id:11, pId:1, name:"管片钢筋应变监测项",qstr:"<?php echo $events1_str;?>"}];
	var zNode11 = [{ id:111, pId:11, name:"JK1",qstr:"<?php echo $events1_str.$case1;?>"}];
	var zNode12 = [{ id:112, pId:11, name:"JK2",qstr:"<?php echo $events1_str.$case2;?>"}];
	var zNode13 = [{ id:113, pId:11, name:"JK3",qstr:"<?php echo $events1_str.$case3;?>"}];
	var zNode14 = [{ id:114, pId:11, name:"JK4",qstr:"<?php echo $events1_str.$case4;?>"}];
	var zNode15 = [{ id:115, pId:11, name:"JK5",qstr:"<?php echo $events1_str.$case5;?>"}];
	var zNode16 = [{ id:116, pId:11, name:"JK6",qstr:"<?php echo $events1_str.$case6;?>"}];
	var zNode2 = [{ id:12, pId:1, name:"管片混凝土应变监测项",qstr:"<?php echo $events2_str;?>"}];
	var zNode21 = [{ id:121, pId:12, name:"JK1",qstr:"<?php echo $events2_str.$case1;?>"}];
	var zNode22 = [{ id:122, pId:12, name:"JK2",qstr:"<?php echo $events2_str.$case2;?>"}];
	var zNode23 = [{ id:123, pId:12, name:"JK3",qstr:"<?php echo $events2_str.$case3;?>"}];
	var zNode24 = [{ id:124, pId:12, name:"JK4",qstr:"<?php echo $events2_str.$case4;?>"}];
	var zNode25 = [{ id:125, pId:12, name:"JK5",qstr:"<?php echo $events2_str.$case5;?>"}];
	var zNode26 = [{ id:126, pId:12, name:"JK6",qstr:"<?php echo $events2_str.$case6;?>"}];
	var zNode3 = [{ id:13, pId:1, name:"管片温度监测项",qstr:"<?php echo $events3_str;?>"}];
	var zNode31 = [{ id:131, pId:13, name:"JK1",qstr:"<?php echo $events3_str.$case1;?>"}];
	var zNode32 = [{ id:132, pId:13, name:"JK2",qstr:"<?php echo $events3_str.$case2;?>"}];
	var zNode33 = [{ id:133, pId:13, name:"JK3",qstr:"<?php echo $events3_str.$case3;?>"}];
	var zNode34 = [{ id:134, pId:13, name:"JK4",qstr:"<?php echo $events3_str.$case4;?>"}];
	var zNode35 = [{ id:135, pId:13, name:"JK5",qstr:"<?php echo $events3_str.$case5;?>"}];
	var zNode36 = [{ id:136, pId:13, name:"JK6",qstr:"<?php echo $events3_str.$case6;?>"}];
	var zNode4 = [{ id:14, pId:1, name:"管片接缝位移监测项",qstr:"<?php echo $events4_str;?>"}];
	var zNode41 = [{ id:141, pId:14, name:"JK1",qstr:"<?php echo $events4_str.$case1;?>"}];
	var zNode42 = [{ id:142, pId:14, name:"JK2",qstr:"<?php echo $events4_str.$case2;?>"}];
	var zNode43 = [{ id:143, pId:14, name:"JK3",qstr:"<?php echo $events4_str.$case3;?>"}];
	var zNode44 = [{ id:144, pId:14, name:"JK4",qstr:"<?php echo $events4_str.$case4;?>"}];
	var zNode45 = [{ id:145, pId:14, name:"JK5",qstr:"<?php echo $events4_str.$case5;?>"}];
	var zNode46 = [{ id:146, pId:14, name:"JK6",qstr:"<?php echo $events4_str.$case6;?>"}];
	var zNode5 = [{ id:15, pId:1, name:"管片螺栓应变监测项",qstr:"<?php echo $events5_str;?>"}];
	var zNode51 = [{ id:151, pId:15, name:"JK1",qstr:"<?php echo $events5_str.$case1;?>"}];
	var zNode52 = [{ id:152, pId:15, name:"JK2",qstr:"<?php echo $events5_str.$case2;?>"}];
	var zNode53 = [{ id:153, pId:15, name:"JK3",qstr:"<?php echo $events5_str.$case3;?>"}];
	var zNode54 = [{ id:154, pId:15, name:"JK4",qstr:"<?php echo $events5_str.$case4;?>"}];
	var zNode55 = [{ id:155, pId:15, name:"JK5",qstr:"<?php echo $events5_str.$case5;?>"}];
	var zNode56 = [{ id:156, pId:15, name:"JK6",qstr:"<?php echo $events5_str.$case6;?>"}];
	var zNodes;
//添加第一个监测项的分支
	<?php while($res1 = $result1->fetch_assoc()) {?>
		var sensorid = <?php echo $res1['id'];?>;
		var sensor_segment = <?php echo "'".$res1['section_mileage']."'";?>;
		var sensorname1 = <?php echo "'".$res1['sensor_num']."'";?>;
		if(sensor_segment.indexOf('JK1')>=0){
			sensorid1 = '111'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode11.push({id:sensorid1,pId:111,name:sensorname1});
		}else if(sensor_segment.indexOf('JK2')>=0){
			sensorid1 = '112'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode12.push({id:sensorid1,pId:112,name:sensorname1});
		}else if(sensor_segment.indexOf('JK3')>=0){
			sensorid1 = '113'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode13.push({id:sensorid1,pId:113,name:sensorname1});
		}else if(sensor_segment.indexOf('JK4')>=0){
			sensorid1 = '114'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode14.push({id:sensorid1,pId:114,name:sensorname1});
		}else if(sensor_segment.indexOf('JK5')>=0){
			sensorid1 = '115'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode15.push({id:sensorid1,pId:115,name:sensorname1});
		}else if(sensor_segment.indexOf('JK6')>=0){
			sensorid1 = '116'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode16.push({id:sensorid1,pId:116,name:sensorname1});
		}
	<?php }?>
//添加第二个监测项的分支
	<?php while($res1 = $result2->fetch_assoc()) {?>
		var sensorid = <?php echo $res1['id'];?>;
		var sensor_segment = <?php echo "'".$res1['section_mileage']."'";?>;
		var sensorname1 = <?php echo "'".$res1['sensor_num']."'";?>;
		if(sensor_segment.indexOf('JK1')>=0){
			sensorid1 = '121'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode21.push({id:sensorid1,pId:121,name:sensorname1});
		}else if(sensor_segment.indexOf('JK2')>=0){
			sensorid1 = '122'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode22.push({id:sensorid1,pId:122,name:sensorname1});
		}else if(sensor_segment.indexOf('JK3')>=0){
			sensorid1 = '123'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode23.push({id:sensorid1,pId:123,name:sensorname1});
		}else if(sensor_segment.indexOf('JK4')>=0){
			sensorid1 = '124'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode24.push({id:sensorid1,pId:124,name:sensorname1});
		}else if(sensor_segment.indexOf('JK5')>=0){
			sensorid1 = '125'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode25.push({id:sensorid1,pId:125,name:sensorname1});
		}else if(sensor_segment.indexOf('JK6')>=0){
			sensorid1 = '126'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode26.push({id:sensorid1,pId:126,name:sensorname1});
		}
	<?php }?>
//添加第三个监测项的分支
	<?php while($res1 = $result3->fetch_assoc()) {?>
		var sensorid = <?php echo $res1['id'];?>;
		var sensor_segment = <?php echo "'".$res1['section_mileage']."'";?>;
		var sensorname1 = <?php echo "'".$res1['sensor_num']."'";?>;
		if(sensor_segment.indexOf('JK1')>=0){
			sensorid1 = '131'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode31.push({id:sensorid1,pId:131,name:sensorname1});
		}else if(sensor_segment.indexOf('JK2')>=0){
			sensorid1 = '132'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode32.push({id:sensorid1,pId:132,name:sensorname1});
		}else if(sensor_segment.indexOf('JK3')>=0){
			sensorid1 = '133'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode33.push({id:sensorid1,pId:133,name:sensorname1});
		}else if(sensor_segment.indexOf('JK4')>=0){
			sensorid1 = '134'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode34.push({id:sensorid1,pId:134,name:sensorname1});
		}else if(sensor_segment.indexOf('JK5')>=0){
			sensorid1 = '135'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode35.push({id:sensorid1,pId:135,name:sensorname1});
		}else if(sensor_segment.indexOf('JK6')>=0){
			sensorid1 = '136'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode36.push({id:sensorid1,pId:136,name:sensorname1});
		}
	<?php }?>
//添加第四个监测项的分支
	<?php while($res1 = $result4->fetch_assoc()) {?>
		var sensorid = <?php echo $res1['id'];?>;
		var sensor_segment = <?php echo "'".$res1['section_mileage']."'";?>;
		var sensorname1 = <?php echo "'".$res1['sensor_num']."'";?>;
		if(sensor_segment.indexOf('JK1')>=0){
			sensorid1 = '141'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode41.push({id:sensorid1,pId:141,name:sensorname1});
		}else if(sensor_segment.indexOf('JK2')>=0){
			sensorid1 = '142'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode42.push({id:sensorid1,pId:142,name:sensorname1});
		}else if(sensor_segment.indexOf('JK3')>=0){
			sensorid1 = '143'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode43.push({id:sensorid1,pId:143,name:sensorname1});
		}else if(sensor_segment.indexOf('JK4')>=0){
			sensorid1 = '144'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode44.push({id:sensorid1,pId:144,name:sensorname1});
		}else if(sensor_segment.indexOf('JK5')>=0){
			sensorid1 = '145'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode45.push({id:sensorid1,pId:145,name:sensorname1});
		}else if(sensor_segment.indexOf('JK6')>=0){
			sensorid1 = '146'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode46.push({id:sensorid1,pId:146,name:sensorname1});
		}
	<?php }?>
//添加第五个监测项的分支
	<?php while($res1 = $result5->fetch_assoc()) {?>
		var sensorid = <?php echo $res1['id'];?>;
		var sensor_segment = <?php echo "'".$res1['section_mileage']."'";?>;
		var sensorname1 = <?php echo "'".$res1['sensor_num']."'";?>;
		if(sensor_segment.indexOf('JK1')>=0){
			sensorid1 = '151'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode51.push({id:sensorid1,pId:151,name:sensorname1});
		}else if(sensor_segment.indexOf('JK2')>=0){
			sensorid1 = '152'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode52.push({id:sensorid1,pId:152,name:sensorname1});
		}else if(sensor_segment.indexOf('JK3')>=0){
			sensorid1 = '153'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode53.push({id:sensorid1,pId:153,name:sensorname1});
		}else if(sensor_segment.indexOf('JK4')>=0){
			sensorid1 = '154'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode54.push({id:sensorid1,pId:154,name:sensorname1});
		}else if(sensor_segment.indexOf('JK5')>=0){
			sensorid1 = '155'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode55.push({id:sensorid1,pId:155,name:sensorname1});
		}else if(sensor_segment.indexOf('JK6')>=0){
			sensorid1 = '156'+sensorid;
			sensorid1 = parseInt(sensorid1);
			zNode56.push({id:sensorid1,pId:156,name:sensorname1});
		}
	<?php }?>

	

	zNode1 = zNode1.concat(zNode11,zNode12,zNode13,zNode14,zNode15,zNode16);
	zNode2 = zNode2.concat(zNode21,zNode22,zNode23,zNode24,zNode25,zNode26);
	zNode3 = zNode3.concat(zNode31,zNode32,zNode33,zNode34,zNode35,zNode36);
	zNode4 = zNode4.concat(zNode41,zNode42,zNode43,zNode44,zNode45,zNode46);
	zNode5 = zNode5.concat(zNode51,zNode52,zNode53,zNode54,zNode55,zNode56);
	zNodes = rootNode.concat(zNode1,zNode2,zNode3,zNode4,zNode5);
	
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