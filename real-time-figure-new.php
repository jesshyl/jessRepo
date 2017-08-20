﻿<?php
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

$ssnum = '';
$mysqli->set_charset('utf8');
$sensor_unit='';
$sensor_warning='';
$sensor_alarm='';
if(isset($_GET['sensor_num'])&&$_GET['sensor_num']!=''){
  $ssnum =  GetSQLValueString($_GET['sensor_num'],"text");
  $qstring = "select * from sensors where sensor_num = ".$ssnum;
  $sensorResult = $mysqli->query($qstring);
  $sensor = $sensorResult->fetch_assoc();
  $sensor_n = $sensor['sensor_num'];
  $sensor_unit = $sensor['unit'];
  $sensor_warning = $sensor['warning'];
  $sensor_alarm = $sensor['alarm'];
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
<link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>实时数据</title>
</head>
<body style="margin: 0px">
<!--<div id= 'sensor' name='sensor' style="width:20%;height:30px;text-align:left;padding-left:30px;float: left;"></div>-->
<div class="container">
  <div class="row">
    <div class = "col-sm-7">
      <div id= 'figure' name='figure' style="height:300px;margin-left:-25px"></div>
    </div>
    <div class = "col-sm-5" style="padding-top:25px ">
      <div id= 'sensor_info' name='sensor_info' style="height:300px;width: 100%">
        <table class="table table-border table-bordered table-bg" id="table1" name="table1" style=" border-collapse:collapse;">
          <thead>
            <tr><th colspan="6">传感器信息</th></tr>
          </thead>
          <tbody>
            <tr><td class="active" width="100px">传感器号</td><td width="200px"><?php echo @$sensor['sensor_num']?></td><td class="active" width="100px">断面里程</td><td width="200px"><?php echo @$sensor['section_mileage']?></td><td class="active" width="100px">检测量说明</td><td width="200px"><?php echo @$sensor['detection']?></td></tr>
            <tr><td class="active">管片号</td><td><?php echo @$sensor['segment_num']?></td><td class="active">监测对象</td><td><?php echo @$sensor['obj']?></td><td class="active">物理量</td><td><?php echo @$sensor['quantity']?></td></tr>   
            <tr><td class="active">量测方向</td><td><?php echo @$sensor['direction']?></td><td class="active">单位</td><td><?php echo @$sensor['unit']?></td><td class="active">传感器状态</td><td><?php echo @$sensor['status']?></td></tr>
            <tr><td class="active">预警值</td><td><?php echo sprintf("%.3f", @$sensor['warning'])?></td><td class="active">报警值</td><td><?php echo sprintf("%.3f", @$sensor['alarm'])?></td><td colspan="2"></td></tr>      
          </tbody>
        </table>  
    </div>
    </div>
  </div>
</div>



<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="lib/echarts.js"></script>  
<script type="text/javascript" src="lib/macarons.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script> 
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">

var ws = new WebSocket("ws://127.0.0.1:2346");
var fig = document.getElementById("figure");
var myChart = echarts.init(fig,'macarons');
option = null;
var data = [];
var connect_time = 0;
var sn=<?php echo ($ssnum!=''?$ssnum:0);?>;
$(function(){
	window.onresize = myChart.resize;
	option = {
    title: {
        text: '实时数据',
        left:'30',
        show:false
    },
    tooltip: {
        trigger: 'axis',
        formatter: function (params) {
            params = params[0];
            var date = new Date(params.value[0]);
            return (date.getMonth()+1)+"月"+date.getDate()+"日"+" "+date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + '<br> 值为 : ' + params.value[1];
        },
        axisPointer: {
            animation: false
      }
    },
    xAxis: {
        name:'时间',
        type: 'time',
        axisLabel:{
        interval: 2
        },
        splitLine: {
            show: false
        },
        boundaryGap : false
    },
    yAxis: {

        type: 'value',
        boundaryGap: [0, '100%'],
        splitLine: {
            show: false
        },
        name:'当前值'
    },
    grid:{
      left:'30',
    },
    series: [{
        name: '实时数据',
        type: 'line',
        showSymbol: false,
        hoverAnimation: false,
        data: data
    }]
};

myChart.setOption(option, true);

if(sn!=0){
  //console.log(sn);
  myChart.setOption({
          title:{
            text:sn
          },
          yAxis: {
                   name:'单位( '+"<?php echo $sensor_unit?>"+" )"
                   },
          series: [{
                  markLine : {
                    data: [{
                             name: '警报',
                             value: '警报值',
                             yAxis: "<?php echo $sensor_warning?>",
                             itemStyle:{normal:{color:'#FFB90F',label:{position:'top'}}}
                          },{
                             name: '报警',
                             value: '报警值',
                             yAxis: "<?php echo $sensor_alarm?>",
                             itemStyle:{normal:{color:'#FF0000',label:{position:'top'}}}
                                          
                          }]
                        }
                    }]
      });
}

ws.onopen = function() {
    console.log("connected");
    if(sn!=0){
      showmsg();
    }
};

ws.onmessage = function(e) {
    //console.log(e.data);
    connect_time++;
    var resultjson = JSON.parse(e.data);
    var objl = resultjson.length;
    if(objl>0){
      for(var i =objl-1;i>=0;i--){
            data.push(resultjson[i]);
          }
    }
          
          myChart.setOption({
                  series: [{
                        data: data
                    }]
                });
          //console.log(data);
          data = [];
};

ws.onerror = function(){
	layer.alert('<font style="weight:bold">未开启websocket服务！</font>',{offset:'50px'});
}


});

function showmsg(){
  var obj = {snum:sn}; 
  ws.send(JSON.stringify(obj));
  setTimeout("showmsg()",2000);
}

function sensor_show(title,url,id,w,h){
	layer_show(title,url,w,h);
}

</script>
</body>
</html>
<?php $mysqli->close();?>