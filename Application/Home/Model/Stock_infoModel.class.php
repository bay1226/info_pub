<?php
namespace Home\Model;
use Think\Model;

class Stock_infoModel extends Model{
    // function getUserInfo() {
    //     $result = M('userinfo')->where('name="yxq"')->select();
    //     return $result;
    // }
	// function baseinfocode($stock_code){
 //    	$condition['stock_code']=$stock_code;
 //    	$result = M('stock_info')->where($condition)->find();
 //    	if($result)
 //    	{
 //    		$result['info']=1;//success	  
 //    		return $result;      
 //    	}
 //    	else
 //    	{
 //    		$result['info']=0;//stock_code not exist
 //    		return $result;
 //    	}
	// }

	function baseinfo($stock){
    	$condition['stock_name']=array('LIKE', array($stock,'%'+$stock+'%','%'+$stock,$stock+'%'),'OR');
        $stock1='%'.$stock.'%';
        $stock2=$stock.'%';
        $stock3='%'.$stock;
        $condition['stock_name']=array('like', array($stock1,$stock2,$stock3,$stock),'OR');
        //$condition['stock_name']=$stock;
    	$condition['stock_code']=$stock;
    	$condition['_logic'] = 'OR';
    	 $result = M('stock_info')->where($condition)->select();
    	return $result;
	}

    function note() {
        $result = M('stock_info')->where('state=1 OR state=-1')->field('stock_name,state')->select();
        return $result;
    }



    // function resetstate() {
    //     $result = M('stock_info')->setField('state',0);
    //     //return $result;
    // }

    function updatestate($stock_code,$state) {
        $condition['stock_code']=$stock_code;
        if($state=='surging')
            $state=1;
        else
            $state=-1;
        $result = M('stock_info')->where($condition)->setField('state',$state);
        //return $result;
    }

    // function updateinfo($eachstock){
    //     $condition['stock_code']=$eachstock['code'];
    //     $indecrease=($eachstock['price']-$eachstock['open'])/$eachstock['open'];
    //     $total_price=$eachstock['amount']*$eachstock['price'];
    //     $data = array('open'=>$eachstock['open'],'close'=>$eachstock['close'],'indecrease'=>$indecrease,'total_price'=>$total_price,'totalnum'=>$eachstock['amount'],'max'=>$eachstock['highest_price'],'min'=>$eachstock['lowest_price'],'price'=>$eachstock['price']);
    //     M('stock_info')->where($condition)->setField($data);
    // }
    function clear_all() {
        M('stock_info')->where('1')->delete(); 
        //return $result;
    }

     function updateinfo($eachstock){
        $indecrease= ($eachstock['price']-$eachstock['opening_price'])/$eachstock['opening_price'];
        $total_price=$eachstock['amount']*$eachstock['price']; 
        $condition['stock_code']=$eachstock['code'];

        $record['stock_code']=$eachstock['code'];
       // $record['stock_name']=$eachstock['name'];
        $record['open']=$eachstock['opening_price'];
        $record['close']=$eachstock['closing_price'];
        $record['pause']=$eachstock['pause'];
        $record['indecrease']=$indecrease;
        $record['total_price']=$total_price;
        $record['total_num']=$eachstock['amount'];
        $record['max']=$eachstock['highest_price'];
        $record['min']=$eachstock['lowest_price'];
        $record['price']=$eachstock['price'];
        M('stock_info')->where($condition)->save($record);
    }   
}