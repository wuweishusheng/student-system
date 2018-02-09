<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Score;
use App\Student;
class ScoreController extends Controller
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
    public function show(Request $request)
    {
        //学分详情
        $score = Score::where('sid', $request->id)->orderBy('time','desc')->get();

        $str = <<<EOF
        <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>分数</th>
                                    <th>原因</th>
                                    <th>时间</th>
                                    <th>执行老师</th>
                                </tr>
                            </thead>
                            <tbody>
EOF;
        foreach ($score as $k => $v) {
            $str .= "<tr><td>{$v->num}</td><td>{$v->reason}</td><td>{$v->time}</td><td>{$v->tid}</td></tr>";
        }
        $str .= "</tbody></table></div></div>";

        return $str;
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
        //更新学分
        $Student = new Student;
        Student::where('id', $request->id)->increment('score',$request->num);
        //记录操作历史
        $Score = new Score;
        $Score->sid = $request->id;
        $Score->tid = Auth::id();
        $Score->num = $request->num;
        $Score->reason = $request->reason;
        $Score->time = $request->time;
        $Score->save();
        return redirect()->route('profile', ['classid' => $request->classid]);
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
