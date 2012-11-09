<?php

class db_is_used_in
{
	// insert into is_used_in
	function insert_used_in($rid, $iid_array)
	{
		$query;
		
		for ($i = 0; $i < count($iid_array); $i++)
		{
			$query .= "INSERT INTO is_used_in (rid, iid) "
				. "VALUES ($rid, $iid_array[$i]); ";
		}
		
		db_connect::run_query($query);
	}
	
	// get ingredients from rid
	function get_iids($rid)
	{
		$query = "SELECT u.iid "
			. "FROM is_used_in u "
			. "WHERE "
			. "u.rid = $rid;";
		
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	// get recipes from iid
	function get_rids($iid)
	{
		$query = "SELECT u.rid "
			. "FROM is_used_in u "
			. "WHERE "
			. "u.iid = $iid;";
		
		$result_table = db_connect::run_query($query);
		return $result_table;
	}

}

?>