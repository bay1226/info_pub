<?php
namespace Home\Model;
use Think\Model;

class KlineModel extends Model{


    function insertnewinfo($record){
        
        M('kline')->add($record);
    }
    function updatedata($record){
        $conditon['date']=$record['time'];
        $conditon['code']=$record['code'];
        $data=M('kline')->where($conditon)->select();
        M('kline')->where($conditon)->save($data);
    }
    function drawline($stock_code)
    {
        $conditon['code']=$stock_code;
        $result=M('kline')->where($conditon)->select();
        return $result;
    }
    function search($conditon)
    {
        $res=M('kline')->where($conditon)->order('date desc')->select();

        if(count($res))
        {
            $newest=$res[0];
            if($newest['count']<6)
            {
                 return $newest;
            }
            else
            {
                return 0;
            }
           
        }
        else
        {
            return 0;
        }
    }

}

