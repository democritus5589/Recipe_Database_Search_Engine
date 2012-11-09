<!doctype html>

<!-- PHP Code -->
<?php

	include("../Methods/db_connect.php");
	include("../Methods/db_recipes.php");
	include("../Methods/db_ingredients.php");
	include("../Methods/db_steps.php");
	include("../Methods/db_is_used_in.php");


	// insert into recipe
	$name = $_GET['name'];
	$description = $_GET['description'];
	$ingred_name_array = array($_GET['i1']);
	$uid = 4;
	$steps_array = array();
	array_push($steps_array, "push");//$_GET['step01']);//, $_GET['step02']);
	$iid_array = array();
	
	if ((strlen($name) == 0) || (strlen($description) == 0) || (strlen($uid) == 0) || (count($name_array) == 0) || (count($steps_array) > 0))
	{

		$rid = db_recipes::insert_recipe($name, $description, $uid);
		
		// insert into ingredients
		$iid_array = db_ingredients::insert_ingredients_by_array($ingred_name_array);

		// insert into steps
		db_steps::insert_steps_by_array($rid, $steps_array);

		// insert into is_used_in
		db_is_used_in::insert_used_in($rid, $iid_array);
		
	}
?>

<!-- HTML Code -->
<html>

	<head>
	
	</head>
	
	<body>
	
		<!-- New Recipe Form -->
		<form id="form1">
        	Name<br />
            <input type="text" name="name" value="<?php echo $_GET['name']; ?>"><br />
			Description<br />
			<textarea rows="4" cols="20" form="form1" name="description" value="<?php echo $_GET['description']; ?>" maxlength="1000">Default Text</textarea>
			<br />
			Recipe Steps<br />
			
			<?php /*
				TODO: 
				- make into a php method
				- allow step fields to be added dynamically
				- Verify that text does not contain MYSQL query attacks
				*/
				?>
			<textarea rows="4" cols="20" form="form1" name="step01" value="<?php echo $_GET['step01']; ?>" maxlength="1000">Step 1 description goes here.</textarea><br />
			<textarea rows="4" cols="20" form="form1" name="step02" value="<?php echo $_GET['step02']; ?>" maxlength="1000">Step 2 description goes here.</textarea><br />
			<textarea rows="4" cols="20" form="form1" name="step03" value="<?php echo $_GET['step03']; ?>" maxlength="1000">Step 3 description goes here.</textarea><br />
			<textarea rows="4" cols="20" form="form1" name="step04" value="<?php echo $_GET['step04']; ?>" maxlength="1000">Step 4 description goes here.</textarea><br />
			<textarea rows="4" cols="20" form="form1" name="step05" value="<?php echo $_GET['step05']; ?>" maxlength="1000">Step 5 description goes here.</textarea><br />
			<textarea rows="4" cols="20" form="form1" name="step06" value="<?php echo $_GET['step06']; ?>" maxlength="1000">Step 6 description goes here.</textarea><br />
			<textarea rows="4" cols="20" form="form1" name="step07" value="<?php echo $_GET['step07']; ?>" maxlength="1000">Step 7 description goes here.</textarea><br />
		
			
			<?php	/*
				TODO:
				- Make button display more step fields
				*/
				?>
			<input type="button" name="b1" value="Add Step"><br />
			<br />
			
			Ingredients<br />
			<?php	/*
				TODO:
				- make into a php method
				- allow ingredient fields
				- search for ingredient on text entry and offer to create new ingredient if not found (by displaying msg and add button)
				- change background color or show some sign to indicate that the ingredient was found
				*/
				?>
			
			<input type="text" name="i1" value="<?php echo $_GET['i1']; ?>"><input type="button" name="b2" value="add"><br />
			<input type="text" name="i2" value="<?php echo $_GET['i2']; ?>"><input type="button" name="b3" value="add"><br />
			<input type="text" name="i3" value="<?php echo $_GET['i3']; ?>"><input type="button" name="b4" value="add"><br />
			<input type="text" name="i4" value="<?php echo $_GET['i4']; ?>"><input type="button" name="b5" value="add"><br />
			<input type="text" name="i5" value="<?php echo $_GET['i5']; ?>"><input type="button" name="b6" value="add"><br />
			<input type="text" name="i6" value="<?php echo $_GET['i6']; ?>"><input type="button" name="b7" value="add"><br />
			<input type="text" name="i7" value="<?php echo $_GET['i7']; ?>"><input type="button" name="b8" value="add"><br />
			<br />
			
			<?php 	/*
				TODO:
				- Make button display more ingredient fields
				*/
				?>
			<input type="button" name="add_ingredients" value="Add Ingredient Fields"><br />
			
			Picture<br />
			
			<?php 	/*
				TODO:
				- make into a php method
				- verify that location specified exists
				- Display picture that will be stored
				*/
				?>
			<input type="button" name="b9" value="Browse..."><br />
		</form>
		
		<!-- New Ingredient Form -->
	
	</body>


</html>