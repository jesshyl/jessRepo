<?php
use Workerman\Worker;
require_once __DIR__ . '/Workerman/Autoloader.php';
date_default_timezone_set('PRC');
// 创建一个Worker监听2346端口，使用websocket协议通讯
$ws_worker = new Worker("websocket://0.0.0.0:2346");

// 启动4个进程对外提供服务
$ws_worker->count = 8;

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data)
{	
	$snum = "nothing";
	$now = date("Y-m-d H:i:s");
    // 向客户端发送hello $data
    //echo $data;
    $data1 = json_decode($data);
    if(!property_exists('data1','snum')){
    	$snum = $data1->snum;
    }
    require __DIR__.'/back/conn.php';
    $arr = array();
    $mysqli->query("set names utf8");
    $qstr = "select * from events where sensor_num ='".$snum."'";
    $where = " and rec_time > '".date("Y-m-d H:i:s",strtotime($now." - 2 minute"))."'";
    //$order_lim = " order by id desc limit 0,500";
    if(isset($data1->date1)&&($data1->date1!='')){
    	$order_lim = " order by id desc ";
    	if(isset($data1->date2)&&($data1->date2!='')){
    		$where = " and rec_time > '".$data1->date1."' and rec_time <= '".date("Y-m-d H:i:s",strtotime($data1->date2." + 1 day"))."'";
    	}else{
    		$where = " and rec_time > '".$data1->date1."'";
    	}
    }else{
    	if((isset($data1->date2)&&($data1->date2!=''))){
    		$order_lim = " order by id desc ";
    		$where = " and rec_time <= '".date("Y-m-d H:i:s",strtotime($data1->date2." + 1 day"))."'";
    	}
    }
    if(isset($data1->type)&&($data1->type!='')){
    	$search_type = $data1->type;
    	$order_lim = '';
    	switch($search_type){
    		case 'hour':
    			$where = " and rec_time > '".date("Y-m-d H:i:s",strtotime($now." - 1 hour"))."'";
    			$team_len = 'hour';
    			break;
    		case 'day':
    			$where = " and rec_time > '".date("Y-m-d H:i:s",strtotime($now." - 1 day"))."'";
    			$team_len = 'day';
    			break;
    		case 'month':
    			$where = " and rec_time > '".date("Y-m-d H:i:s",strtotime($now." - 1 month"))."'";
    			$team_len =  'month';
    			break;
    		case 'year':
    			$where = " and rec_time > '".date("Y-m-d H:i:s",strtotime($now." - 1 year"))."'";
    			$team_len =  'year';
    			break;
    		default:
    			$where = " and rec_time > '".date("Y-m-d H:i:s",strtotime($now." - 2 minute"))."'";
    			$team_len = 'minute';
    			break;
    	}
    }
    //var_dump($data1);
    echo $qstr.$where."  ";
	$getitem = $mysqli->query($qstr.$where);
	//echo $qstr.$where;
	$getitem->data_seek(0);
	$totalNum = $getitem->num_rows;
    $arr1max = array();
    $arr1min = array();
    $arr1 = array();
    $arr2 = array();
    $retarr = array();
    $i1 = 0;
    $unit = "";
    $warning = "";
    $alarm = "";
    $datetype = @$data1->type;
    $arr_len = 0;
	//数据条数缩减为720
    $period = round($totalNum/720);
    if($period == 0){
        $period = 1;
        $arr_len = $totalNum;
    }else{
        $arr_len = ceil($totalNum/$period);
    } 

    while($item = $getitem->fetch_assoc()){

        if($i1 == 0){
            $arr['unit'] = $item['unit'];
            $arr['warning'] = $item['warning'];
            $arr['alarm'] = $item['alarm']; 
            $arr['length'] = $arr_len;
        }

        //$arr1['name'] = $i1;
        $arr1['value'] = array($item['rec_time'],$item['value']);
        //$arr1['va'] = $item['value'];
        

        if($period == 1){
            array_push($arr,$arr1);
        }else{
            if(($i1==0)||($i1%$period == 0)){
                $arr1max = $arr1;
                //$arr1min = $arr1;
            }else {
            if($item['value']>$arr1max['value'][1]){
                $arr1max = $arr1;
            }else {
                //if($item['value']<=$arr1min['value'][1]){
                //    $arr1min = $arr1;
                //}
            }
            if(($i1 == $totalNum-1)||($i1%$period == ($period-1))){
                //echo $i1." , ";
                array_push($arr,$arr1max);
                //array_push($arr2,$arr1min);
                }
            } 
        }
        $i1++;
    }
    //$retarr['maxs'] = $arr;
    
    //$retarr['mins'] = $arr2;
		$connection->send(json_encode($arr));
    };

// 运行worker
Worker::runAll();
?>