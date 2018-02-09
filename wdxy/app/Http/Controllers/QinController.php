<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Classs;
use App\User;
use App\Qin;
use App\Liuji;
class QinController extends Controller
{


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
     * 查询班级的考勤信息并遍历到首页(任何人都有权限)
     * 
     * @param  班级id
     * @return 班级人员及考勤信息
     */
  public function index(Request $request)
    {	
    	$id = $request->id;
    	//验证班主任和班级的对应关系 未应用
        if ($this->verify($id)) {
            $quan = "1";
        }else{
        		$quan = "0";
        }

      ###  初始 ####
      $classjia = 0 ;
      $classkuang = 0 ;
      $classchi = 0 ;
      $classtui = 0 ;
      $yuejia = 0 ;
      $yuekuang = 0 ;
      $yuechi = 0 ;
      $yuetui = 0 ;

    	//设置区间查询搜索条件 , 默认区间为"2017-01-01-现在";
			$qujian = [];
    	if ($request->qujian) {
    		 $qujian = explode(" - ",$request->qujian);
    	}else{
    		$qujian[0] = "2017-01-01";
    		$qujian[1] = date("Y-m-d");
    	}



    	$starttime = date_format(date_create($qujian[0]),"Y-m-d");
			$finishtime = date_format(date_create($qujian[1]),"Y-m-d");
			// $zhou = date_format(date_create($qujian[0]),"m,d,Y");
			// //验证时间是否合法
			// dd(checkdate(01,01,2017));
			// dd( strtotime("2017-01-49"));



			$where[] = ["created_at",">",$starttime];
      $where[] = ["created_at","<",$finishtime];


      // 本月的搜索条件
      $date = date('Y-m-d'); //当前时间
    	$firstday = date('Y-m-01', strtotime($date));
    	$where1[] = ["created_at",">",$firstday];
  		$where1[] = ["created_at","<",$date];



      //遍历首页
      $num = Student::where('classid', $id)->count();
      $class = Classs::where('id', $id)->first();
      $stu = Student::where('classid', $id)->get()->toArray();


      // 查询每个学生对应的考勤并组合 出个人考勤情况 和 班级总的考勤情况 
      foreach ($stu as $k => $v) {

        	//个人考勤情况 -- 并压入数组
        	$stu_qin = Qin::where("stuid",$v['id'])
        									->where($where)
        	                ->get()
        	                ->toArray();
        	$stu[$k]['qin'] = $stu_qin; //具体的考勤情况
        	$stu_qincon = $this->QinDetails($stu_qin); //计算个人考勤
        	$stu[$k]['jia'] = $stu_qincon['jia'];
        	$stu[$k]['kuang'] = $stu_qincon['kuang'];
        	$stu[$k]['chi'] = $stu_qincon['chi'];
        	$stu[$k]['tui'] = $stu_qincon['tui'];
        	$stu[$k]['liu'] = $stu_qincon['liu'];
        	$time = date("Y-m-d");
        	// 获取在校天数存入数组
        	$zong = $this->getdays($v["created_at"],$time);
        	$stu[$k]['zong'] = $zong;


        	// 班级总的请假旷课迟到早退情况
        	$stu_qin1 = Qin::where("stuid",$v['id'])
        	                ->get()
        	                ->toArray();
        	$stu_qincon1 = $this->QinDetails($stu_qin1);
        	$classjia += $stu_qincon1['jia'];
        	$classkuang += $stu_qincon1['kuang'];
        	$classchi += $stu_qincon1['chi'];
        	$classtui += $stu_qincon1['tui'];

        	//班级本月的考勤情况
        	$stu_qin2 = Qin::where("stuid",$v['id'])
        									->where($where1)
        	                ->get()
        	                ->toArray();
        	$stu_qincon2 = $this->QinDetails($stu_qin2);
        	$yuejia += $stu_qincon2['jia'];
        	$yuekuang += $stu_qincon2['kuang'];
        	$yuechi += $stu_qincon2['chi'];
        	$yuetui += $stu_qincon2['tui'];


      }

        ####  班级总的具体考勤数并入$class中  ####
        $class->classjia = $classjia;
        $class->classkuang = $classkuang;
        $class->classchi = $classchi;
        $class->classtui = $classtui;


        ####   班级课程进度 与 总的考勤情况 与 月的考勤情况   #####
				$time = date("Y-m-d");
        $zong1 = $this->getdays($class->starttime,$class->finishtime);  //班级课程总天数
        $zong2 = $this->getdays($class->starttime,$time);    //班级课程到现在的天数
        $zong3 = $this->getdays($firstday,$date);    //班级课程到现在的天数
        $class->ke = $zong1; //课程天数
        $class->jin = round($zong2/$zong1*100,2)."%" ;  //课程进度 = 上课数 / 总课数
        $class->classzong= $classjia+ $classkuang+ $classchi+ $classtui; //班级总情况
        $class->shigu = round($class->classzong/$zong2*100,2)."%" ;  //事故率 	

        $class->yuezong = $yuejia+ $yuekuang+ $yuechi+ $yuetui; //班级本月情况
        $class->yueshigu = round($class->yuezong/$zong3*100,2)."%" ;  //本月事故率
      	// dd($class->yueshigu);
      
      ###  获取最新考勤情况  ###
      $qin = Qin::where("classid",$id)->orderBy('created_at', 'desc')->get();       

      ######  今日状况  ######
       $timenow = date("Y-m-d");
       $today = Qin::where("classid",$id)->where("created_at","like","%".$timenow."%")->get();

       $today->count = count($today);
       ######  今日状况结束  ######

      ####  连续满员天数开始  ####
      $qin1=Qin::where("classid",$id)->orderBy('created_at', 'desc')->get()->toArray();
      if (!empty($qin1)) {
      	$a = substr($qin1[0]["created_at"],0,10);

      }else{
      	$a = $class->starttime;
      }
      $lian = $this->getdays($a,$timenow);
			$today->lian = $lian-2;
			####  连续满员天数结束  ####
			
		
      return view('qin', ['stu' => $stu,'class'=>$class,'num'=>$num,'quan'=>$quan,'qin'=>$qin,'today'=>$today,'qujian'=>$qujian]);
    }

