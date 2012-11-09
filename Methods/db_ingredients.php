<?php

class db_ingredients
{


	// get all ingredients
	function get_all_ingredients()
	{
		$query = "SELECT i.name, i.iid "
			. "FROM ingredients i "
			. "WHERE "
			. "i.display = 1;";
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	// get ingredient for specific recipe
	function get_ingredients_by_rid($rid)
	{
		$query = "SELECT i.name, i.iid "
			. "FROM ingredients i, is_used_in u "
			. "WHERE "
			. "u.rid = $rid AND "
			. "u.iid = i.iid AND "
			. "i.display = 1;";
			
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	// get ingredients in user's pantry
	function get_pantry_ingredients($uid)
	{
		$query = "SELECT i.name, i.iid "
			. "FROM ingredients i, pantry p "
			. "WHERE "
			. "p.uid = $uid AND "
			. "p.iid = i.iid AND "
			. "i.display = 1 "
			. "ORDER BY "
			. "i.name;";
			
		$result_table = db_connect::run_query($query);
		return $result_table;
	}

	// get ingredient from name
	function get_ingredients_by_name($name)
	{
		$query = "SELECT i.iid "
			. "FROM ingredients i "
			. "WHERE "
			. "i.name = '$name' AND "
			. "i.display = 1;";
			
		$result_table = db_connect::run_query($query);
		return $result_table;
	}

	// get ingredient from iid
	function get_ingredients_by_iid($iid)
	{
		$query = "SELECT i.iid, i.name "
			. "FROM ingredients i "
			. "WHERE "
			. "i.iid = $iid;";
		
		$result_table = db_connect::run_query($query);
		return $result_table;
	
	}
	
	// insert ingredient
	function insert_ingredient($name)
	{
		$query = "INSERT INTO ingredients (name, display) "
			. "VALUES ('$name', DISPLAY);";
			
		$iid = db_connect::run_query($query);
		return $iid;
	}
	
	// insert ingredients by array
	function insert_ingredients_by_array($name_array)
	{
		$query;
		$iid_array = array();
		/*
		for ($i = 0; $i < count($name_array); $i++)
		{
			$query .= "INSERT INTO ingredients (name, display) "
				. "VALUES ('$name[$i]', DEFAULT); ";
		}
		
		$iid_array = db_connect::run_query($query);
		return $iid_array;
		
		*/
		for ($i = 0; $i < count($name_array); $i++)
		{
			$query = "INSERT INTO ingredients (name, display) "
					. "VALUES ('$name[$i]', DEFAULT);";
					
			array_push($iid_array, db_connect::run_query($query));
		}
		
		return $iid_array;
	}
}
?>
