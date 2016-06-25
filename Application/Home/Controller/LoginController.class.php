<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\UserinfoModel;

class LoginController extends Controller {
	public function login(){
		$this->display('login');
	}

	public function verify(){
		if(IS_POST)
        {
        	$Username=$_POST['username'];
        	$Password=$_POST['password'];
	        $model = new UserinfoModel();
	        $result=$model->verify($Username,$Password);
	        if($result['info']==1)
	        {
	        	$_SESSION['username'] = $result['username'];
	        	$_SESSION['isvip'] = $result['isvip'];
	        	$_SESSION['tel'] = $result['tel'];
	        	$_SESSION['mail'] = $result['mail'];
                //$this->display('Index:方法名');
	        	$this->success('登录成功！将自动跳转到主页',U('Index/index'),3);
                // $this->redirect('Index/index');
	        }
	        else if($result['info']==2)
	        {
	        	$this->error('密码不正确！',U('Login/login'),5);
	        }
	        else
	        {
	        	$this->error('没有该用户！',U('Login/login'),5);
	        }
        }
        else
        {
            $this->redirect('Login/login');
        }
	}

	public function signup(){
		$this->redirect('Signup/signup');
	}
}