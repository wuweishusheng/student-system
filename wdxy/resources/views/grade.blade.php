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
    <link rel="stylesheet" type="text/css" href="/css/iconfont.css">
</head>
<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        
        <div class="row panel">
            <div class="col-sm-12">

                <div class="ibox float-e-margins">
                    
                    <!-- Example Pagination -->

                    <div class="example-wrap">
                        <h2>学生成绩<i class="iconfont icon-bangzhu" style="margin-left:20px;" id="help"></i></h2>

                        <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                            <button type="button" class="btn btn-outline btn-default">
                                <a class="glyphicon glyphicon-plus" aria-hidden="true" href="form_basic.html#modal-form" data-toggle="modal" style="color: black">录入学生成绩</a>
                            </button>
                            <button type="button" class="btn btn-outline btn-default">
                                <a class="glyphicon glyphicon-plus" aria-hidden="true" href="form_basic.html#modal-kemu" data-toggle="modal" style="color: black">录入科目信息</a>
                            </button>
                        </div>
                        <table id="exampleTableToolbar" data-toggle="table">

                            <thead style="color:black">
                                <tr>
                                    <th data-field="id" data-halign="center">学号</th>
                                    <th data-field="name" data-halign="center">姓名</th>
                                    <!-- 获取科目信息 -->
                                    @foreach ($sub as $v)
                                    <th data-halign="center" data-sortable="true" id="maopao{{$v->id}}"><a aria-hidden="true" href="form_basic.html#modal-kemuxinxi{{$v->id}}" data-toggle="modal" id="maopao{{$v->id}}">{{$v->subject}}</a></th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <!-- 获取学生信息 -->
                                @foreach ($stu as $v)
                                <tr class="text-center">
                                    <td class="qwe"><a href="form_basic.html#lishichengji{{$v->id}}" data-toggle="modal" onclick="lishicj{{$v->id}}()">{{$v->id}}</a></td>
                                    <td>{{$v->name}}</td>
                                    <!-- 获取单个学生成绩信息 -->
                                    @foreach($chengji[$v->id] as $k=>$f)
                                    <td id="grade{{$v->id.$f->id}}" >
                                        <a href="form_basic.html#gradexiugai{{$v->id}}" data-toggle="modal" onclick="xiugaichengji{{$v->id.$f->id}}()">
                                            {{$f->grade}}
                                        </a>
                                    </td>
                                
                                    @endforeach
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
    

    <!--======================= 弹出部分========================-->
    <!-- 添加学生 -->
    <div id="modal-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">录入学生成绩</h3><hr>
                            <form role="form" action="/grade/add" method="POST"  class="form-horizontal"  onsubmit="return check()">
                                {!! csrf_field() !!}
                                <input type="hidden" name="classid" value="{{$classid}}" id="class">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">学号：</label>
                                    <div class="col-sm-10">
                                      <select class="col-sm-12" name="id" id="xuehao" style="height: 30px;">
                                        @foreach ($stu as $v)
                                          <option>{{$v->id}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">科目：</label>
                                    <div class="col-sm-10">
                                        <select class="col-sm-12" name="subject" id="subject" style="height: 30px;">
                                        @foreach ($sub as $v)
                                          <option>{{$v->subject}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">成绩：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" placeholder="考试成绩" name="grade" id="grade">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>执行添加</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 科目信息 -->
    @foreach($sub as $v)
    <div id="modal-kemuxinxi{{$v->id}}" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">科目信息</h3><hr>
                            <form role="form" action="/subject/xiugai" method="POST"  class="form-horizontal">
                                <input type="hidden" name="classid" value="{{$classid}}" id="class">
                                <input type="hidden" name="id" value="{{$v->id}}">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">科&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="subject" value="{{$v->subject}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">考试时间：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="teststarttime" value="{{$v->teststarttime}}" id="time{{$v->id}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">监考老师：</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="testteacher" value="{{$v->testteacher}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">应到人数：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="testyingdao" value="{{$v->testyingdao}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">实到人数：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="testshidao" value="{{$v->testshidao}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">评分老师：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="pingjuanteacher" value="{{$v->pingjuanteacher}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>执行修改</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- 录入科目信息 -->
    <div id="modal-kemu" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">录入科目信息</h3><hr>
                            <form role="form" action="/subject/add" method="POST"  class="form-horizontal">
                                <input type="hidden" name="classid" value="{{$classid}}" id="class">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">科&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="subject" placeholder="请输入科目信息" id="subjecta">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">考试时间：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="teststarttime" placeholder="请选择考试时间" id="time">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">监考老师：</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="testteacher" placeholder="请输入监考老师">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">评分老师：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="pingjuanteacher" placeholder="请输入评分老师">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">应到人数：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="testyingdao" placeholder="请输入应到人数">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">实到人数：</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" name="testshidao" placeholder="请输入实到人数">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>执行修改</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 修改成绩 -->
    @foreach ($stu as $v)
    <div id="gradexiugai{{$v->id}}" aria-hidden="true" class="modal fade" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">修改学生成绩</h3><hr>
                            <form role="form" action="/grade/xiugai" method="POST" class="form-horizontal">
                                <input type="hidden" name="classid" value="{{$classid}}" id="class">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">学号：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="id" id="xuehao" value="{{$v->id}}" readonly="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">科目：</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="subject" id="subject{{$v->id}}"  readonly="true">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">成绩：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" placeholder="考试成绩" name="grade" id="gradeee{{$v->id}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>执行修改</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- 历史成绩 -->
    @foreach ($stu as $v)
    <div id="lishichengji{{$v->id}}" aria-hidden="true" class="modal fade" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="example-wrap">
                            <h2>学生历史成绩</h2>
                            <table id="exampleTableToolbar" data-toggle="table" >

                                <thead style="color:black" >
                                    <tr>
                                        <th data-field="id" data-halign="center">学号</th>
                                        <th data-field="name" data-halign="center">科目</th>
                                        <th data-field="name" data-halign="center">成绩</th>
                                        <th data-halign="center"> 所属班级</th>
                                    </tr>
                                </thead>
                                <tbody id="qweqweqwe{{$v->id}}">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!--======================= 页面JS部分========================-->
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
              pagination: false,                   //是否显示分页（*）
              pageSize: 10,                       //每页的记录行数（*）
             
              iconSize: 'outline',
            });
        })();
    </script>
    <!-- 录入成绩验证器 -->
    <script type="text/javascript">
        // var checkXuehao = false;
        // var checkSubject = false;
        var checkGrade = false;
        // 表单提交验证
        function check(){
            if (checkGrade) {
                return true;
            }else{
                return false;
            }
        }

        $(function(){
            //学号是否正确
            $("#xuehao").blur(function(){
                $.ajax({
                    url:"/grade/checkxuehao",        //请求地址
                    type:"post",     //发送方式
                    async:false,   
                    data:
                        {'id':$('#xuehao').val(),'classid':$('#class').val()},      //是否同步
                    dataType:"json",    //响应数据格式
                    success:function(a){
                        checkXuehao = true;
                    },
                    error:function(){
                        // $('#xuehao').attr('style','border:1px solid red');
                        if ($('#modal-form').css('display')=='block') {
                            layer.msg("学号有误！");
                        }else{

                        }   
                    }
                })
            })
            // //科目是否有
            // $("#subject").blur(function(){
            //     if($('#subject').val()){
            //         checkSubject=true;
            //     }else{
            //         layer.msg('科目输入有误！');
            //     }
            // })
            //成绩是否正确
            $("#grade").blur(function(){

                if($('#grade').val()){
                    checkGrade=true;
                }else{
                }
            })
        })
    </script>
    <!-- 录入科目信息 -->
    <script type="text/javascript">
        $(function(){
            $("#subjecta").blur(function(){
                $.ajax({
                    url:"/subject/subject",        //请求地址
                    type:"post",     //发送方式
                    async:false,   
                    data:
                        {'kemu':$("#subjecta").val(),'classid':$('#class').val()},      //是否同步
                    dataType:"json",    //响应数据格式
                    success:function(a){
                       if (a=='1') {
                            layer.msg("科目已存在！");
                       }
                    },
                    error:function(){
                         
                    }
                })
            })
        })
    </script>
    <script type="text/javascript">
        //考试时间
        laydate.render({
          elem: "#time" //指定元素
        });
    </script>
    <!-- 考试时间 -->
    @foreach($sub as $v)
    <script type="text/javascript">
        //考试时间
        laydate.render({
          elem: "#time{{$v->id}}" //指定元素
        });
    </script>
    @endforeach
    @foreach ($stu as $v)
    @foreach($chengji[$v->id] as $k=>$f)
    <script type="text/javascript">
        function xiugaichengji{{$v->id.$f->id}}(){
            $("#gradeee{{$v->id}}").val({{$f->grade}});
            var id = {{$f->subjectid}};
            $.ajax({
                url:"/grade/chaxunsub",
                type:"post",
                async:false,
                data:{'id':id},
                dataType:"json",
                success:function(a){
                    $('#subject{{$v->id}}').val(a);
                }
            })
        }
        function lishicj{{$v->id}}(){
            var ssss = new Array();
            var gggg = new Array();
            var cccc = new Array();
            id = {{$v->id}};
            $.ajax({
                url:"/grade/chaxunquanbu",
                type:"post",
                async:false,
                data:{'id':id},
                dataType:"json",
                success:function(a){
                    $("#qweqweqwe"+id).children().remove();
                    for(var i = 0;i<a.length;i++){
                        ssss[i] = a[i].subject;
                        gggg[i] = a[i].grade;
                        cccc[i] = a[i].classid;
                        
                        $("<tr><td>"+id+"</td><td>"+ssss[i]+"</td><td>"+gggg[i]+"</td><td>"+cccc[i]+"</td></tr>").appendTo($("#qweqweqwe"+id));
                    }
                    
                         
                }
            })
        }
    </script>
        @endforeach
    @endforeach
    <script type="text/javascript">
        $(function(){
            $("#help").click(function(){
                // //捕获页
                layer.open({
                  type: 1,
                  shade: false,
                  title: false, //不显示标题
                  content: "<div style='background:rgb(26,179,148);color:#fff;width:300px;height:160px;'>&nbsp;<div style='margin-top:20px;margin-left:20px;'>1,点击新增可增加学生成绩;<br>2,点击学号可查看学生历史成绩信息;<br>3,点击科目名称可查看并修改科目信息;<br>4,点击科目成绩修改成绩</div></div>" //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
                  
                });
            })
        })
    </script>
</body>

</html>
