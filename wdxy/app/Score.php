<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Score extends Model
{
    //

    protected $table = 'score';

    //tid转换人名
 	public function gettidAttribute($value)
	{
		$user = DB::table('users')->where('id', $value)->first();
		return $user->name;
	}

	//sid转换人名
	public function getsidAttribute($value)
	{
		$stu = DB::table('students')->where('id', $value)->first();
		return $stu->name;
	}
}