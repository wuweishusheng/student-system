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
    
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><a data-toggle="modal" href="form_basic.html#classedit">{{$class->classid}}基本信息</a></h5>
                    </div>
                    <div class="ibox-content">
                        <ul>
                            <li>人数：{{$num}}</li>
                            <li>状态：{{$class->status}}</li>
                            <li>开班时间：{{$class->starttime}}</li>
                            <li>毕业时间：{{$class->finishtime}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row panel">
            <div class="col-sm-12">

                <div class="ibox float-e-margins">
                    
                    <!-- Example Pagination -->

                    <div class="example-wrap">
                        <h2>学生基本信息</h2>
                        <div class="btn-group hidden-xs" id="exampleTableEventsToolbar" role="group">
                            <button type="button" class="btn btn-outline btn-default">
                                <a class="glyphicon glyphicon-plus" aria-hidden="true" href="form_basic.html#modal-form" data-toggle="modal" style="color: black">新增</a>
                            </button>
                            <button type="button" class="btn btn-outline btn-default">
                                <i class="glyphicon glyphicon-pencil edit" aria-hidden="true">修改</i>
                            </button>
                            <button type="button" class="btn btn-outline btn-default">
                                <i class="glyphicon glyphicon-remove delete" aria-hidden="true">删除</i>
                            </button>
                        </div>
                        <table id="exampleTableToolbar" data-toggle="table">

                            <thead style="color:black">
                                <tr>
                                    <th data-field="check" data-checkbox="true"></th>
                                    <th data-field="id" data-halign="center">ID</th>
                                    <th data-field="name" data-halign="center">姓名</th>
                                    <th data-field="sex" data-sortable="true" data-halign="center">性别</th>
                                    <th data-field="shenfenzheng" data-halign="center">身份证</th>
                                    <th data-field="iphone" data-halign="center">手机</th>
                                    <th data-field="jphone" data-halign="center">家属手机</th>
                                    <th data-field="address" data-halign="center">家庭住址</th>
                                    <th data-field="score" data-sortable="true" data-halign="center">学分</th>
                                    <th data-field="classid" data-halign="center">所在班级</th>
                                    <th data-field="created_at" data-sortable="true" data-halign="center">创建时间</th>
                                    <th data-field="state" data-halign="center">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($stu as $v)
                                <tr class="text-center">
                                    <td></td>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->sex}}</td>
                                    <td>{{$v->shenfenzheng}}</td>
                                    <td>{{$v->iphone}}</td>
                                    <td>{{$v->jphone}}</td>
                                    <td>{{$v->address}}</td>
                                    <td>{{$v->score}}</td>
                                    <td>{{$class->classid}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td><button class="btn btn-info btn-sm" onclick="scoremore({{$v->id}})">学分详情</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#score" class="btn btn-warning btn-sm" data-toggle="modal" onclick="score({{$v->id}})">学分管理</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#liuji" class="btn btn-danger btn-sm" data-toggle="modal" onclick="liuji({{$v->id}})">留级</a></td>
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
    
    <!-- 添加学生 -->
    <div id="modal-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">添加学生</h3><hr>
                            <form role="form" action="" method="post"  class="form-horizontal">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">姓名：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" placeholder="姓名" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">性别：</label>
                                    <div class="col-sm-10">
                                        <select name="sex" class="form-control">
                                            <option value="男">男</option>
                                            <option value="女">女</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">身份证：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" placeholder="身份证" name="shenfenzheng">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">手机：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" placeholder="手机" name="iphone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">家属手机：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" placeholder="父亲:13888888888" name="jphone">
                                    </div>
                                </div>
                                <div class="form-group form-inline">
                                    <label class="col-sm-2 control-label">家庭住址：</label>
                                    <div class="col-sm-10">
                                        <select id="s_province" name="province" class="form-control"></select>&nbsp;&nbsp;
                                        <select id="s_city" name="city"  class="form-control"></select>&nbsp;&nbsp;
                                        <select id="s_county" name="county"  class="form-control"></select>
                                    <script class="resources library" src="/js/area.js" type="text/javascript"></script>
                                    
                                    <script type="text/javascript">_init_area();</script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" placeholder="详细地址" name="s_address">
                                    </div>
                                </div>
                                <input type="hidden" name="classid" value="{{$class->id}}">
                                <div>
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

    <!-- 学分管理 -->
    <div id="score" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">学分管理</h3><hr>
                            <form role="form" action="/score/update" method="post"  class="form-horizontal score">
                                <div class="form-group" >
                                    <label class="col-sm-2 control-label">加减：</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="num" placeholder="加分输入正数,减分输入负数。" max="100" min="-100">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">时间：</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="请选择日期" id="time" name="time">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">原因：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="reason" placeholder="扣分原因">
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

    <!-- 留级管理 -->
    <div id="liuji" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">留级管理</h3><hr>
                            <form role="form" action="/student/liuji" method="post"  class="form-horizontal liuji">
                                <div class="form-group" >
                                    <label class="col-sm-2 control-label">班级选择：</label>
                                    <div class="col-sm-10">
                                        <select name="moreclass" class="form-control">
                                            @foreach ($moreclass as $v)
                                                <option value="{{$v->id}}">{{$v->classid}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">时间：</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" placeholder="请选择日期" id="time1" name="time">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">原因：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="reason" placeholder="留级原因">
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

    <!-- 班级信息 -->
    <div id="classedit" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="m-t-none m-b">班级信息</h3><hr>
                            <form role="form" action="/classs/store" method="post"  class="form-horizontal">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">状态：</label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-control">
                                            <option value="0" {{ $class->status=='0' ? 'selected' : '' }}>正常</option>
                                            <option value="1" {{ $class->status=='1' ? 'selected' : '' }}>毕业</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">开班时间：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="starttime"  value="{{$class->starttime}}" id="starttime">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">毕业时间：</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" name="finishtime" value="{{$class->finishtime}}" id="finishtime">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{$class->id}}">
                                <div>
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
    </script>
    <script>
        $(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            //删除学生
            $('.delete').click(function(){
                var id = $('#exampleTableToolbar').bootstrapTable('getSelections')[0].id;
                layer.confirm('你确定要删除吗？', {
                    btn: ['删除','取消'] 
                  }, function(){
                    $.get("/student/destroy",{id:id},function(data,status){
                        layer.msg('删除成功', {icon: 1});
                        //删除表格
                        var ids = $.map($('#exampleTableToolbar').bootstrapTable('getSelections'), function (row) {
                            return row.id;
                        });
                        $('#exampleTableToolbar').bootstrapTable('remove', {
                            field: 'id',
                            values: ids
                        });
                    });
                  }, function(){
                    layer.msg('已取消',{icon: 2});
                  });
               
                ////批量删除
                // var ob = $('#exampleTableToolbar').bootstrapTable('getSelections');
                // var id = [];
                // //拼装需要删除的数组
                // for (var i=0;i<ob.length;i++){ 
                //     id[i]=ob[i].id;
                // }
                // $.get("/student/destroy",{id:id},function(data,status){
                //     // layer.msg('删除成功', {icon: 1});
                //     location.reload();
                // });
            });

            //修改学生
            $('.edit').click(function(){
                var ob = $('#exampleTableToolbar').bootstrapTable('getSelections')[0];
                //页面层
                layer.open({
                  type: 1,
                  title:'修改学生信息',
                  skin: 'layui-layer-rim', //加上边框
                  area: ['640px', '500px'],
                  content: '<div class="modal-dialog"><div class="modal-body"><div class="row"><div class="col-sm-12"><form role="form" action="/student/update" method="post"  class="form-horizontal"><input type="hidden" name="id" value='+ob.id+'><input type="hidden" name="classid" value="{{$class->id}}"><div class="form-group"><label class="col-sm-2 control-label">姓名：</label><div class="col-sm-10"><input type="text" class="form-control" placeholder="姓名" name="name" value='+ob.name+'></div></div><div class="form-group"><label class="col-sm-2 control-label">性别：</label><div class="col-sm-10"><select name="sex" class="form-control"><option value="男">男</option><option value="女">女</option></select></div></div><div class="form-group"><label class="col-sm-2 control-label">身份证：</label><div class="col-sm-10"><input type="text" class="form-control" placeholder="身份证" name="shenfenzheng" value='+ob.shenfenzheng+'></div></div><div class="form-group"><label class="col-sm-2 control-label">手机：</label><div class="col-sm-10"><input type="text" class="form-control" placeholder="手机" name="iphone" value='+ob.iphone+'></div></div><div class="form-group"><label class="col-sm-2 control-label">家属手机：</label><div class="col-sm-10"><input type="text" class="form-control" placeholder="父亲:13888888888" name="jphone" value='+ob.jphone+'></div></div><div class="form-group"><label class="col-sm-2 control-label">家庭住址：</label><div class="col-sm-10"><input type="text" class="form-control" placeholder="详细地址" name="address" value='+ob.address+'></div></div><div><button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>执行修改</strong></button></div></form></div></div></div></div>'
                });
                // $.get('/student/show/'+id, {}, function(str){
                //   layer.open({
                //     type: 1,
                //     title:'修改学生信息',
                //     skin: 'layui-layer-rim', //加上边框
                //     area: ['640px', '450px'],
                //     content: str //注意，如果str是object，那么需要字符拼接。
                //   });
                // });
            });
        });
        
    </script>

    <script type="text/javascript">
        var Gid  = document.getElementById ;
        var showArea = function(){
            Gid('show').innerHTML = "<h3>省" + Gid('s_province').value + " - 市" +    
            Gid('s_city').value + " - 县/区" + 
            Gid('s_county').value + "</h3>"
        }
        Gid('s_county').setAttribute('onchange','showArea()');
    </script>
    <script type="text/javascript">
        //学分管理
        function score(id){
            var str = '<input type="hidden" class="form-control" name="id" value="'+id+'">';
            $(".score").append(str);
        }
        //留级
        function liuji(id){
            var str = '<input type="hidden" class="form-control" name="id" value="'+id+'">';
            $(".liuji").append(str);
        }
        //学分详情查看
        function scoremore(id){
            $.post('/score/show', {id:id}, function(str){
              layer.open({
                type: 1,
                title:'学分详情',
                skin: 'layui-layer-rim', //加上边框
                area: ['640px', '450px'],
                content: str //注意，如果str是object，那么需要字符拼接。
              });
            });
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
</body>

</html>
