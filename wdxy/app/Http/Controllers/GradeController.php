<?php

namespace App\Http\Controllers;
use DB;
//学生成绩
class GradeController extends Controller
{
    //学生成绩查询
    public function grade($id)
    {
    	$stu = Db::table('students')->where('classid',$id)->get();
        $sub = DB::table('test')->where('classid',$id)->get();
        $chengji = array();
        for ($i=0; $i <count($stu); $i++) {
            $gra = DB::table('grade')->where(['studentid'=>$stu[$i]->id,"state"=>'1'])->get();
            $chengji[$stu[$i]->id]=$gra;
        }
        $count = count($sub);
    	//渲染页面到前台
        return view('grade',[
        	'stu'=>$stu,
            'sub'=>$sub,
            'chengji'=>$chengji,
            'classid'=>$id
        ]);

    }
    //学生成绩添加检查
    public function checkxuehao()
    { 
        $id =$_POST['id'] ;
        $classid = $_POST['classid'];
        $res=Db::table('students')->where('id',$id)->where('classid',$classid)->count();
        if($res){
            return 1;
        }else{
            return "学号不存在";
        }
        
    }
    // 学生历史成绩
    public function chaxunquanbu()
    {
        $id = $_POST['id'];
        //获取到单个学生的所有成绩
        $xinxi = DB::table('grade')->join('test','grade.subjectid','=','test.id')->join('class','class.id','=','test.classid')->where('grade.studentid',$id)->select('grade.grade','test.subject','class.classid')->get();
        return $xinxi;
        
    }
    
    // 添加成绩
    public function add()
    {  // 获取表单信息
        $id = $_POST['id'];
        $subject = $_POST['subject'];
        $grade = $_POST['grade'];
        $classid = $_POST['classid'];
        $subjectid = Db::table('test')->where('classid',$classid)->where('subject',$subject)->pluck('id');
        //给所有学生加成济
        $sss=DB::table('students')->where('classid',$classid)->pluck('id');
        // 如果科目里有，直接加
        if(count($subjectid)>0){
            DB::table('grade')->where(['studentid'=>$id,'subjectid'=>$subjectid[0]])->update(['grade'=>$grade]);
            return redirect("/grade/grade/{$_POST['classid']}");
        }else{
            //科目里创建再添加
            $qwe=DB::table('test')->insertGetId(['subject'=>$subject,'classid'=>$classid]);
            foreach ($sss as $k => $v) {
                DB::table('grade')->insert(['studentid'=>$v,'subjectid'=>$qwe,'grade'=>'']);
            }
            
            DB::table('grade')->where(['studentid'=>$id,'subjectid'=>$qwe])->update(['grade'=>$grade]);
            return  redirect("/grade/grade/{$_POST['classid']}");
            
        } 

    }
    // 修改成绩
    public function xiugai()
    {
        $id=DB::table('test')->where(['subject'=>$_POST['subject'],'classid'=>$_POST['classid']])->pluck('id');
        DB::table('grade')->where(['studentid'=>$_POST['id'],'subjectid'=>$id[0]])->update(['grade'=>$_POST['grade']]);
        return redirect("/grade/grade/{$_POST['classid']}");
    }
    //修改成绩查询科目
    public function chaxunsub()
    {
        $kemu=DB::table('test')->where('id',$_POST['id'])->pluck('subject');
        // dd($kemu);
        return($kemu);
    }

    // 学生成绩删除
    public function shanchu()
    {
        return($_POST['id']);
    }



}
