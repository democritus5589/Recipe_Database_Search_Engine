<?php

class db_images
{
	function get_image_by_rid($rid)
	{
		$query	= "SELECT p.pid, p.file, p.caption "
			. "FROM pictures p "
			. "WHERE "
			. "p.rid = $rid;";
			
		return db_connect::run_query($query);
	}
}

?>