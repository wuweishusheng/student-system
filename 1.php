<?php
		// 表示由数据库返回的可能记录集的数组
		$a = array(
		  array(
		    'id' => 5698,
		    'first_name' => 'Bill',
		    'last_name' => 'Gates',
		  ),
		  array(
		    'id' => 4767,
		    'first_name' => 'Steve',
		    'last_name' => 'Jobs',
		  ),
		  array(
		    'id' => 4770,
		    'first_name' => 'Steve1',
		    'last_name' => 'Jobs',
		  ),
		  array(
		    'id' => 3809,
		    'first_name' => 'Mark',
		    'last_name' => 'Zuckerberg',
		  ),
		  array(
		    'id' => 5680,
		    'first_name' => 'Mark1',
		    'last_name' => 'Zuckerberg',
		  )
		);

		$last_names = array_column($a, 'last_name', 'id');
		echo "<pre>";
		print_r($last_names);
?>