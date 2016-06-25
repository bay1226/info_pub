function SignUp(){
	var UserName=$("#regname").val();
	var Tel=$("#regtel").val();
	var Password=$("#regpsw").val();
	var RePassword=$("#regrepsw").val();;
	var Email=$("#regemail").val();
	if(UserName.length>=20||Password.length>=20||Tel.length>=20||Email.length>=50)
	{
		alert("用户名，密码和电话号码长度长度要小于20个字符，注册邮箱的长度要小于50");
		return false;
	}
	if(UserName==null||UserName=="")
	{
		alert("用户名不能为空！");
		return false;
	}
	if(Tel==null||Tel=="")
	{
		alert("电话不能为空！");
		return false;
	}
	if(Email==null||Email=="")
	{
		alert("邮箱不能为空！");
		return false;
	}
	if(Password==null||Password=="")
	{
		alert("密码不能为空！");
		return false;
	}
	var e=Email.indexOf("@");
	var d=Email.lastIndexOf(".");
	if (e<1||d-e<2)
	{
		alert("非法邮箱！");
		return false;
	}
	if(RePassword!=Password)
	{
		alert("两次输入密码不同！");
		return false;
	}
	var reg = /^[0-9a-zA-Z]*$/g;
	if(!reg.test(Password))
	{
		alert("密码必须是字母和数字！");
		return false;
	}
	reg = /^[0-9]*$/g;
	if(!reg.test(Tel))
	{
		alert("电话必须是数字！");
		return false;
	}
	return true;
}

function GoLogin(){
	alert("go login!");
}