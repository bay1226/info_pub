<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
<title>Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Modern Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="/info_pub/Public/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="/info_pub/Public/css/style.css" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="/info_pub/Public/css/lines.css" rel='stylesheet' type='text/css' />
<link href="/info_pub/Public/css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="/info_pub/Public/js/jquery.min.js"></script>
<!-- Nav CSS -->
<link href="/info_pub/Public/css/custom.css" rel="stylesheet">
<link href="/info_pub/Public/css/index.css" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="/info_pub/Public/js/metisMenu.min.js"></script>
<script src="/info_pub/Public/js/custom.js"></script>

<script src="/info_pub/Public/js/jquery.tableSort.js"></script>
<!--for K-graph-->
<script src="/info_pub/Public/js/d3.min.js"></script>
<script src="/info_pub/Public/js/techan.min.js"></script>
<script type="text/javascript">
    
function drawK(code)
{

    var margin = {top: 20, right: 20, bottom: 30, left: 50},
            width = 1000 - margin.left - margin.right,
            height = 400 - margin.top - margin.bottom;

    var parseDate = d3.time.format("%d-%b-%y").parse;

    var x = techan.scale.financetime()
            .range([0, width]);

    var y = d3.scale.linear()
            .range([height, 0]);

    var candlestick = techan.plot.candlestick()
            .xScale(x)
            .yScale(y);

    var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");

    var yAxis = d3.svg.axis()
            .scale(y)
            .orient("left");

    var svg = d3.select("#k-content").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    d3.csv("/info_pub/Public/data/data.csv", function(error, data) {
        var accessor = candlestick.accessor(),
            timestart = Date.now();

        data = data.slice(0, 200).map(function(d) {
            return {
                date: parseDate(d.Date),
                open: +d.Open,
                high: +d.High,
                low: +d.Low,
                close: +d.Close,
                volume: +d.Volume
            };
        }).sort(function(a, b) { return d3.ascending(accessor.d(a), accessor.d(b)); });

        x.domain(data.map(accessor.d));
        //x.domain(d3.extent(data, function(d) { return d.date; }));
        y.domain(techan.scale.plot.ohlc(data, accessor).domain());

        svg.append("g")
                .datum(data)
                .attr("class", "candlestick")
                .call(candlestick);

        svg.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis);

        svg.append("g")
                .attr("class", "y axis")
                .call(yAxis)
                .append("text")
                .attr("transform", "rotate(-90)")
                .attr("y", 6)
                .attr("dy", ".71em")
                .style("text-anchor", "end")
                .text("Price ($)");

        console.log("Render time: " + (Date.now()-timestart));
    });

}
</script>
</head>
<body>
    <button id='testbtn'>Test</button>
<div id="userinfo" data-name="<?php echo ($username); ?>" data-vip="<?php echo ($isvip); ?>" data-tel="<?php echo ($tel); ?>" data-mail="<?php echo ($mail); ?>">
</div>
<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Menu</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">Information Publish System</a>
            </div>
            <!-- /.navbar-header -->
            
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a id="menu-publish" href="#"><i class="fa fa-flag nav_icon"></i>Notes Board</a>
                        </li>
                        <li>
                            <a id="menu-search" href="#"><i class="fa fa-search nav_icon"></i>Stoke Search</a>
                        </li>
                        <li>
                            <a id="menu-changepsw" href="#"><i class="fa fa-key nav_icon"></i>Change Password</a>
                        </li>
                        <li>
                            <a id="menu-update" href="#"><i class="fa fa-upload nav_icon"></i>Upgrade Account</a>                   
                        </li>
                        <li>
                            <a id="menu-help" href="#"><i class="fa fa-book nav_icon"></i>User Manual</a>
                        </li>
                        <li>
                            <a id="menu-logout" href="#"><i class="fa fa-adjust nav_icon"></i>Log Out</a>
                        </li>
                        <li>
                            <a id="menu-recover" href="#"><i class="fa fa-adjust nav_icon"></i>Recover</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
        	<div id="main-view">
                <div class="main-part" id="publish">
                    <div class="col-md-12">
                        <h3>公告发布</h3>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div>
                                <p id="note">公告</p>
                                <script type="text/javascript">
                                    setInterval('getnote()',5000);
                                </script>
                            </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
	        	<div class="main-part" id="search">
					<div class="col-md-12">
						<h3>股票查询</h3>
					</div>
		        	<div class="form-group">
						<div class="col-md-12">
							<div class="input-group">
								<input id="search-in" type="text" placeholder="search" class="form-control1">
							</div>
						</div>
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary" id="search-bt">Search</button>
						</div>
		        		<div class="col-md-12">
		        			<div id="search-res">
                                <div class="bs-example4" data-example-id="contextual-table" style="padding:20px 0">
                                    <table class="table table-striped" id="stocktable">
                                        <thead>
                                            <tr class="success" id="table-head">
                                                <th>stock_code</th>
                                                <th>stock_name</th>
                                                <th>open</th>
                                                <th>close</th>
                                                <th>indecrease</th>
                                                <th>total_price</th>
                                                <th>total_num</th>
                                                <th>max</th>
                                                <th>min</th>
                                                <th>price</th>
                                                <th>operation</th>
                                            </tr>
                                        </thead>
                                        <tbody id="search-res-table">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
		        		</div>
						<div class="clearfix"> </div>
					</div>
	        	</div>
	        	<div class="main-part" id="changepsw">
					<div class="col-md-12">
						<h3>修改密码</h3>
					</div>
		        	<div class="form-group">
						<div class="col-md-12">
							<div class="input-group">
								<input type="password" class="form-control1" id="changepsw-old" placeholder="旧密码">
							</div>
						</div>
						<div class="col-md-12">
							<div class="input-group">
								<input type="password" class="form-control1" id="changepsw-new" placeholder="新密码">
							</div>
						</div>
						<div class="col-md-12">
							<div class="input-group">
								<input type="password" class="form-control1" id="changepsw-re"  placeholder="重复密码">
							</div>
						</div>
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary" id="changepsw-bt">Submit</button>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div>
	        	<div class="main-part" id="update">
					<div class="col-md-12">
						<h3>账户升级</h3>
					</div>
		        	<div class="form-group">
		        		<div class="col-md-12">
							<button type="submit" class="btn btn-primary" id="update-bt">去支付</button>
						</div>
						<div class="clearfix"> </div>
		        	</div>
	        	</div>
                <div class="main-part" id="help">
                    <div class="col-md-12">
                        <h3>用户手册</h3>
                    </div>
                </div>
	        </div>
       	</div>
      	<!-- /#page-wrapper -->

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog" style="width:1000px">
      <div class="modal-content" style="width:1000px">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               模态框（Modal）标题
            </h4>
         </div>
         <div class="modal-body" id="k-content" style="width:1000px">
            在这里添加一些文本
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="$('#myModal').modal('hide');">
               关闭
            </button>
         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->

   </div>
    <!-- /#wrapper -->
    <!-- Bootstrap Core JavaScript -->
    <script src="/info_pub/Public/js/bootstrap.min.js"></script>
    <script src="/info_pub/Public/js/index.js"></script>
</body>
</html>