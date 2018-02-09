<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Qin extends Model
{
    protected $table = 'qin';

    public function getstuidAttribute($value)
    {
        $user = DB::table('students')->where('id', $value)->first();
        return $user->name;
    }
    /*
    	qin => type: 1 - 请假,  2 - 旷课,  3 - 迟到,  4 - 早退 , 5 -留级
     */
    public function gettypeAttribute($value)
    {
        switch ($value) {
        	case '1':
        		return "请假";
        		break;
        	case '2':
        		return "旷课";
        		break;
        	case '3':
        		return "迟到";
        		break;
        	case '4':
        		return "早退";
        		break;
        	case '5':
        		return "留级";
        		break;
        }
    }
    /*
    	qin => time: 1 - 上午,  2 - 下午,  3 - 晚上,  4 - 全天
     */
    public function gettimeAttribute($value)
    {
        switch ($value) {
        	case '1':
        		return "上午";
        		break;
        	case '2':
        		return "下午";
        		break;
        	case '3':
        		return "晚上";
        		break;
        	case '4':
        		return "全天";
        		break;
        }
    }

}
