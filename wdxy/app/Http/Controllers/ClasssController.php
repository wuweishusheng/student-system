<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classs;
use App\User;
class ClasssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //新增班级
        $classs = new Classs;
        $classs->classid = $request->classid;
        $classs->starttime = $request->starttime;
        $classs->finishtime = $request->finishtime;
        $classs->save();
        //获取刚插入的班级id
        $newclass = $classs->id;
        //添加班级到班主任的班级
        $user = User::find($request->tid);
        $class = $user->class;
        $str = $class.$newclass."#";
        $user->class = $str;
        $user->save();
        return view('classadd',['tid'=>$request->tid]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //执行更新
        $classs = classs::find($request->id);
        $classs->status = $request->status;
        $classs->starttime = $request->starttime;
        $classs->finishtime = $request->finishtime;
        $classs->save();
        return redirect()->route('profile', ['classid' => $request->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //显示新增班级页面
        return view('classadd',['tid'=>$id]);
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
    public function update(Request $request, $id)
    {
        //
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
