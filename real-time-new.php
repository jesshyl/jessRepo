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

$get1str = "select * from sensors where section_mileage like '%JC1%'";
$get1result = $mysqli->query($get1str);
$get2str = "select * from sensors where section_mileage like '%JC2%'";
$get2result = $mysqli->query($get2str);
$get3str = "select * from sensors where section_mileage like '%JC3%'";
$get3result = $mysqli->query($get3str);
$get4str = "select * from sensors where section_mileage like '%JC4%'";
$get4result = $mysqli->query($get4str);
$get5str = "select * from sensors where section_mileage like '%JC5%'";
$get5result = $mysqli->query($get5str);
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
<link rel="stylesheet" type="text/css" href="css/buttonshow.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/style.css" />
<link rel="stylesheet" href="lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<link href="http://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!--[if IE 6]>
<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>实时显示</title>
<style>
a:hover,a:focus{
		    outline: none;
		    text-decoration: none;
		}
		.tab .nav-tabs{
		    border-bottom: none;
		    position: relative;
		}
		.tab .nav-tabs li{
		    margin-right: 5px;
		    z-index: 1;
		}
		.tab .nav-tabs li:after{
		    content: "";
		    width: 100%;
		    position: absolute;
		    top: 50%;
		    right: -60%;
		    z-index: -1;
		}
		.tab .nav-tabs li:last-child:after{
		    border: none;
		}
		.tab .nav-tabs li a{
		    display: block;
		    padding: 10px 12px;
		    background: #fff;
		    font-size: 12px;
		    font-weight: 600;
		    color: #6495ED;
		    text-transform: uppercase;
		    border-radius: 0;
		    margin-right: 0;
		    border: 1px solid #6495ED;
		    position: relative;
		    overflow: hidden;
		    z-index: 1;
		    transition: all 0.3s ease 0s;
		    margin-top:2px;
		}
		.tab .nav-tabs li.active a,
		.tab .nav-tabs li a:hover{
		    color: #fff;
		    border: 1px solid #6495ED;
		}
		.tab .nav-tabs li a:after{
		    content: "";
		    display: block;
		    width: 100%;
		    height: 0;
		    position: absolute;
		    top: 0;
		    left: 0;
		    z-index: -1;
		    transition: all 0.3s ease 0s;
		}
		.tab .nav-tabs li.active a:after,
		.tab .nav-tabs li a:hover:after{
		    height: 100%;
		    background: #6495ED;
		}
		.tab .tab-content{
		    padding: 10px 0px;
		    margin-top: 0;
		    font-size: 14px;
		    color: #999;
		    line-height: 26px;
		}
		.tab .tab-content h3{
		    font-size: 24px;
		    margin-top: 0;
		}
		.tab .nav-tabs li{ 
			margin: 0 0 0 0; 
		}
		
		@media only screen and (max-width: 479px){
		    .tab .nav-tabs li{
		        width: 100%;
		        text-align: center;
		        margin: 0 0 10px 0;
		    }
		    .tab .nav-tabs li:after{
		        width: 0;
		        height: 100%;
		        top: auto;
		        bottom: -60%;
		        right: 30%;
		    }
		}
		.tab-content{
			background: #fff;
		}
		.tabs{
			background: #fff;
		}
