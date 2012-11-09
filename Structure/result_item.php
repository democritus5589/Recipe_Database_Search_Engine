<!doctype html>

<?php

class result_item
{
	private $rid;
	private $name;
	private $rating;
	private $cook_time;
	private $ingredient_list;
	private $description;
	private $image;
	private $caption;
	private $debug;

	
	function __construct($recipe_info, $ingredients, $rating, $image)
	{
		$this->debug = false;

		//	recipe info: rid, name, description
		$row 			=	mysqli_fetch_row($recipe_info);
		$this->rid		=	$row[0];
		$this->name		=	$row[1];
		$this->description	=	$row[2];
		if ($debug)
		{
			echo "recipe_lengh_count: _".count($row)."_<br />";
			echo "result_item_recipe_row[0]: _".$row[0]."_<br />";
			echo "result_item_recipe_row[1]: _".$row[1]."_<br />";
			echo "result_item_recipe_row[2]: _".$row[2]."_<br />";
		}
		
		
		//	ingredients: iid, name
		$this->ingredient_list	=	$ingredients;

		if ($debug)
		{
			echo "absolution<br /><br />";
		}
		$row	=	mysqli_fetch_row($this->ingredient_list);
			
		if ($debug)
		{
			echo "hello<br ?>";
			echo "ingred_count: _".count($row)."_<br />";
			echo "result_item_ingred_row[0]: _".$row[0]."_<br />";
			echo "result_item_ingred_row[1]: _".$row[1]."_<br />";
			echo "result_item_ingred_row[2]: _".$row[2]."_<br />";
		}
		//	rating: avg value
		$row		=	mysqli_fetch_row($rating);
		$this->rating	=	$row[0];
		
		//	image: pid, file, caption
		$row		=	mysqli_fetch_row($image);
		$this->image	=	$row[1];
		$this->caption	=	$row[2];
	}
	
	function display_item()
	{
		echo		"<!-- Result Item Container -->" 
				. "<div id=\"single_result_item_container\" style=\"background-color:#FFAAEE; width:90%; height:350px; margin:10px auto;\"> "
//				. "<div id=\"single_result_item_container\" style=\"background-color:#FFAAEE; width:100%;\"> "					
            		
					. "<!-- Header --> "
					. "<div id=\"item_header_container\" style=\"background-color:#00AAEE; width:95%; height:75px; margin:2%;\"> "
//					. "<div id=\"item_header_container\" style=\"background-color:#00AAEE; width:95%; margin:2% auto;\"> "						
						
						. "<!-- Name --> "
						. "<div id=\"item_name_container\" style=\"background-color:#FC6; width:60%; margin:2%; float:left;\"> "
							. "Name: ". $this->name
						. "</div> "
					
						. "<!-- Rating --> "
						. "<div id=\"item_rating_container\" style=\"background-color:#0F3; width:15%; margin:1%; float:left;\"> "
							. "Rating: ". $this->rating
						. "</div> "
						
						. "<!-- Time --> "
						. "<div id=\"item_time_container\" style=\"background-color:#966; width:15%; margin:1%; float:right;\"> "
							. "Cook_time: ". $this->cook_time
						. "</div> "
					. "</div> "	// end header
					
					. "<!-- Content --> "
//					. "<div id=\"item_content_container\" style=\"background-color:#AA00EE; width:50%; height:250px; margin:2%; float:left;\"> "
					. "<div id=\"item_content_container\" style=\"background-color:#AA00EE; width:50%; margin:2%; float:left;\"> "							
						. "<!-- Ingredient List --> "
						. "<div id=\"ingredient_list_container\" style=\"background-color:#999; width:95%; margin:2% auto;\"> "
							. "Ingredients: <br /><br />";
			
							while ($ingredient = mysqli_fetch_row($this->ingredient_list))
							{	
						//		if (count($this->ingredient_list) > 0)
						//		{
									echo "-".$ingredient[0]."<br />";
						//		}
						//		else
						//		{
						//			echo "No ingredients listed.";
						//		}
							}
							
		echo				"</div> "
					
						. "<!-- Description -->"
						. "<div id=\"result_description_container\" style=\"background-color:#FFBE9F; width:95%; margin:2% auto;\">"
							. "Description: <br /><br />". $this->description
						. "</div>"
					. "</div>"	// end content
						
					. "<!-- Image -->"
//					. "<div id=\"item_image_container\" style=\"background-color:#EEEE00; width:40%; height:250px; margin-right:2%; float:right; max-height:400px;\">"
					. "<div id=\"item_image_container\" style=\"background-color:#EEEE00; width:40%;  margin-right:2%; float:right;\">"							
						. "<img src=\"". $this->image ."\" width=\"100%\" alt=\"". $this->caption ."\" style=\"max-height:200px; max-width:200px;\">"
					. "</div>"
							
						
				. "</div>";	// end container

	}
}
/* *
?>

<html>

	<head>
		<meta charset=\"utf-8\">
		<title>Result_Item_Template</title>
	</head>

	<body>
		<!-- something is messing up the layout, doesnt seem to be the margins -->
        <?php echo result_item::display_item(); ?>
        <br />
        <br />
        <?php echo result_item::display_item(); ?>
	</body>
</html>
<?php
/*  */
?>