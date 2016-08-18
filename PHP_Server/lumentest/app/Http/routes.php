<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen      the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

define('ROUTE_BASE','lumentest/lumenproject/public');

$app->get(ROUTE_BASE . '/', function () use ($app) {
    return $app->welcome();
});

$app->get(ROUTE_BASE . '/jsapi{id}', 'OrderPayController@order_info');

$app->get(ROUTE_BASE . '/getgoods{id}', 'GetGoodsController@goods_info');

$app->get(ROUTE_BASE . '/notify', 'PaidNotifyController@NotifyProcess');