<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\UserinfoModel;

class SignupController extends Controller {
	public function signup(){
		$this->display('signup');
	}

	public function regist(){
		if(IS_POST)
        {
        	$record['username']=$_POST['username'];
        	$record['mail']=$_POST['mail'];
        	$record['tel']=$_POST['tel'];        	
        	$record['password']=$_POST['password'];
        	$record['isvip']=0;
	        $model = new UserinfoModel();
	        $result=$model->adduser($record);
	        //echo $result['info'];
	        if($result['info']==1)
	        {
	        	$_SESSION['username'] = $record['username'];
	        	$_SESSION['isvip'] = $record['isvip'];
	        	$this->success('注册成功！将自动跳转到主页',U('Index/index'),5);
	        }
	        else if($result['info']==0)
	        {
	        	//echo $result['mail'];
	        	$this->error('用户名已经存在!',U('Signup/signup'),5);
	        }
	        else
	        {
	        	$this->error('插入数据错误!',U('Signup/signup'),5);
	        }
        }
        else
        {
            $this->redirect('Signup/signup');
        }
	}

	public function login(){
		$this->redirect('Login/login');
	}
}