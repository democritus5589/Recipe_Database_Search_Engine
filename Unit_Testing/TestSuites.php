<?php

require_once 'TEST_db_recipes.php';
require_once 'PHPUnit.php';

class TestSuites
{
	function runAllTests()
	{
		echo "<h3>Recipe Tests</h3>";
		TestSuites::runRecipeTests();
	}
	
	function runRecipeTests()
	{
		$suite = new PHPUnit_TestSuite("TEST_db_recipes");
		$result = PHPUnit::run($suite);

		echo	"<pre>".$result -> toString()."</pre>";
	}
}

//TestSuites::runAllTests();
?>