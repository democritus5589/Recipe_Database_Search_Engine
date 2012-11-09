<!doctype html>
<?php


	//	Include Files
	require("../Methods/db_connect.php");
	require("../Methods/db_ingredients.php");
	require("../Methods/db_recipes.php");
	require("../Methods/db_ratings.php");
	require("../Methods/db_images.php");
	include("./result_item.php");

	db_connect::conn();
	
	/***************************************************************************/
	$debug = false;
	$display_null_results = false;
	
	//	Retrieve user input and preprocess
	$words = prepTextForSearch($_GET['search']);
	
	if ($debug)
		echo "words_count: _".count($words)."_<br />";
	
	//	Search for ingredient by name
	$ingredient_ids = array();		//	array of iids
	foreach ($words as $word)
	{
		if ($debug)
			echo "word: _".$word."_<br />";
		
		$iid_array	=	db_ingredients::get_ingredients_by_name($word);
		
		if ($debug)
		echo "iid_array_count: _".count($iid_array)."_<br />";
		
		
		while($row	=	mysqli_fetch_row($iid_array))
		{
			array_push($ingredient_ids, $row[0]);
		}

		if ($debug)
			echo "ingredient_ids_count: _".count($ingredient_ids)."_<br />";
//		array_push($ingredient_ids, db_ingredients::get_ingredients_by_name($word));
	}
	
	if (count($ingredient_ids) > 0)
	{
	
		//	Search for recipes using ingredients
		$recipe_ids = db_recipes::find_recipes_using_any_ingredient($ingredient_ids);	//	no duplicates returned
		
		if ($debug)
			echo "recipe_ids_count: _".count($recipe_ids)."_<br />";
		
		//	Order results by frequency of ingredients and remove duplicates (if necessary)
		//$recipe_ids	=	sortRecipesByIngredFreq($recipe_ids, $ingredient_ids);
		
		if ($debug)
			echo "recipe_ids_count: _".count($recipe_ids)."_<br />";
		
		//	Retrieve recipe information
		$result_item_array	=	array();
	//	foreach ($recipe_ids as $rid)
		while ($row = mysqli_fetch_row($recipe_ids))
		{
			$rid = $row[1];
			
			//	Recipe:		name, description
			$recipe_info	=	db_recipes::get_recipe_info($rid);	//	rid, name, description
			
			if ($debug)
				echo "recipe_info_count: _".count($recipe_info)."_<br />";
			
			//	Ingredients:	name
			$ingredients	=	db_ingredients::get_ingredients_by_rid($rid);	//	iid, name

			if ($debug)
				echo "ingredients_count: _".count($ingredients)."_<br />";
			
	
			//	Ratings:	average
			$rating		=	db_ratings::get_average_rating($rid);	//	AVG(rat.value)
	
			if ($debug)
				echo "rating_count: _".count($rating)."_<br />";
			
			//	Images:		file
			$image		=	db_images::get_image_by_rid($rid);	//	pid, file, caption
			
			if ($debug)
				echo "image_caption: _".$image->caption."_<br />";
			
			$result_item	=	new	result_item($recipe_info, $ingredients, $rating, $image);
	
			array_push($result_item_array, $result_item);
	
			if ($debug)
				echo "result_item_array_count: _".count($result_item_array)."_<br />";
		}
	}
	
	else
	{
		$display_null_results = true;
	}
	
//	foreach ($result_item_array as $item)


	function prepTextForSearch($user_input)
	{
		//	Variables
		$split_input;
		$return_array	=	array();
		
		//	trim whitespace from beginning and end
		
		//	parse using the following characters: 	':' (colon) ',' (comma)
		$split_input=	preg_split("/[:,]/", $user_input);
		
		//	for each parsed word, trim white space to min
		foreach ($split_input as $word)
		{
			$split_word	=	preg_split('/\s/', $word);
			$new_word	=	$word;//null;
			//	for each word, remove all whitespace and recombine with one space
	/*		foreach ($split_word as $split)
			{
				if (strlen($split) > 0)
				{
					$new_word .= " ".$split;
				}
			}
	*/		
			//	Add revised word to end of array
			array_push($return_array, $new_word);
		}

		//	return array with one word per element
		return $return_array;
	}
	
	function sortRecipesByIngredFreq($rid_array, $iid_array)	//	needs optimization
	{
		$recipe_count	=	array();
		
		//	for each recipe...
		foreach ($rid_array as $rid)
		{
			//	find ingredient list
			$ingredient_array	=	db_ingredients::get_ingredients_by_rid($rid);
			
			//	count number of ingredients from iid_array are included
			$ingred_count	=	0;
			foreach ($iid_array as $iid)
			{
				if (in_array($iid, $ingredient_array))
				{
					$ingred_count++;
				}
			}
			$recipe_count[$rid]	=	$ingred_count;
		}
		
		//	sort rid values by iid_count
		asort($recipe_count);
		
		//	return sorted array of rid values using keyset
		return array_keys($recipe_count);
	}
	

	

?>

<html>
	
    <head>
		<meta charset="utf-8">
		<title>Results_Page_Template</title>
	</head>

	<body>
    
    	<!-- page container -->
        <div id="results_page_container" style="background-color:yellow; width:100%;">
        
            <!-- header -->
            <div id="results_header_container" style="background-color:blue; width:100%;">
            	<form action="results_page.php" method="GET">
                <div align="center"><br><font color="#fff">Search:</font> <input type="text" size="50" name="search" value="<?php echo $_GET['search']; ?>" /> <input type="submit" class="submit-button" value="Search"/>
                </form>
                </div>
                <br />
            </div>
            
            <!-- Content -->
            <div id="results_content_container" style="background-color:purple; width:100%; height:3150px;">
            
                <!-- basic bar -->
                <div id="results_basic_bar_container" style="background:orange; width:20%; height:3150px; float:left; margin:auto">
                    <!-- basic bar text -->
                </div>
                
                <!-- results container -->
                <div id="result_items_container" style="background-color:white; width:60%; height:3150px; float:left; margin:auto">


<?php

	for ($i = 0; $i < count($result_item_array); $i++)
	{
		if ($dispaly_null_results)
		{
			echo "No results found.";
		}
		else
		{
			$result_item_array[$i]->display_item();
		}
	}

?>
                    
                </div>
                
                <!-- advanced bar -->
                <div id="results_advanced_bar_container" style="background-color:green; width:20%; height:1450px; float:right; margin:auto">
                    <!-- advanced bar text -->
                </div>
			</div>
            
            <!-- footer -->
            <div id="results_footer_container" style="background-color:#AA0000; width:100%; height:30px;">
            	<!-- footer text -->
            </div>
        
        </div>
    
	</body>
</html>