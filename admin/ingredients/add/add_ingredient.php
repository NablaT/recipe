<?php 
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
	include('../../../text/recipe/manageingredient_text.php');
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
<form method="post" action="write_ingredient.php" id="menu">
    <p>
        <label><?php echo($name);?> </label> : <br/><input type="text" name="name" id="name" placeholder="Name"/>
		<br/><br/>
		<label><?php echo($typeofingredient);?> </label> :<br/>
        <select name="<?php echo($type)?>" id="<?php echo($type)?>">
			<option value="fruit"><?php echo($fruit)?></option> 
			<option value="vegetable"> <?php echo($vegetable)?></option>
			<option value="meat"> <?php echo($meat)?></option>
			<option value="liquid"> <?php echo($liquid)?></option>
			<option value="spicy"> <?php echo($spicy)?></option>
			<option value="other"> <?php echo($other)?></option>
		</select>	</p>
	<input type="submit" value="<?php echo($addingredient);?>" />
</form>

	<a href="../../manageRecipe.php"> <?php echo($home);?> </a>
</div>
</script>
<?php
}
?>
</body>
</html>