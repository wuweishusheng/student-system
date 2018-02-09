<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Classs;
use App\Score;
use Hash;
class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取登陆用户的id
        $id = Auth::id();
        //查询班主任基本信息
        $users = User::find($id);
        //获取班主任管理的班级
        $class = $users->class;
        $class = trim($class,"#");
        $arr = explode("#", $class);
        $arr = Classs::find($arr);

        return view('index',['users'=>$users,'arr'=>$arr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //获取最新动态
        $score = Score::orderBy('time', 'desc')->take(100)->get();
        return view('main',['score'=>$score]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //班主任修改密码
        $pass = $request->pass;
        $newpass = $request->newpass;
        $passagain = $request->passagain;
        //两次密码一致性
        if ($newpass == $passagain) {
            $id = Auth::id();
            $user = User::where('id', $id)->first();
            //验证原密码正确
            if (Hash::check($pass,$user->password)) {
                //更新密码
                $user->password = bcrypt($newpass);
                $user->save();
                return "修改成功";
            }else{
                return "原密码错误";
            }
        }else{
            return "两次密码不一致";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
