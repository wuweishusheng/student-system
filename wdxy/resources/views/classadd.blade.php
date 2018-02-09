<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>沃德学院运城校区管理系统</title>
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <link rel="shortcut icon" href="favicon.ico"> 
    <link href="/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css?v=4.1.0" rel="stylesheet">
</head>
<body>
    <div class="row">
        <div class="col-sm-5">
            <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4>新增班级</h4>
                <br>
                <h5><span style="color:red">注意：新增完成后重新刷新页面即可看到新增班级</span></h5>
            </div>
            <div class="hr-line-dashed"></div>
            <form role="form" action="/classs/create" method="post"  class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="tid" value="{{$tid}}">
                <div class="form-group">
                    <label class="col-sm-4 control-label">班级名称：</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="classid">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">开班时间：</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="starttime" placeholder="请选择日期" id="starttime">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label">预计毕业时间：</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="finishtime" placeholder="请选择日期" id="finishtime">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label"></label>
                    <div class="col-sm-8">
                      <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>执行添加</strong>
                    </button>
                    </div>
                </div>
            </form>
            </div> 
        </div>
    </div>
    
    
    <script src="/laydate/laydate.js"></script>
    <script type="text/javascript">
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