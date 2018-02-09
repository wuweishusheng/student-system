<?php

namespace App\Http\Controllers;
use DB;
//科目信息
class SubjectController extends Controller
{
    //科目信息修改
    public function xiugai()
    {
        $info=DB::table('test')->where('id',$_POST['id'])->update($_POST);
    	return redirect("/grade/grade/{$_POST['classid']}");
    }
    //科目信息验证
    public function subject(){
        $arr = array();
        $kemu=DB::table('test')->where('classid',$_POST['classid'])->pluck('subject');
        foreach ($kemu as $key => $value) {
            $arr[] .= $value;
        }
        if (in_array($_POST['kemu'], $arr)) {
            return 1;
        }else{
            return 2;
        }
    }
    // 新增科目
    public function add(){
        $subjectid = Db::table("test")->insertGetId($_POST);
        $studentid = Db::table("students")->where("classid",$_POST['classid'])->pluck("id");
        foreach ($studentid as $k => $v) {
            DB::table("grade")->insert(['subjectid'=>$subjectid,'studentid'=>$v,'grade'=>'']);
        }
        return redirect("/grade/grade/{$_POST['classid']}");
    }






}
