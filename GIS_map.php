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
$points = $mysqli->query("select * from position");
$pointarray = array();
while($point = $points->fetch_assoc()){
	$pointinfo = array();
	$pointinfo['pos_name'] = $point['pos_name'];
	$pointinfo['longitude'] = $point['longitude'];//经度
	$pointinfo['latitude'] = $point['latitude'];//纬度
	array_push($pointarray,$pointinfo);
}
$json_pointarray = json_encode($pointarray);

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/favicon.ico" >
<LINK rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5shiv.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>

<![endif]-->
<link href="static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="static/h-ui.admin/css/H-ui.admin.css" rel="stylesheet" type="text/css" />
<link href="lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css" />

<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>GIS 地图</title>
</head>
<body style="margin: 0px;height:100%">
<nav class="breadcrumb" style="padding: 0px 20px"><i class="Hui-iconfont">&#xe67f;</i> 首页<span class="c-gray en">&gt;</span> GIS 地图 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
            <div style="position:absolute;height:100%;width: 100%;padding: 0px" id="map">  
            </div>
            <script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
            <script type="text/javascript" src="http://api.map.baidu.com/library/CurveLine/1.5/src/CurveLine.min.js"></script>   
            <script type="text/javascript">  
                var markerArr = [];
                	//markerArr = [];
                	var allpoints = <?php echo $json_pointarray;?>;
                	//console.log(allpoints);
 					for(var index=0;index<allpoints.length;index++){
 						var obj = allpoints[index];
 						var obj1 = {title:obj['pos_name'],point:obj['longitude']+","+obj['latitude']};
 						markerArr.push(obj1);
 					}
  
                function map_init() {  
                    var map = new BMap.Map("map"); // 创建Map实例  
                    var point = new BMap.Point(118.694856, 32.052322); //地图中心点，南京市  
                    map.centerAndZoom(point, 14); // 初始化地图,设置中心点坐标和地图级别。  
                    map.enableScrollWheelZoom(true); //启用滚轮放大缩小  
                    //向地图中添加缩放控件  
                    var ctrlNav = new window.BMap.NavigationControl({  
                        anchor: BMAP_ANCHOR_TOP_LEFT,  
                        type: BMAP_NAVIGATION_CONTROL_LARGE  
                    });  
                    map.addControl(ctrlNav);  
  
                    //向地图中添加缩略图控件  
                    var ctrlOve = new window.BMap.OverviewMapControl({  
                        anchor: BMAP_ANCHOR_BOTTOM_RIGHT,  
                        isOpen: 1  
                    });  
                    map.addControl(ctrlOve);  
  
                    //向地图中添加比例尺控件  
                    var ctrlSca = new window.BMap.ScaleControl({  
                        anchor: BMAP_ANCHOR_BOTTOM_LEFT  
                    });  
                    map.addControl(ctrlSca);  
  
                    var point = new Array(); //存放标注点经纬信息的数组  
                    var marker = new Array(); //存放标注点对象的数组  
                    var info = new Array(); //存放提示信息窗口对象的数组  
                    for (var i = 0; i < markerArr.length; i++) {  
                        var p0 = markerArr[i].point.split(",")[0]; //  
                        var p1 = markerArr[i].point.split(",")[1]; //按照原数组的point格式将地图点坐标的经纬度分别提出来  
                        point[i] = new window.BMap.Point(p0, p1); //循环生成新的地图点
                        
                        var myIcon = "";
                        if(i<2){
                            myIcon = new BMap.Icon("img/star.png", new BMap.Size(48,48));
                            //
                        }else{
                            myIcon = new BMap.Icon("img/point.png", new BMap.Size(20,20));
                        }
                        marker[i] = new window.BMap.Marker(point[i],{icon:myIcon}); //按照地图点坐标生成标记
                        
                        var label = new window.BMap.Label(markerArr[i].title, { offset: new window.BMap.Size(20, -10) });  
                        marker[i].setLabel(label);  
                        info[i] = new window.BMap.InfoWindow("<p style=’font-size:12px;lineheight:1.8em;’>" + markerArr[i].title  + "</p>"); // 创建信息窗口对象  
                        map.addOverlay(marker[i]);
                    }
                    var point1 = [];
                    point1 = point.slice(2);
                    
                    //var polyline = new BMap.Polyline(point1, {strokeColor:"blue",//设置颜色 
                    //strokeWeight:5});//透明度
                    //map.addOverlay(polyline);
    
                    //var curve = new BMapLib.CurveLine(point1, {strokeColor:"red", strokeWeight:3}); //创建弧线对象
                    //map.addOverlay(curve); //添加到地图中
                    //curve.enableEditing(); //开启编辑功能


                    marker[0].addEventListener("click", function () {  
                        this.openInfoWindow(info[0]);  
                    });  
                    marker[1].addEventListener("click", function () {  
                        this.openInfoWindow(info[1]);  
                    });  
                    marker[2].addEventListener("click", function () {  
                        this.openInfoWindow(info[2]);  
                    });
                    marker[3].addEventListener("click", function () {  
                        this.openInfoWindow(info[3]);  
                    });
                    marker[4].addEventListener("click", function () {  
                        this.openInfoWindow(info[4]);  
                    });
                    marker[5].addEventListener("click", function () {  
                        this.openInfoWindow(info[5]);  
                    });
                    marker[6].addEventListener("click", function () {  
                        this.openInfoWindow(info[6]);  
                    });  
                }  
                //异步调用百度js  
                function map_load() {  
                    var load = document.createElement("script");  
                    load.src = "http://api.map.baidu.com/api?v=2.0&callback=map_init";  
                    document.body.appendChild(load);
                }  
                window.onload = map_load;  
            </script>


</body>
</html>