<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\UserinfoModel;
use Home\Model\Stock_infoModel;
use Home\Model\KlineModel;
use Home\Model\HistoryModel;

class IndexController extends Controller {
    /*主页，包括用户要操作的所有功能*/
    public function index(){
        if(isset($_SESSION['username']))
        {
            $this->assign('isvip',$_SESSION['isvip']);
            $this->assign('username',$_SESSION['username']);
            $this->assign('tel',$_SESSION['tel']);
            $this->assign('mail',$_SESSION['mail']);
            $this->display('index');
        }
        else
        {
            $this->redirect('Login/login');
        }
    }

    /*查询股票基本信息*/
    public function baseinfo(){
        if(IS_POST)
        {
            $stock=$_POST['stock'];
            //$Password=$_POST['password'];
            $model = new Stock_infoModel();
            $result=$model->baseinfo($stock);
            $this->ajaxReturn($result,'JSON');
            /*if($result)
            {
                //$result['re']=true;
                $this->ajaxReturn($result,'JSON');
            }
            else
            {
                //$this->error('不存在满足条件的股票！',U('Index/baseinfo'),5);
                //$result['re']=false;
                //$result['msg']='不存在满足条件的股票！';
            }*/
        }
        else
        {
            $this->redirect('Index/index');
        }
    }
    function isvip(){
        $result['info']=$_SESSION['isvip'];
        if($_SESSION['isvip']!=1)
            $result['msg']='you are not a vip';
        else
            $result['msg']='success';
        $this->ajaxReturn($result,'JSON');
    }

    /*升级账户*/
    public function upgrade(){
        if(IS_POST)
        {
            $Username=$_SESSION['username'];
            //$Password=$_POST['password'];
            $model = new UserinfoModel();
            $result=$model->upgrade($Username);
            if($result['info']==1)
            {
                $_SESSION['isvip'] = $result['isvip'];
                //$this->success('升级成功！将自动跳转到主页',U('Index/index'),5);
                $result['msg']='升级成功！将自动跳转到主页';
            }
            else
            {
                //$this->error('数据库更新用户升级数据失败！',U('Index/upgrade'),5);
                $result['msg']='数据库更新用户升级数据失败！';
            }
            $this->ajaxReturn($result,'JSON');
        }
        else
        {
            $this->redirect('Index/index');
        }

    }


    /*修改密码*/
    public function changepwd(){
        if(IS_POST)
        {
            $Username=$_SESSION['username'];
            $oldPassword=$_POST['oldpassword'];
            $newPassword=$_POST['newpassword'];
            $model = new UserinfoModel();
            $result=$model->verify($Username,$oldPassword);
            if($result['info']==2)
            {
                $result['msg']='原密码错误！';
            }
            else
            {
                $res=$model->changepwd($Username,$newPassword);
                if($res['info']==1)
                {
                    //$this->success('修改密码成功！将自动跳转到主页',U('Index/index'),5);
                    $result['msg']='修改密码成功！将自动跳转到主页';
                }
                else
                {
                    //$this->error('数据库更新密码失败！',U('Index/changepwd'),5);
                    $result['msg']='数据库更新密码失败！';
                }
            }
            $this->ajaxReturn($result,'JSON');
        }
        else
        {
            $this->redirect('Index/index');
        }
    }

    public function logout(){
        if(IS_POST)
        {
            $_SESSION = array();
            $this->redirect('Login/login');
        }
        else
        {
            $this->redirect('Login/login');
        }
    }

    public function note(){
        if(IS_POST)
        {
            //update_allstock_data();
            
            $model = new Stock_infoModel();
            $result=$model->note();
            
            //if($result)
            //{
                $this->ajaxReturn($result,'JSON');
            //}
            //else
            //{
                //$this->error('数据库更新用户升级数据失败！',U('Index/upgrade'),5);                
               // $result['msg']='数据库查找公告失败！';
            //}
        }
        else
        {
            $this->redirect('Index/index');
        }

    }

    //画Kline
    public function drawKline(){
        $model = new KlineModel();
        $code=$_POST['stock_code'];
        $result=$model->drawline($code);
        $this->ajaxReturn($result,'JSON');
    } 

 
    //请求数据
    private function send_post($url, $post_data) {
        $postdata = http_build_query($post_data);
        $options = array('http' => array(
            'method' => 'POST',
            //'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60) 
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
    function curlPost($url, $data = array(), $timeout = 30, $CA = true){    

    $cacert = getcwd() . '/cacert.pem'; //CA根证书  
    $SSL = substr($url, 0, 8) == "https://" ? true : false;  

    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);  
    if ($SSL && $CA) {  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书  
        curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配  
    } else if ($SSL && !$CA) {  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书  
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名  
    }  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题  
    curl_setopt($ch, CURLOPT_POST, true);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
    //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); //data with URLEncode  

    $ret = curl_exec($ch);  
    //var_dump(curl_error($ch));  //查看报错信息  

    curl_close($ch);  
    return $ret;    
    }    

   
    //更新所有股票信息
    public function update_allstock_data(){
        $model = new Stock_infoModel();
        //update stock
        $post_data = array();
        $timeout=60;
        $result=$this->curlPost('https://se.clarkok.com/center/stock/all', $post_data,$timeout,false);
        $result= json_decode($result,true);
        $state['state']=$result['state'];   
        // $result['stocks'] = array( 0=>array( 'code'=>'A01XX', 'name'=>'stock01' , 'price' =>12.32, 'lowest_price' =>10.2, 'highest_price' => 13.23, 'amount' => 4200, 'last_price' => 12.43, 'closing_price' => 12.24, 'opening_price' => 12.44) ,
        //                           1=>array( 'code'=>'AXX02', 'name'=>'stock0111' , 'price' =>12.32, 'lowest_price' =>10.2, 'highest_price' => 13.23, 'amount' => 4200, 'last_price' => 12.43, 'closing_price' => 12.24, 'opening_price' => 12.44) ,
        //                           2=>array( 'code'=>'003', 'name'=>'stock01111' , 'price' =>12.32, 'lowest_price' =>10.2, 'highest_price' => 13.23, 'amount' => 4200, 'last_price' => 12.43, 'closing_price' => 12.24, 'opening_price' => 12.44), 
        //                       );
        // do{
        //     $result=$this->send_post('/center/stock/all', $post_data);
        // }while ($result['state']=='error');
        //$model->clear_all();
        $stocks=$result['stocks'];
        foreach ($stocks as $eachstock) {
            $model->updateinfo($eachstock);
        }

        //更新股票状态
        $result1=$this->curlPost('https://se.clarkok.com/center/stock/closed', $post_data,$timeout,false);
        $result1= json_decode($result1,true);
        $stocks1=$result1['stock'];
        //$model->resetstate();
        foreach ($stocks1 as $eachstock) {
            $model->updatestate($eachstock['code'],$eachstock['state']);
        }
        $this->ajaxReturn($result,'JSON');
        // //Kline
        // $model1 = new KlineModel();
        // foreach ($stocks as $eachstock) {
        //     $this->updateKline($eachstock);
        // }        
        // //update state
        // $post_data = null ;
        // do{
        //     $result=$this->send_post('/center/stock/closed', $post_data);
        // }while ($result['state']=='error');
        // $stocks=$result['stock'];
        // //$model->resetstate();
        // foreach ($stocks as $eachstock) {
        //     $model->updatestate($eachstock['code'],$eachstock['state']);
        // }
    }
    //更新Kline信息
    function updateKline($result)
    {
        $kmodel=new KlineModel();
        $hmodel=new HistoryModel();

        $data=$hmodel->insertnewinfo($result);
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

}