</style>
</head>
<body>
<nav class="breadcrumb" style="padding: 0px 20px"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 实时数据 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<table class="table" style="height:100%">
	<tr>
		<!--<td width="100%" class="va-t"><ul id="treeDemo" class="ztree"></ul></td>-->
		<td width="100%" class="va-t" height="120px" style="border: 0px;padding: 0px;margin:0px">
		<div class="container">
		            <div class="row">
		                <div col-sm-12">
		                    <div class="tab" role="tabpanel">
		                        <!-- Nav tabs -->
		                        <ul class="nav nav-tabs" role="tablist">
		                            <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">JC 1</a></li>
		                            <li role="presentation"><a href="#Section2" aria-controls="Section2" role="tab" data-toggle="tab">JC 2</a></li>
		                            <li role="presentation"><a href="#Section3" aria-controls="Section3" role="tab" data-toggle="tab">JC 3</a></li>
		                            <li role="presentation"><a href="#Section4" aria-controls="Section4" role="tab" data-toggle="tab">JC 4</a></li>
		                            <li role="presentation"><a href="#Section5" aria-controls="Section5" role="tab" data-toggle="tab">JC 5</a></li>
		                        </ul>
		                        <!-- Tab panes -->
		                        <div class="tab-content tabs">
		                            <div role="tabpanel" class="tab-pane fade in active" id="Section1" style="background-color: #fff">
		                                <div id="wrapper" align="left">
											<div id="wrapper-inner">
												<div class="wrapper-inner-tab">
												<?php $_sensor = $get1result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_11'><?php echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get1result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-second"><div class="sim-button button28"><span id='_12'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get1result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-third"><div class="sim-button button28"><span id='_13'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get1result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-forth"><div class="sim-button button28"><span id='_14'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get1result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-fifth"><div class="sim-button button28"><span id='_15'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get1result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_16'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div><?php }?>
													
												</div>
											</div><!--wrapper-inner-->
										</div><!--wrapper-->
		                            </div>
		                            <div role="tabpanel" class="tab-pane fade" id="Section2">
		                                <div id="wrapper">
											<div id="wrapper-inner">
												
												<div class="wrapper-inner-tab">
												<?php $_sensor = $get2result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_21'><?php echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get2result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-second"><div class="sim-button button28"><span id='_22'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get2result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-third"><div class="sim-button button28"><span id='_23'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get2result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-forth"><div class="sim-button button28"><span id='_24'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get2result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-fifth"><div class="sim-button button28"><span id='_25'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get2result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_26'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div><?php }?>
													
												</div>
											</div><!--wrapper-inner-->
										</div><!--wrapper-->
		                            </div>
		                            <div role="tabpanel" class="tab-pane fade" id="Section3">
		                                <div id="wrapper">
											<div id="wrapper-inner">
												<div class="wrapper-inner-tab">
												<?php $_sensor = $get3result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_31'><?php echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get3result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-second"><div class="sim-button button28"><span id='_32'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get3result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-third"><div class="sim-button button28"><span id='_33'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get3result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-forth"><div class="sim-button button28"><span id='_34'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get3result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-fifth"><div class="sim-button button28"><span id='_35'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get3result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_36'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div><?php }?>
													
												</div>
											</div><!--wrapper-inner-->
										</div><!--wrapper-->
		                            </div>
		                            <div role="tabpanel" class="tab-pane fade" id="Section4">
		                                <div id="wrapper">
											<div id="wrapper-inner">
												
												<div class="wrapper-inner-tab">
												<?php $_sensor = $get4result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_41'><?php echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get4result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-second"><div class="sim-button button28"><span id='_42'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get4result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-third"><div class="sim-button button28"><span id='_43'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get4result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-forth"><div class="sim-button button28"><span id='_44'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get4result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-fifth"><div class="sim-button button28"><span id='_45'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get4result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_46'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div><?php }?>
													
												</div>
											</div><!--wrapper-inner-->
										</div><!--wrapper-->
		                            </div>
		                            <div role="tabpanel" class="tab-pane fade" id="Section5">
		                                <div id="wrapper">
											<div id="wrapper-inner">
												
												<div class="wrapper-inner-tab">
												<?php $_sensor = $get5result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_51'><?php echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get5result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-second"><div class="sim-button button28"><span id='_52'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get5result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-third"><div class="sim-button button28"><span id='_53'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get5result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-forth"><div class="sim-button button28"><span id='_54'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get5result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-fifth"><div class="sim-button button28"><span id='_55'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div>
												<?php } $_sensor = $get5result->fetch_assoc();if($_sensor){?>
													<div class="wrapper-inner-tab-backgrounds-first"><div class="sim-button button28"><span id='_56'><?php if($_sensor) echo $_sensor['sensor_num']?></span></div></div><?php }?>
													
												</div>
											</div><!--wrapper-inner-->
										</div><!--wrapper-->
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
	</div>
	</td>
	</tr>
	<tr>
		<td class="va-t" style="border:0px;width: 100%;margin:0px;padding:0px"><iframe ID="testIframe" Name="testIframe" FRAMEBORDER=0 SCROLLING=AUTO width=100% height=350px src="real-time-figure-new.php"></iframe></td>
	</tr>
</table>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')</script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<!--<script type="text/javascript" src="lib/zTree/v3/js/jquery.ztree.all-3.5.min.js"></script>--> 
<script type="text/javascript">
	
$(function(){
	
	$(".button28").click(function(){
		$(".button28:first-child").parent().css('border-width','0px');
		$(this).parent().css({'border-color':'#FFEA00','border-width':'2px','border-style':'solid'});
		console.log()
		var name = this.childNodes[0];
		var ssn = $(name).text();
		var Iframe = $("#testIframe");
		Iframe.attr("src","real-time-figure-new.php?sensor_num="+encodeURIComponent(ssn));
	});
	
	
});
</script>
</body>
</html>
<?php $mysqli->close();?>