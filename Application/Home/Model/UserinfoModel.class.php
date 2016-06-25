<?php
namespace Home\Model;
use Think\Model;

class UserinfoModel extends Model{
    function getUserInfo() {
        $result = M('userinfo')->where('name="yxq"')->select();
        return $result;
    }

    function verify($username,$password) {
    	$condition['username']=$username;
    	$result = M('userinfo')->where($condition)->find();
    	if($result)
    	{
	        $psw=$result['password'];
            $salt=$result['salt'];
            $password=$this->hash($salt,$password);
	        if($psw==$password)
	        {
		        $result['info']=1;//success
		        return $result;    		
    		}
    		else
    		{
    			$result['info']=2;//pwd wrong
		        return $result;  
    		}
    	}
    	else
    	{
    		$result['info']=0;//user not exist
    		return $result;
    	}
    }
    
    function adduser($record) {
        $condition['username']=$record['username'];
        $result = M('userinfo')->where($condition)->find();
        if($result)
        {
            $result['info']=0;//username has existed
            return $result;
        }
        else
        {
            $record['salt']=$this->rand_string();
            $password=$record['password'];
            $record['password']=$this->hash($record['salt'],$password);

            M('userinfo')->add($record);
            $res = M('userinfo')->where($condition)->find();
            if($res)
            {
                $res['info']=1;//insert success
                return $res;
            }
            else
            {
                $res['info']=2;//insert fail
                return $res;
            }
        }
    }

    function upgrade($username) {
        $condition['username']=$username;
        M('userinfo')->where($condition)->setField('isvip',1);    
        $res = M('userinfo')->where($condition)->find();
        if($res['isvip'])
        {
            $res['info']=1;//upgrade success
            return $res;
        }
        else
        {
            $res['info']=2;//upgrade fail
            return $res;
        }
    }


    function changepwd($Username,$newPassword) {
        $condition['username']=$Username;
        $data['salt']=$this->rand_string();
        $data['password']=$this->hash($data['salt'],$newPassword);        
        M('userinfo')->where($condition)->save($data);    
        $res = M('userinfo')->where($condition)->find();
        if($res['password']==$data['password'])
        {
            $res['info']=1;//changepwd success
            return $res;
        }
        else
        { 
            $res['info']=2;//changepwd fail
            return $res;                  
        }
    }

        //md5加密
    function hash($s,$p) {
        $str=$s.$p;
        $str=md5($str);
        return $str;
    }

    //随机字符串
    function rand_string() {
        $str = '';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, 6);
        return $str;
    }
}