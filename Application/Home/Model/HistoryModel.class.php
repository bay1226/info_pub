<?php
namespace Home\Model;
use Think\Model;

class HistoryModel extends Model{


    function insertnewinfo($eachstock){
        $data['time']=$eachstock['timestamp'];
        $data['price']=$eachstock['price'];
        $data['stock_code']=$eachstock['code'];
        $data['stock_name']=$eachstock['name'];

        $condition['stock_code']=$eachstock['code'];
        $res=M('history')->where($condition)->order('time desc')->select();
        if(count($res))
        {
            $olddate=date("Y-m-d ", $res[0]['time']);
            $newdate= date("Y-m-d ", $data['time']);

            if($olddate==$newdate)
            {
                 $data['volume']=$res[0]['volume']-$eachstock['amount'];
            }
            else
            {
                $data['volume']=$eachstock['amount'];
            }    
        }
        else
        {
            $data['volume']=$eachstock['amount'];
        }
        
        M('history')->add($data);
        return $data;
    }
     
}