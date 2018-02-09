<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classs extends Model
{
    //
    use SoftDeletes;

    protected $table = 'class';

    public function getstatusAttribute($value)
	{
		switch ($value) {
			case '0':
					return "正常";
				break;
			case '1':
					return "毕业";
				break;
			default:
				# code...
				break;
		}
		
	}
}