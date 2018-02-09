<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <title>沃德学院运城校区管理系统</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/login.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>
        if (window.top !== window.self) {
            window.top.location = window.location;
        }
    </script>

</head>

<body class="signin">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-7">
                <div class="signin-info">
                    <div class="logopanel m-b">
                        <h1></h1>
                    </div>
                    <div class="m-b"></div>
                    <h4>欢迎来到 <strong>沃德学院运城校区管理系统</strong></h4>
                    <ul class="m-b">
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 后台选用了采用最新的laravel5.5版本</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 完全响应式布局（支持电脑、平板、手机等所有主流设备）</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 提供3套不同风格的皮肤</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 使用最流行的的扁平化设计</li>
                        <li><i class="fa fa-arrow-circle-o-right m-r-xs"></i> 采用HTML5 & CSS3</li>
                    </ul>
                    <!-- <strong>还没有账号？ <a href="#">立即注册&raquo;</a></strong> -->
                </div>
            </div>
            <div class="col-sm-5">
                <form  method="POST" action="{{ route('login') }}" >
                    {{ csrf_field() }}
                    <h4 class="no-margins">登录：</h4>
                    <p class="m-t-md">登录到学生管理系统</p>
                    <input name="name" value="{{ old('name') }}" class="form-control uname" placeholder="用户名" required autofocus/>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong style="color: red">{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    <input type="password" name="password" class="form-control pword m-b" placeholder="密码" required="" />
                    <a href="{{ route('password.request') }}">忘记密码了？</a>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <!-- <a href="">忘记密码了？</a> -->
                    <button class="btn btn-success btn-block">登录</button>
                </form>
            </div>
        </div>
        <div class="signup-footer">
            <div class="pull-left">
                © 2018 2018 chenxun All Rights Reserved
            </div>
        </div>
    </div>
</body>

</html>
