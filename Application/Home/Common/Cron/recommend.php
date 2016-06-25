<?php
namespace Home\Common;
//use Think\Controller;
use Home\Model\UserinfoModel;
use Home\Model\Stock_infoModel;
use Home\Model\KlineModel;
use Home\Model\HistoryModel;


	//请求数据
    function send_post($url, $data){//file_get_content
        $postdata = http_build_query(
            $data
        );        
        $opts = array('http' =>
                      array(
                          'method'  => 'POST',
                          'header'  => 'Content-type: application/x-www-form-urlencoded',
                          'content' => $postdata
                      )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }


    //更新Kline信息
    function updateKline($result)
    {
        $kmodel=new KlineModel();
        $hmodel=new HistoryModel();

        $data=hmodel->insertnewinfo($result);
        $conditon['code']=$data['stock_code'];
        
        $res=$kmodel->search($conditon);
        if($res==0)
        {
            $newdata['code']=$data['stock_code'];
            $newdata['date']=$data['time'];
            $newdata['open']=$data['price'];
            $newdata['high']=$data['price'];
            $newdata['close']=$data['price'];
            $newdata['low']=$data['price'];
            $newdata['volume']=$data['volume'];
            $newdata['count']=1;
            $kmodel->add($newdata);
        }
        else
        {
            $updata['date']=$res['date'];
            $updata['open']=$res['open'];
            $updata['volume']=$res['volume']+$data['volume'];
            $updata['count']=$res['count']+1;
            $updata['code']=$data['stock_code'];
            $updata['close']=$data['price'];

            if($res['high']<$data['price'])
            {
                $updata['high']=$data['price'];
            }
            if($res['low']>$data['price'])
            {
                $updata['low']=$data['price'];
            }
            $kmodel->updatedata($updata);
        }
    }

    //更新所有股票信息
        $model = new Stock_infoModel();
        //update stock
        $post_data = null;
        do{
            $result=send_post('/center/stock/all', $post_data);
        }while ($result['state']=='error');
        $model->clear_all();
        $stocks=$result['stock'];
        foreach ($stocks as $eachstock) {
            $model->updateinfo($eachstock);
        }
        //Kline
        foreach ($stocks as $eachstock) {
            updateKline($eachstock);
        }        
        //update state
        $post_data = null ;
        do{
            $result=send_post('/center/stock/closed', $post_data);
        }while ($result['state']=='error');
        $stocks=$result['stock'];
        //$model->resetstate();
        foreach ($stocks as $eachstock) {
            $model->updatestate($eachstock['code'],$eachstock['state']);
        }

