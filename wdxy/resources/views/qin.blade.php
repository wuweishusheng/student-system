<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>学生信息表</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.css" rel="stylesheet">
    <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/css/bootstrap-table.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <!-- //时间选择器样式 -->
    <link rel="stylesheet" type="text/css" media="all" href="/js/plugins/moment/daterangepicker.css" />
	 <!-- Input Mask 时间选择格式设定-->
    <!-- <link href="/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet"> -->
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><a data-toggle="modal" href="#info" style="cursor:help;"> {{$class->classid}} - 考勤概览(单位/期) <small><i class="fa fa-warning"></i></small></a>
														
													<!-- 	<button class="btn btn-outline btn-warning dim" type="button" >
                    				</button> -->
                        </h5>
	                    <div class="ibox-tools">
	                        <a class="collapse-link">
	                            <i class="fa fa-chevron-up"></i>
	                        </a>
	                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	                            
	                        </a>
	                    </div>
                    </div>

                    <div class="ibox-content col-sm-3" style="clear: none;border: 1px solid #999;height: 385px;">
                    				<input type="hidden" value="{{$today->count}}" id="count">
                    				<input type="hidden" value="{{$num}}" id="ren">
                    				@if ($today->lian > 0)
                        		<small>
	                                <strong>恭喜：</strong> 截至昨天,已经 <strong style="color:red; font-size: 16px;" >连续吃鸡 </strong> <strong> {{$today->lian}} </strong> 天了!!!!!
	                          </small>
	                          @elseif ($today->lian < 1)
	                         	<small>
	                                <strong>加油：</strong> 昨天,你们<strong style="color:#f15a24; font-size: 16px;" > 没有吃鸡 </strong>哦!!!!
	                          </small>
	                          @endif
                            <div id="morris-donut-chart" width="25%"></div>           
                       			
                    </div>
                    <div class="ibox-content col-sm-3" style="clear: none;height: 385px;border: 1px solid #999;">
                    	<h3>班级总览</h3>
                        <ul>
                            <li>人数：{{$num}}</li>
                            <li>请假(时段)：{{$class->classjia}}</li>
                            <li>旷课(时段)：{{$class->classkuang}}</li>
                            <li>迟到(人次)：{{$class->classchi}}</li>
                            <li>早退(人次)：{{$class->classtui}}</li>
                        </ul>
                        <ul class="stat-list m-t-lg">
                        		<li>
                                <h2 class="no-margins ">{{$class->ke}}</h2>
                                <small>课程进度({{$class->jin}})</small>
                                <div class="progress progress-mini">
                                    <div class="progress-bar" style="width: {{$class->jin}};"></div>
                                </div>
                            </li>
                            <li>
                                <h2 class="no-margins">{{$class->classzong}}</h2>
                                <small>总考勤事故({{$class->shigu}})</small>
                                <div class="progress progress-mini">
                                    <div class="progress-bar" style="width: {{$class->shigu}};"></div>
                                </div>
                            </li>
                            <li>
                                <h2 class="no-margins ">{{$class->yuezong}}</h2>
                                <small>最近一个月考勤事故({{$class->shigu}})</small>
                                <div class="progress progress-mini">
                                    <div class="progress-bar" style="width: {{$class->yueshigu}};"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
										<div class="ibox-content col-sm-6" style="clear: none;height: 385px;border: 1px solid #999;overflow:hidden;">
                    	<h3>最新情况 <small class="pull-right"> <a href="#zuixin" data-toggle="modal" class="link">
	                            更多 <i class="fa fa-chevron-right"></i> 
	                        </a> </small></h3>
	                      <div class="ibox-content no-padding" >
	                        <ul class="list-group">
	                        		@for ($i = 0; $i < (count($qin) < 8 ? count($qin) :8); $i++)
	                            <li class="list-group-item" style="padding:10px 15px;">
	                            	<p style="margin-bottom:0px;">
																<i class="fa fa-circle text-navy"></i>&nbsp&nbsp&nbsp
	                            	学生 {{$qin[$i]->stuid}}, {{$qin[$i]->time}} 因为  {{$qin[$i]->beizhu}} {{$qin[$i]->type}}被记<small class="pull-right"><i class="fa fa-clock-o"> </i>  {{substr($qin[$i]->created_at,0,10)}} <span onclick="shan({{$qin[$i]->id}},this)"><i class="glyphicon glyphicon-remove delete" aria-hidden="true" ></i></span> </small> </p>
	                            </li>
	                            @endfor
	                        </ul>
                        </div>
                    </div>
								

                </div>
              </div>
             
            </div>
        </div>
        <div class="row panel">
            <div class="col-sm-12">
                <div class="ibox float-e-margins" id="shuai">
                    
                    <!-- Example Pagination -->

                    <div class="example-wrap ibox-content">
                        <h2>学生考勤信息</h2>
                    		<div class="col-sm-4"> 
		                    		<form role="form" action="/student/qin/{{$class->id}}" method="post" onsubmit="return validate_form(this,'时间不合法')" class="form-horizontal">
		                                {!! csrf_field() !!}
				                    		<div class="form-group" style="display: inline;">
				                                <div class="col-sm-10" style="display: inline;">
				                                    <div class="input-group m-b" id="zhou">
				                                    		<span class="input-group-btn">
				                                            <button type="button" class="btn ">
				                                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i></button> 
				                                         </span>
				                                         <!-- class="form-control" data-mask="9999-99-99" -->
				                                        <input type="text" class="form-control" data-mask="9999/99/99 - 9999/99/99"  value="请输入时间区间" name="qujian">
				                                        <span class="input-group-btn"><button class="btn btn-primary" type="submit">提交</button></span>
				                                    </div>
				                                </div>
				                        </div>
		                        </form>

					             	</div>
												
                        <table id="exampleTableToolbar" data-toggle="table">

                            <thead style="color:black">
                                <tr>
                                    <th data-field="check" data-checkbox="true"></th>
                                    <th data-field="id" data-sortable="true" data-halign="center">ID</th>
                                    <th data-field="name" data-sortable="true" data-halign="center">姓名</th>
                                    <th data-field="sex"  data-halign="center">破损度</th>
                                    <th data-field="shenfenzheng" data-sortable="true" data-halign="center">破损比</th>
                                    <th data-field="iphone" data-sortable="true" data-halign="center">请假次数</th>
                                    <th data-field="jphone" data-sortable="true" data-halign="center">旷课次数</th>
                                    <th data-field="address" data-sortable="true" data-halign="center">迟到次数</th>
                                    <th data-field="score" data-sortable="true" data-halign="center">早退次数</th>
                                    <th data-field="liu" data-sortable="true" data-halign="center">留级次数</th>
                                    <th data-field="zong" data-sortable="true" data-halign="center">总课段数</th>
                                    <th data-field="classid" data-sortable="true" data-halign="center">最近更新</th>
                                    <th data-field="state" data-halign="center">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($stu as $v)
                                <tr class="text-center">
                                    <td></td>
                                    <td>{{$v['id']}}</td>
                                    <td>{{$v['name']}}</td>
                                    <td ><span class="pie">{{$v['jia']+$v['kuang']+$v['chi']+$v['tui']}}/{{$v['zong']*3}}</span></td>
                                    <td>{{$v['jia']+$v['kuang']+$v['chi']+$v['tui']}}/{{$v['zong']*3}}</td>
                                    <td>{{$v['jia']}}</td>
                                    <td>{{$v['kuang']}}</td>
                                    <td>{{$v['chi']}}</td>
                                    <td>{{$v['tui']}}</td>
                                    <td >
                                        <a href="javascript:;" onclick="liuinfo({{$v['id']}})"> {{$v['liu']}}</a>
                                    </td>
                                    <td>{{$v['zong']}}(*3)</td>
                                   
                                    <td>{{substr($v['created_at'],0,10)}}</td>
                               
                                    <td>
                                    		<a href="javascript:;" class="btn btn-info btn-sm" data-toggle="modal" onclick="scoremore({{$v['id']}})">考勤详情</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    		<a href="#score" class="btn btn-warning btn-sm" data-toggle="modal" onclick="score({{$v['id']}})">添加考勤</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    <!-- End Example Pagination -->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- 添加考勤 -->
    <div id="score" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b"考勤管理</h3><hr>
                            <form role="form" action="/qin/update" method="post"  class="form-horizontal score">
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">种类：</label>
                                    <div class="col-sm-10">
                                        <select class="form-control m-b" name="type">
				                                    <option value="1">请假</option>
				                                    <option value="2">旷课</option>
				                                    <option value="3">迟到</option>
				                                    <option value="4">早退</option>
				                                </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">时段：</label>
                                    <div class="col-sm-10">
                                       <div class="radio i-checks">
					                                <label><input type="radio" value="1" name="time"> <i></i> 上午</label>
					                                <label><input type="radio" value="2" name="time"> <i></i> 下午</label>
					                                <label><input type="radio" value="3" name="time"> <i></i> 晚上</label>
					                                <label><input type="radio" value="4" name="time"> <i></i> 全天</label>
					                            </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">说明：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="beizhu" placeholder="其他说明">
                                    </div>
                                </div>
                                <input type="hidden" name="classid" value="{{$class->id}}">
                                <div>
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>执行操作</strong>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
		
		<!-- 最新情况 -->
		<div id="zuixin" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">最新情况</h3><hr>
                            <ul class="list-group" style="height: 450px;overflow: scroll;">
	                        		@foreach ($qin as $v)
	                            <li class="list-group-item" >
	                            	<p style="margin-bottom:0px;">
	                            	<i class="fa fa-circle text-navy"></i>&nbsp&nbsp&nbsp
	                            	学生 {{$v->stuid}} 因为  {{$v->beizhu}} {{$v->type}}, {{$v->time}} 被记<small class="pull-right"><i class="fa fa-clock-o"> </i>  {{$v->created_at}}</small></p>
	                            </li>
	                            @endforeach
	                           
	                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>	

		<!-- 考勤说明 -->
		<div id="info" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">考勤说明</h3><hr>

                            <ul class="list-group" style="height: 450px;overflow: scroll;">
	                        	
	                            <li class="list-group-item" >
	                            	<p style="margin-bottom:0px;"><i class="fa fa-circle text-navy"></i>
	                            	大环状图为今日考勤情况, 总人次是全班人数,被记一次(包括重复迟到被记),不正常考勤增一人次,没有被记考勤,则吃鸡!
	                            	</p> 
	                            </li>
	                            <li class="list-group-item" >
	                            	<p style="margin-bottom:0px;"><i class="fa fa-circle text-navy"></i>
	                            	班级总览 : 一天分为三课时段,请全天假会被记3个时段 ; 课程进度 : 上课天数(除周末)/所设定开班时间到毕业时间总天数(除周末) ; 总考勤事故 : 班级总的被记请假,旷课,迟到,早退的课时段之和/上课天数(除周末) ; 本月考勤 : 班级本月被记请假,旷课,迟到,早退的课时段之和/本月上课天数 ;
	                            	</p> 
	                            </li>
	                            <li class="list-group-item" >
	                            	<p style="margin-bottom:0px;"><i class="fa fa-circle text-navy"></i>
	                            	最新情况 : 班级考勤被记情况时间轴
	                            	</p> 
	                            </li>
	                            <li class="list-group-item" >
	                            	<p style="margin-bottom:0px;"><i class="fa fa-circle text-navy"></i>
	                            	破损比 : 个人总的被记请假,旷课,迟到,早退的课时段之和/来校上课天数(除周末),包括留级前的记录;
	                            	破损度 : 即破损比;
	                            	</p> 
	                            </li>
	                            <li class="list-group-item" >
	                            	<p style="margin-bottom:0px;">
	                            	<td><i class="fa fa-circle text-navy"></i></td>
	                            	请假,旷课,迟到,早退,以课时段记,请假全天记3课时段;<br/>
	                            	总课段数以天数*3记;
	                            	</p> 
	                            </li>
	                            <li class="list-group-item" >
	                            	<p style="margin-bottom:0px;">
	                            	<td><i class="fa fa-circle text-navy"></i></td>
	                            		留级不会被计入;
	                            	</p> 
	                            </li>
	                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- 全局js -->
    <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/layer/layer.js"></script>

    <!-- Peity -->
    <script src="/js/plugins/peity/jquery.peity.min.js"></script>

    <!-- 自定义js -->
    <script src="/js/content.js?v=1.0.0"></script>

    <!-- Bootstrap table -->
    <script src="/js/plugins/bootstrap-table/bootstrap-table.min.js"></script>
    <script src="/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js"></script>
    <script src="/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
    <!-- iCheck -->
    <script src="/js/plugins/iCheck/icheck.min.js"></script>
    <script src="/laydate/laydate.js"></script>


    <script type="text/javascript">
        (function() {
            $('#exampleTableToolbar').bootstrapTable({
              search: true,
              showRefresh: true,
              toolbar: '#exampleTableEventsToolbar',
              showColumns: true,
              cache: false,                       //是否使用缓存，默认为true，所以一般情况下需要设置一下这个属性（*）
              singleSelect:true,
              pagination: true,                   //是否显示分页（*）
              pageSize: 10,                       //每页的记录行数（*）
              pageList: [10, 25, 50, 100],        //可供选择的每页的行数（*）
              iconSize: 'outline',
            });
        })();
			 //时间选择器
			$(function () {
				/*设置开始结束时间*/
						var qujian1 = <?php echo json_encode($qujian[0]) ?>;
						var qujian2 = <?php echo json_encode($qujian[1]) ?>;
				    var start = moment(qujian1);
				    var end = moment(qujian2);
				    var datas = {};
				/*选择之后，将时间重新赋值input*/
				    function cb(start, end) {
				        $('#zhou input').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
				    }
				    $('#zhou').daterangepicker({
				    startDate: start,
				    endDate: end,
				    /*本地化数据*/
				    locale: {
				        "format": "YYYY/MM/DD",
				        "separator": " - ",
				        "applyLabel": "应用",
				        "cancelLabel": "关闭",
				        "fromLabel": "From",
				        "toLabel": "至",
				        "customRangeLabel": "自定义",
				        "weekLabel": "W",
				        "daysOfWeek": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"
				        ],
				        "monthNames": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"
				        ],
				        "firstDay": 1
				    },
				    ranges: {
				        '今天': [moment(), moment().subtract(-1, 'days')],
				        '昨天': [moment().subtract(1, 'days'), moment()],
				        '前7天': [moment().subtract(7, 'days'), moment()],
				        '前30天': [moment().subtract(30, 'days'), moment()],
				        '本月': [moment().startOf('month'), moment().endOf('month').subtract(-1,'day')],
				        '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month').subtract(-1,'day')],
				        '所有': [moment("2017-01-01"), moment().subtract(-1, 'days')]
				    }
				}, cb);

				    cb(start, end);
				}); 

    </script>
    <script>
        $(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
          });
        
    </script>
    <script type="text/javascript">

        //删除学生考勤
        function shan(id,obj){
          layer.confirm('你确定要删除吗？', {
              btn: ['删除','取消'] 
            }, function(){
              $.get("/qin/delete",{id:id},
              	function(data){
                  layer.msg('删除成功', {icon: 1});		
                  location.reload();
              });
            }, function(){
              layer.msg('已取消',{icon: 2});
            });
        }
        //考勤管理
        function score(id){
            var str = '<input type="hidden" class="form-control" name="stuid" value="'+id+'">';
            $(".score").append(str);
        }

			//学分详情查看
        function scoremore(id){
            $.post('/qin/show', {id:id}, function(str){
              layer.open({
                type: 1,
                title:'学分详情',
                skin: 'layui-layer-rim', //加上边框
                area: ['640px', '450px'],
                content: str //注意，如果str是object，那么需要字符拼接。
              });
            });
        }
			//学分详情查看
        function liuinfo(id){
            $.post('/qin/liuinfo', {id:id}, function(str){
              layer.open({
                type: 1,
                title:'留级详情',
                skin: 'layui-layer-rim', //加上边框
                area: ['640px', '450px'],
                content: str //注意，如果str是object，那么需要字符拼接。
              });
            });
        }

      //验证时间是否合法
      function validate_form(field,alerttxt){
				with (field){
					var date = qujian.value;
					var date1 = date.split(" - ");
					if((new Date(date1[0]).getDate()==date1[0].substring(date1[0].length-2))
						&& (new Date(date1[1]).getDate()==date1[1].substring(date1[1].length-2))
						){
						return true;
					}else {
						alert(alerttxt);
					  return false;
					}
				}
			}

        //扣分时间
        laydate.render({
          elem: '#time' //指定元素
        });
        //留级时间
        laydate.render({
          elem: '#time1' //指定元素
        });
        //开班时间
        laydate.render({
          elem: '#starttime' //指定元素
        });
        //毕业时间
        laydate.render({
          elem: '#finishtime' //指定元素
        });
    </script>


    <!-- 周帅 -->
    <!-- Morris -->
    <script src="/js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="/js/plugins/morris/morris.js"></script>
    <!-- Morris demo 班级概览图-->
    <script src="/js/demo/morris-demo.js"></script>
		<!-- Peity demo 个人完整度饼图-->
    <!-- <script src="/js/demo/peity-demo.js"></script> -->
    <!-- Sparkline 未用-->
    <script src="/js/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- Sparkline demo data 未用-->
    <script src="/js/demo/sparkline-demo.js"></script>
    <!-- moment时间选择器 -->
    <script type="text/javascript" src="/js/plugins/moment/moment.js"></script>
    <script type="text/javascript" src="/js/plugins/moment/daterangepicker.js"></script>
    <!-- Input Mask 时间选择格式设定-->
    <script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>

</body>

</html>
<script type="text/javascript">

// <!-- Peity demo 个人完整度饼图-->
var tu = function(){   
    $("span.pie").peity("pie", {
        fill: ['#1ab394', '#d7d7d7', '#ffffff']
    })
}
 tu();
 //个人完整度饼图饼图解决失败方案
$("body").click(function(){
  tu();
 });


//  $("#shuai").delegate(".dropdown-menu","click",function(){
//   alert(111);
// });

  
  
  
</script>