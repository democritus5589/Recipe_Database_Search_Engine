<!doctype html>

<?php

include_once 'TestSuites.php';

?>

<html>

    <head>
	    <meta charset="utf-8">
	    <title>Unit Testing Home Page</title>
    </head>
    
    <body>
		<h2>Unit Tests</h2><br />
<?php        TestSuites::runAllTests(); ?>
    </body>
</html>