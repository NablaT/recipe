﻿<?php 
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
	include('../../../text/recipe/managerecipe_text.php');
?>

<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title> <?php echo($titleadd);?></title>
	<link rel="stylesheet" type="text/css" href="../../../css/admin/framemanagerecipe.css">

</head>
<body>


<h2> <?php echo($titleadd);?> </h2>
<div id="formContainer">
<form method="post" action="write_recipe.php" id="menu">
    <p>
        <label><?php echo($name);?> </label> : <br/><input type="text" name="nom" id="nom" placeholder="Name"/>
		<br/><br/>
        <label><?php echo($nbofingredients);?> </label> : <br/><input type="number" name="number" id="number"/>
		<br/><br/>
        <label><?php echo($nbofsteps);?> </label> : <br/><input type="number" name="steps" id="steps" />
	</p>
	<input type="submit" value="<?php echo($next);?>" />
</form>

	<a href="../manageRecipe.php"> <?php echo($home);?> </a>
</div>
</script>
<?php
}
?>
</body>
</html>