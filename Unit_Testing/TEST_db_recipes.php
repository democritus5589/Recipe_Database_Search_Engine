<?php

require_once '../Methods/db_recipes.php';
require_once 'PHPUnit.php';

class TEST_db_recipes extends PHPUnit_TestCase
{
	//	class variables
	var $result_table;
	
	//	constructor
	function TEST_db_recipes($name)
	{
		$this->PHPUnit_TestCase($name);
	}
	
	//	setup method
	
	//	tearDown method
	function tearDown()
	{
		unset($this->result_table);
	}
	
	//	Testing Get All Recipes
	function testGetAllRecipes()
	{
		$this->result_table = db_recipes::get_all_recipes();
		$expected_names = array( "Pizza Dough", "Peanut Butter and Jelly", "Peanut Butter and Banana", "Ham and Cheese", "BLT", "Peanut Butter and Bacon Sandwich", "Toast", "Toast with Jelly");
		$expected_rids = array( 1, 2, 3, 4, 5, 6, 7, 8 );
		for ($i = 0; $i < count($expected_names); $i++)
		{
			$row = mysqli_fetch_array($this->result_table, MYSQLI_BOTH);
			$this->assertEquals($row[0], $expected_names[$i]);
			$this->assertEquals($row[1], $expected_rids[$i]);
		}
	}
	
	//	Testing	Find Recipes By Name
	function testFindRecipesByName_emptyString()
	{
		$name = "";
		$this->result_table = db_recipes::find_recipes_by_name($name);
		$expected_names = array( "Pizza Dough", "Peanut Butter and Jelly", "Peanut Butter and Banana", "Ham and Cheese", "BLT", "Peanut Butter and Bacon Sandwich", "Toast", "Toast with Jelly");
		$expected_rids = array( 1, 2, 3, 4, 5, 6, 7, 8 );
		for ($i = 0; $i < count($expected_names); $i++)
		{
			$row = mysqli_fetch_array($this->result_table, MYSQLI_BOTH);
			$this->assertEquals($row[0], $expected_names[$i]);
			$this->assertEquals($row[1], $expected_rids[$i]);
		}
	}
	
	function testFindRecipesByName_singleChar()
	{
		$name = "a";
		$this->result_table = db_recipes::find_recipes_by_name($name);
		$expected_names = array( "Pizza Dough", "Peanut Butter and Jelly", "Peanut Butter and Banana", "Ham and Cheese", "Peanut Butter and Bacon Sandwich", "Toast", "Toast with Jelly");
		$expected_rids = array( 1, 2, 3, 4, 6, 7, 8 );
		for ($i = 0; $i < count($expected_names); $i++)
		{
			$row = mysqli_fetch_array($this->result_table, MYSQLI_BOTH);
			$this->assertEquals($row[0], $expected_names[$i]);
			$this->assertEquals($row[1], $expected_rids[$i]);
		}
	}
	
	function testFindRecipesByName_singleNum()
	{
		$name = "1";
		$this->result_table = db_recipes::find_recipes_by_name($name);
		$this->assertEquals(0, mysqli_num_rows($this->result_table));
	}
	
	function testFindRecipesByName_invalidChar()
	{
		$name = "*";
		$this->result_table = db_recipes::find_recipes_by_name($name);
		$this->assertEquals(0, mysqli_num_rows($this->result_table));
	}
	
	function testFindRecipesByName_partialMatch()
	{
		$name = "Peanut";
		$this->result_table = db_recipes::find_recipes_by_name($name);
		$expected_names = array("Peanut Butter and Jelly", "Peanut Butter and Banana", "Peanut Butter and Bacon Sandwich");
		$expected_rids = array( 2, 3, 6 );
		for ($i = 0; $i < count($expected_names); $i++)
		{
			$row = mysqli_fetch_array($this->result_table, MYSQLI_BOTH);
			$this->assertEquals($row[0], $expected_names[$i]);
			$this->assertEquals($row[1], $expected_rids[$i]);
		}
	}
	
	function testFindRecipesByName_uniqueMatch()
	{
		$name = "Toast with Jelly";
		$this->result_table = db_recipes::find_recipes_by_name($name);
		$expected_names = array("Toast with Jelly");
		$expected_rids = array( 8 );
		for ($i = 0; $i < count($expected_names); $i++)
		{
			$row = mysqli_fetch_array($this->result_table, MYSQLI_BOTH);
			$this->assertEquals($row[0], $expected_names[$i]);
			$this->assertEquals($row[1], $expected_rids[$i]);
		}
	}
	
	function testFindRecipesByName_exactMatchAndSubstringMatch()
	{
		$name = "Toast";
		$this->result_table = db_recipes::find_recipes_by_name($name);
		$expected_names = array("Toast", "Toast with Jelly");
		$expected_rids = array( 7, 8 );
		for ($i = 0; $i < count($expected_names); $i++)
		{
			$row = mysqli_fetch_array($this->result_table, MYSQLI_BOTH);
			$this->assertEquals($row[0], $expected_names[$i]);
			$this->assertEquals($row[1], $expected_rids[$i]);
		}
	}
	
	//	Testing find recipes by keyword
	function testFindRecipesByKeyword_validKeywordNoResults()
	{
		$keyword = "cold";
		$this->result_table = db_recipes::find_recipes_by_keyword($keyword);
		$this->assertEquals(0, mysqli_num_rows($this->result_table));
	}
	
	function testFindRecipesByKeyword_validKeywordSingleResult()
	{
		$keyword = "dinner";
		$this->result_table = db_recipes::find_recipes_by_keyword($keyword);
		$expected_names = array( "Pizza Dough" );
		$expected_rids = array( 1 );
		for ($i = 0; $i < count($expected_names); $i++)
		{
			$row = mysqli_fetch_array($this->result_table, MYSQLI_BOTH);
			$this->assertEquals($row[0], $expected_names[$i]);
			$this->assertEquals($row[1], $expected_rids[$i]);
		}
	}
	

}

?>