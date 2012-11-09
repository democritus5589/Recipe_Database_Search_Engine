<?php

include_once 'db_connect.php';
include_once 'db_ingredients.php';

class db_recipes
{

	// get all recipes
	function get_all_recipes()
	{
		$query = "SELECT r.name, r.rid "
			. "FROM recipe r "
			. "WHERE "
			. "r.display = 1;";
			
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	// get all recipes containing %query% name
	function find_recipes_by_name($name)
	{
		$query = "SELECT r.name, r.rid "
				. "FROM recipe r "
				. "WHERE "
				. "r.name LIKE '%$name%' AND "
				. "r.display = 1;";
				
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	// get all recipes containing keyword query
	function find_recipes_by_keyword($keyword)
	{
		$query = "SELECT r.name, r.rid "
				. "FROM recipe r, keywords k "
				. "WHERE "
				. "k.keyword = '$keyword' AND "
				. "k.rid = r.rid AND "
				. "r.display = 1;";
				
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	//	all recipes containing ingredient query
	function find_recipes_using_iid($iid)
	{
		$query = "SELECT r.name, r.rid "
				. "FROM recipe r, is_used_in u "
				. "WHERE "
				. "u.iid = $iid AND "
				. "u.rid = r.rid AND "
				. "r.display = 1;";
				
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	//	get all recipes using any of the ingredients
	function find_recipes_using_any_ingredient($iid_array)
	{
		$query = "SELECT r.name, r.rid "
				. "FROM recipe r, is_used_in u "
				. "WHERE "
				. "u.rid = r.rid AND ";
				
				
		if (count($iid_array) > 0)
		{
			$query	.= "(";
			/*
			$i = 0;
			foreach ($iid_array as $iid)
			{
				$query	.= " u.iid = $iid ";
				if (++$i < (count($iid_array) - 1))
				{
					$query .= " OR ";
				}	
			}
			*/
			
			for ($i = 0; $i < count($iid_array); $i++)
			{
				$query .= " u.iid = $iid_array[$i] ";
				if ($i < (count($iid_array) - 1))
				{
					$query .= " OR ";
				}
			}
			
			$query	.= ") AND ";
		}
		
		$query .= "r.display = 1;";
		
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	//	get all recipes not containing ingredient query
	function find_recipes_not_using_iid($iid)
	{
		$query = "SELECT r.name, r.rid "
				. "FROM recipe r "
				. "WHERE "
				. "r.display = 1 AND "
				. "r.rid NOT IN( "
				. 	"SELECT r1.rid "
				. 	"FROM recipe r, is_used_in u "
				. 	"WHERE "
				. 	"u.iid = $iid AND "
				. 	"u.rid = r.rid "
				. ");";
				
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	//	get all recipes not containing any of the ingredients
	function find_recipes_not_using_any_iid($iid_array)
	{
		$query = "SELECT r.name, r.rid "
				. "FROM recipe r "
				. "WHERE "
				. "r.display = 1 AND "
				. "r.rid NOT IN( "
				. 	"SELECT r1.rid "
				. 	"FROM recipe r1, is_used_in u "
				. 	"WHERE "
				. 	"u.rid = r1.rid AND (";
				
		for ($i = 0; $i < count($iid_array); $i++)
		{
			$query .= " u.iid = $iid_array[$i] ";
			if ($i < (count($iid_array) - 1))
			{
				$query .= " OR ";
			}
		}
		
		$query .= "));";
				
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	//	get all recipes using all ingredients from list
	function find_recipes_using_all_ingredients_in_list($iid_array)
	{	
		$query = "SELECT r.name, r.rid "
			. "FROM recipe r, ";
			
		$query_addendum = "WHERE ";
		
		for ($i = 0; $i < count($iid_array); $i++)
		{
			$query .= "is_used_in u_$i";
			if ($i < (count($iid_array) - 1))
			{
				$query .= ", ";
			}
			
			if ($i > 0)
			{
				$prev = $i - 1;
				$query_addendum .= "u_$i.rid == u_$prev.rid AND ";
			}
		}
		$query .= $query_addendum . "r.rid = u_0.rid;";
		
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	// get all recipes containing only ingredients query1 query2 query3
	function find_recipes_using_only_ingredients_from_list($iid_array)
	{
		// find all recipes using all ingredients
		//	find all ingredients for each recipe
		//	remove all recipes containing 
		$query = "";
		
		for ($i = 0; $i < count($iid_array); $i++)
		{
			
		}
		
		$query .= ");";
		
//		$result_table = db_connect::run_query($query);
//		return $result_table;
	}
	
	// get basic recipe info from rid
	function get_recipe_info($rid)
	{
		$query	= "SELECT r.rid, r.name, r.description "
			. "FROM recipe r "
			. "WHERE "	
			. "r.rid = $rid;";
			
		$result_table = db_connect::run_query($query);
		return $result_table;
	}
	
	// insert recipe
	function insert_recipe($name, $description, $uid)
	{
		$query = "INSERT INTO recipe (name, description, uid, date_submitted, display) "
			. "VALUES ('$name', '$description', $uid, CURDATE(), DEFAULT);";
			
		$rid = db_connect::run_query($query);
		return $rid;
	}
	
	//	given a set of recipes and ingredients, sort the recipes by number of ingredients included
	function sortRecipesByIngredientMatchCount($rid_array, $iid_array)
	{
		$ingred_count = array();
	
		//	find all recipes using the specified ingredients
	
		//	for each recipe in the result table...
		foreach($rid_array as $rid)
		{
			//	...find all ingredients used by the recipe...
			$ingred_table = db_ingredients::get_ingredients_by_rid($rid);
			$count = 0;
			
			//	...compare the ingredients used against the input ingredients
			for($i = 0; $i < mysqli_num_rows($ingred_table); $i++)
//			while (($ingred = mysqli_fetch_array($ingred_table)) != null)
			{
				$ingred = mysqli_fetch_array($ingred_table, MYSQLI_BOTH);
				
				//	...count matching ingredients and store in an associative array
				if (in_array($ingred[0], $iid_array))
				{
					$count++;
				}
			}
			
			$ingred_count[$rid] = $count;
		}
		
		//	run arsort on the array
		arsort($ingred_count);
		return $ingred_count;
	}

}

?>