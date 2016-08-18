<?php
namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
//require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PaidNotifyController extends Controller
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
    {
        Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();

        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }


        //订单存DB
        $time = time();
        if(substr($_SERVER["QUERY_STRING"],0,6)!='openid'){
            echo "wrong parameter";
        } else{
            DB::insert('insert into orders (openid, orderid, timestamp, status) values (?, ?, ?, ?)', substr($_SERVER["QUERY_STRING"],7), $data["transaction_id"], $time]);
        }

        return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PaidNotifyController();
//大部分逻辑在 Handle 函数中处理 文件 WxPay.Notify.php
$notify->Handle(false);