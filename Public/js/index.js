$(function(){
    $("#publish").show();
    $("#rank").hide();
    $("#changepsw").hide();
    $("#update").hide();
    $("#help").hide();
    $("#search").hide();
})

$("a#menu-publish").click(function() {
    //alert("aah!");
    $("#rank").hide();
    $("#changepsw").hide();
    $("#update").hide();
    $("#help").hide();
    $("#search").hide();
    $("#publish").show();
})

$("a#menu-search").click(function() {
    //alert("aah!");
    $("#publish").hide();
    $("#rank").hide();
    $("#changepsw").hide();
    $("#update").hide();
    $("#help").hide();
    $("#search").show();
})

$("a#menu-changepsw").click(function() {
    //alert("changepsw!");
    $("#publish").hide();
    $("#search").hide();
    $("#rank").hide();
    $("#update").hide();
    $("#help").hide();
    $("#changepsw").show();
})

$("a#menu-update").click(function() {
    $("#publish").hide();
    $("#search").hide();
    $("#rank").hide();
    $("#changepsw").hide();
    $("#help").hide();
    $("#update").show();
    //alert("update!");
})

$("a#menu-help").click(function() {
    //alert("aah!");
    $("#publish").hide();
    $("#rank").hide();
    $("#changepsw").hide();
    $("#update").hide();
    $("#search").hide();
    $("#help").show();
})

$("a#menu-logout").click(function() {
    //alert("logout!");
    $.post("../Index/logout");
    location.href = "../Login/login.html";
})


$("button#search-bt").click(function() {
    var Stock=$("#search-in").val();
    $.post("../Index/baseinfo",{stock:Stock}, function (result){
        console.log(result);
        if(result.length==0)
            alert('不存在满足条件的股票！');
        else
        {
            //alert(result[0]['stock_name']);
            var StockInfo=$("#search-res");
            //StockInfo.html(result[0]['stock_name']+" "+result[0]['stock_code']+" "+result[0]['open']+" "+result[0]['close']+" "+result[0]['indecrease']+" "+result[0]['total_price']+" "+result[0]['total_num']+" "+result[0]['max']+" "+result[0]['min']+" "+result[0]['price']+'<br/>');
            //for(var i=1;i<result.length;i++)
            //    StockInfo.append(result[i]['stock_name']+" "+result[i]['stock_code']+" "+result[i]['open']+" "+result[i]['close']+" "+result[i]['indecrease']+" "+result[i]['total_price']+" "+result[i]['total_num']+" "+result[i]['max']+" "+result[i]['min']+" "+result[i]['price']+'<br/>');
        
            $("#search-res-table").empty(); //清空列表
            //加载列表
            for (var i = 0; i < result.length; i++) {
                var tr = "<tr>";
                tr += "<td>" + result[i]['stock_code'] + "</td>";
                tr += "<td>" + result[i]['stock_name'] + "</td>"
                tr += "<td>" + result[i]['open'] + "</td>";
                tr += "<td>" + result[i]['close'] + "</td>";
                tr += "<td>" + result[i]['indecrease'] + "</td>";
                tr += "<td>" + result[i]['total_price'] + "</td>";
                tr += "<td>" + result[i]['total_num'] + "</td>";
                tr += "<td>" + result[i]['max'] + "</td>";
                tr += "<td>" + result[i]['min'] + "</td>";
                tr += "<td>" + result[i]['price'] + "</td>";
                tr += "<td><button class='btn btn-sm btn-link K-gragh-bt' onclick='showKgraph(this)' value='"
                tr += result[i]['stock_code']+"'>查看K线图</button></td>"
                tr += "</tr>";
                $("#search-res-table").append($(tr));
            } //end for employs
        }

        $(function() {
            var $tb = $("#stocktable");
            var $bln = true;
            var $type = "numeric";
            //遍历table标题中的a元素
            $(".table thead tr th").each(function(i) {
                $(this).bind("click", function() {
                    if(i==10)
                        return;
                    $bln = $bln ? false : true;
                    if(i==0||i==1)
                        $type="ascii";
                    else
                        $type="numeric";
                    $tb.sortTable({
                        onCol: i + 1,
                        keepRelationships: true,
                        sortDesc: $bln,
                        sortType: $type
                    });
                });
            });
        });
        
    });
})

function getnote() {
    $.post("../Index/note", function (result){
        $('#note').empty();
        for (var i = 0; i < result.length; i++) {
                var info=result[i]["stock_name"];
                if(result[i]['state']==-1)
                    info += '  decrease\n';
                else
                    info += '  increase\n';
                $('#note').append(info);
            } //end for employs
    });
}

function showKgraph(obj) {
     $.post("../Index/isvip", function (result){
        console.log(result);
        if(result['info']==1)
        {
            var code=obj.value;
            $("#myModalLabel").text(code);
            $("svg").remove();
            drawK(code);
            $('#myModal').modal('show');
        }
        else
            alert(result['msg']);
          
           
       })
    
}

$("button#changepsw-bt").click(function() {
    var pwd_o=$("#changepsw-old").val();
    var pwd_n=$("#changepsw-new").val();
    var pwd_r=$("#changepsw-re").val();
    if(pwd_n!=pwd_r)
    {
        alert("输入的两次密码不一致");
        return false;
    }
    if(pwd_n==null||pwd_n=="")
    {
        alert("密码不能为空！");
        return false;
    }
    var reg = /^[0-9a-zA-Z]*$/g;
    if(!reg.test(pwd_n))
    {
        alert("密码必须是字母和数字！");
        return false;
    }
    if(pwd_n.length>=20)
    {
        alert("用户名，密码和电话号码长度长度要小于20个字符，注册邮箱的长度要小于50");
        return false;
    }
    $.post("../Index/changepwd",{oldpassword:pwd_o,newpassword:pwd_n}, function (result){
        alert(result['msg']);
        if(result['info']==1) location.reload();
    });
})

$("button#update-bt").click(function() {
    if($("div#userinfo").attr("data-vip")==1)
        alert("已经是VIP用户，无需升级！");
    else
        $.post("../Index/upgrade", function (result){
        alert(result['msg']);
        if(result['info']==1)
            $("a#menu-search").click();
    });
})
$("button#testbtn").click(function()
    {
        $.post("../Index/update_allstock_data", function (result){
            console.log(result);
            console.log('test');
           
       }
    )    
  }
)
