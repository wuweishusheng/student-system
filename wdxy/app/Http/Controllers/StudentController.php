<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Classs;
use App\User;
use App\Liuji;
class StudentController extends Controller
{

    private $rules = [
            'name' => 'required|max:255',
        ];
    private $message = [
            'name.required'=>'名字是必填项',
        ];

    public function verify($classid){
        //获取登陆用户的id
        $id = Auth::id();
        //查询班主任基本信息
        $users = User::find($id);
        //获取班主任管理的班级
        $class = $users->class;
        $class = trim($class,"#");
        $arr = explode("#", $class);

        if (in_array($classid, $arr)) {
            return 0;
        }else{
            return 1;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //验证班主任和班级的对应关系
        if ($this->verify($id)) {
            return view("404",['message'=>"你好像不是这个班的班主任哦"]);
        }
        
        //遍历首页
        $num = Student::where('classid', $id)->count();
        $class = Classs::where('id', $id)->first();
        $moreclass = Classs::orderBy('classid')->get();
        $stu = Student::where('classid', $id)->get();
        return view('student', ['stu' => $stu,'class'=>$class,'num'=>$num,'moreclass'=>$moreclass]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //跳转添加页面
        return view('stu/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //执行添加
        //表单验证
        //$this->validate($request,$this->rules,$this->message);
        $Student = new Student;
        $Student->name = $request->name;
        $Student->sex = $request->sex;
        $Student->shenfenzheng = $request->shenfenzheng;
        $Student->iphone = $request->iphone;
        $Student->jphone = $request->jphone;
        $Student->address = $request->province.$request->city.$request->county.$request->s_address;
        $Student->classid = $request->classid;
        $Student->save();
        return redirect()->route('profile', ['classid' => $request->classid]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function liuji(Request $request)
    {
        //留级
        $Student = Student::find($request->id);
        $Student->classid = $request->moreclass;
        $Student->save();
        //记录操作历史
        $Liuji = new Liuji;
        $Liuji->sid = $request->id;
        $Liuji->tid = Auth::id();
        $Liuji->from = $request->classid;
        $Liuji->to = $request->moreclass;
        $Liuji->reason = $request->reason;
        $Liuji->time = $request->time;
        $Liuji->save();
        return redirect()->route('profile', ['classid' => $request->classid]);
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
        //修改
        $Student = Student::find($request->id);
        $Student->name = $request->name;
        $Student->sex = $request->sex;
        $Student->shenfenzheng = $request->shenfenzheng;
        $Student->address = $request->address;
        $Student->iphone = $request->iphone;
        $Student->jphone = $request->jphone;
        $Student->save();
        return redirect()->route('profile', ['classid' => $request->classid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //删除学生
        Student::destroy($request->id);
        //return redirect()->action('StudentController@index', [$request->classid]);
    }   
}
