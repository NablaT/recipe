<?php

include ('../config/isconnected.php');
include('../config/config.php');
print_page($bdd);

function print_page($bdd){
	include('../text/menufindme_text.php');
	$step=0;
	if(count($_GET)!=0){
		$step=$_GET['step']+1;
		savepreviousresults($bdd);
		
	}
	
?>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
		<title> <?php echo($title);?></title>
		<link rel="stylesheet" type="text/css" href="../css/findmerecipe/button.css">

	</head>
	<body>
<div class="radio">
	<form method="post" action="index.php?step=<?php echo($step);?>">
	<input type="radio" name="rdo" id="yes" checked />
	<input type="radio" name="rdo" id="no"/>
	<div class="switch">
		<label for="yes"><h1>Vegetable</h1></label>
		<label for="no"><h1>Carne</h1></label>
		<span></span>
	</div>
	<input type="submit" name="find" value="Valider" />
</form>
</div>

	<a href="../menu.php"><?php echo($previousPage);?></a>
</body>
<?php
}

function savepreviousresults($bdd){
	
}
?>