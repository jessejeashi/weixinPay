<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
//require_once 'log.php';
//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
class OrderPayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function order_info($id)
    {
        //  1 通过code获取用户openid 其中GetOpenid() 函数定义在 文件 WxPay.JsApiPay.php 文件中
        $tools = new JsApiPay();
        $openId = $tools->GetOpenid();
        Log::DEBUG("GetOpenid"+$openId);

        $results=  DB::select('select * from goods where id = :id', ['id' => $id]);

        //  2 统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($results->goods_title);
        //$input->SetAttach("test");
        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        // $input->SetTotal_fee((string)((float)($results->item_price)*100));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($results->goods_title);
        //设置接收支付结果通知的Url
        $input->SetNotify_url(WxPayConfig::NOTIFY_URL);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        // echo '<b>Order Detail</b><br/>';
        // foreach($data as $key=>$value){
        //     echo "$key : $value <br/>";
        }

        //  //获取jsApi支付的参数给变量 $jsApiParameters 方便在下面的Js中调用
        // $jsApiParameters = $tools->GetJsApiParameters($order);
        // //获取共享收货地址js函数参数
        // $editAddress = $tools->GetEditAddressParameters();

        //  3 在支持成功回调通知中处理成功之后的事宜，见 notify.php
        /**
        * 1、当回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
        * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
        * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
        */
    }
}


?>


<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>WxPay Purchase Page</title>
    <script type="text/javascript" src="../static/jsapi.js"></script>
</head>
<body>
    <br/>
    <b>该笔订单支付金额为0.01</b><br/><br/>
    <div align="center">
        <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >微信支付</button>
    </div>
</body>
</html>