		/*
		| Author: Yang Yu <niceses@gmail.com>
		| @param char|int $start_date 一个有效的日期格式，例如：20091016，2009-10-16
		| @param char|int $end_date 同上
		| @return 给定日期之间的工作日天数
		*/
			function getdays($start_date,$end_date){
				$start_date =	substr($start_date,0,10);
				$end_date =	substr($end_date,0,10);
				if (strtotime($start_date) > strtotime($end_date)) list($start_date, $end_date) = array($end_date, $start_date);
				$start_reduce = $end_add = 0;
				$start_N = date('N',strtotime($start_date));
				$start_reduce = ($start_N == 7) ? 1 : 0;
				$end_N = date('N',strtotime($end_date));
				in_array($end_N,array(6,7)) && $end_add = ($end_N == 7) ? 2 : 1;
				$alldays = abs(strtotime($end_date) - strtotime($start_date))/86400 + 1;
				
				//date_diff 要用到时间对象,会比较麻烦,不如直接计算
				$weekend_days = floor(($alldays + $start_N - 1 - $end_N ) / 7) * 2 - $start_reduce + $end_add;

				$workday_days = $alldays - $weekend_days;
				return $workday_days;
			}

	    /**
     * 公共方法
     * 每个学生的考勤情况
     * @param  考勤信息集合 
     * @return jia ,kuang,chi,tui ,liu 的数组
     */
    public function QinDetails($stu_qin)
    {
 					$arr=[]; //分开后的数组
  	    	$stu_qincon['jia'] = 0;		//请假次数
		    	$stu_qincon["kuang"] = 0;		//旷课次数
		    	$stu_qincon['chi'] = 0;		//迟到次数
		    	$stu_qincon['tui'] = 0;		//早退次数
		    	$stu_qincon['liu'] = 0;		//留级次数
        	//将每个字段独立分开,将jia.kuang.chi.tui.加入$stu
        	//type字段为请假种类:1- 请假,2- 旷课,3- 迟到,4-早退 ,5-留级
        	//time字段为请假时间段: 1-上午,2-下午,3-晚上,4-全天
        	
        	foreach ($stu_qin as $k1 => $v1) {
        		$arr = array_merge_recursive($arr,$v1);
        	}
       
        	if (!empty($stu_qin)) {
        		for ($i=0; $i < count($arr['type']); $i++) {  //$collection = collect([1, 2, 3, 4]);$collection->count();
        			switch (count($arr['type'])==1?$arr["type"]:$arr["type"][$i]) {
	        			case '请假':
	        				if ($arr['time'][$i]=="全天") {
	        					$stu_qincon['jia'] += 3;
	        				}else{
	        					$stu_qincon['jia'] +=1;
	        				}
	        				break;
	        			case '旷课':
	        				$stu_qincon['kuang'] +=1;
	        				break;
	        			case '迟到':
	        				$stu_qincon['chi'] +=1;
	        				break;
	        			case '早退':
	        				$stu_qincon['tui'] +=1;
	        				break;
	        			case '留级':
	        				$stu_qincon['liu'] +=1;
	        				break;
	        		}
        		}
        	} 
        	return $stu_qincon;
    }


