<?php

class db_ratings
{
	function get_average_rating($rid)
	{
		$query	= "SELECT AVG(rating) "
			. "FROM ratings rat "
			. "WHERE "
			. "rat.rid = $rid;";
			
		return db_connect::run_query($query);
	}
}

?>