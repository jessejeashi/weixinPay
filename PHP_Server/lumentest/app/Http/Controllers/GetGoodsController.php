<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Controllers\Controller;


class GetGoodsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function goods_info($id)
    {
        //

        if( isset($id) && !empty($id) ){
            $list=array("status"=>"ERROR","msg"=>"wrong parameter");
            echo json_encode($list);
        } elseif (!is_numeric($id)){
            $list=array("status"=>"ERROR","msg"=>"wrong parameter");
            echo json_encode($list);
        } else{
            // 从表中提取信息的sql语句 
            $results=  DB::select('select * from goods where id = :id', ['id' => $id]);
            //执行sql查询
            //mysql_select_db($mysql_database,$conn);
            //$result=mysql_query($sql);
            //$result=mysql_db_query($mysql_database, $strsql, $conn); 
            // 获取查询结果 
            // 定位到第一条记录 
            //mysql_data_seek($result, 0); 
            // 循环取出记录 
            $list=array("status"=>"OK","id"=>$results->id,"banner_pic"=>$results->banner_pic,"item_logo"=>$results->item_logo,"bottom_pic"=>$results->bottom_pic,"item_des"=>$results->item_des,"currency"=>$results->currency,"item_price"=>$results->item_price,"goods_title"=>$results->goods_title,"goods_detail"=>$results->goods_detail,"bottom_left"=>$results->bottom_left,"bottom_right"=>$results->bottom_right);
            echo json_encode($list);
        } 
    }
}


?>