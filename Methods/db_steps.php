<?php

class db_steps
{
	// insert steps
	function insert_steps($rid, $description, $order_num)
	{
		$query = "INSERT INTO steps (rid, description, order_num) "
			. "VALUES ($rid, '$description', $order_num);";
			
		$sid = db_connect::run_query($query);
		return $sid;
	}

	// insert array of steps
	function insert_steps_by_array($rid, $descriptions)
	{	
		$query;
		$sid_array = array();

		for ($i = 0; $i < count($descriptions); $i++)
		{
			$query = "INSERT INTO steps (rid, description, order_num) "
					. "VALUES ($rid, '$descriptions[$i]', $i);";
					
			array_push($sid_array, db_connect::run_query($query));
		}
		
		return $sid_array;
	}
	
	// get steps by rid
	function get_steps_by_rid($rid)
	{
		$query = "SELECT s.description, s.order_num "
			. "FROM steps s "
			. "WHERE "
			. "s.rid = $rid "
			. "ORDER BY(s.order_num);";
			
		$result_table = db_connect::run_query($query);
		return $result_table;
	}

}


?>