		/*
		| Author:周帅<niceses@gmail.com>
		| @param  学生id
		| @return 单个学生的考勤信息
		*/
	  public function show(Request $request)
    {
        //学分详情
        $qin = QIn::where('stuid', $request->id)->orderBy('created_at','desc')->get();

        $str = <<<EOF
        <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>原因</th>
                                    <th>课段</th>
                                    <th>备注</th>
                                    <th>时间</th>
                                </tr>
                            </thead>
                            <tbody>
EOF;
        foreach ($qin as $k => $v) {
            $str .= "<tr><td>{$v->type}</td><td>{$v->time}</td><td>{$v->beizhu}</td><td>{$v->created_at}</td></tr>";
        }
        $str .= "</tbody></table></div></div>";

        return $str;
    }

		/*
		| Author: 周帅<niceses@gmail.com>
		| @param  学生id
		| @return 学生的留级信息
		*/
	  public function liuinfo(Request $request)
    {
        //留级详情
        $qin = Liuji::where('sid', $request->id)->orderBy('created_at','desc')->get();

        $str = <<<EOF
        <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>来自班级</th>
                                    <th>去往班级</th>
                                    <th>留级原因</th>
                                    <th>执行老师</th>
                                    <th>留级时间</th> 
                                </tr>
                            </thead>
                            <tbody>
EOF;
        foreach ($qin as $k => $v) {
            $str .= "<tr><td>{$v->from}</td><td>{$v->to}</td><td>{$v->reason}</td><td>{$v->tid}</td><td>{$v->created_at}</td></tr>";
        }
        $str .= "</tbody></table></div></div>";

        return $str;
    }

    /**
     * 添加考勤信息
     *
     * @param  form提交表单
     * @return 刷新到考勤主页 
     */
    public function update(Request $request)
    {
        $Qin = new Qin;
        $Qin->tid = Auth::id();
        $Qin->stuid = $request->stuid;
        $Qin->classid = $request->classid;
        $Qin->type = $request->type;
        $Qin->time = $request->time;
        $Qin->beizhu = $request->beizhu;
        $Qin->save();
        return redirect()->action('QinController@index', ['classid' => $request->classid]);
    }

    /**
     * 删除考勤信息
     *
     * @param  考勤信息id
     * @return 0,1 /
     */
    public function delete(Request $request)
    {
    		Qin::destroy($request->id);
    }




}
?>