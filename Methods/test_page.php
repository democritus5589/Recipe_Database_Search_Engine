<?php

	include("db_ingredients.php");

	$result_table = db_ingredients::get_all_ingredients();
	
	for($i = 0; $i < mysqli_num_rows($result_table); $i++)
	{
		$row = mysqli_fetch_row($result_table);
		
		for ($j = 0; $j < mysqli_num_fields($result_table); $j++)
		{
			echo mysqli_fetch_field_direct($result_table, $j)->name.": ";
			echo $row[$j]."<br/>";
		}
	}

?>