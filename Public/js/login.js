function Login(){
	var UserName=$("#loginname").val();
	var Password=$("#loginpsw").val();
	if(UserName==null||UserName=="")
	{
		alert("用户名不能为空！");
		return false;
	}
	if(Password==null||Password=="")
	{
		alert("密码不能为空！");
		return false;
	}
}

function GoSignUp(){
	alert("sign up!");
}

function FindPsw(){
	alert("find password!");
}