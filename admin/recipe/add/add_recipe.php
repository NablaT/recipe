<?php 
include ('../../../config/isadmin.php');

if($isadmin){
	print_page();
}

function print_page(){
	include ('../../../config/config.php');
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
		<br/><br/>
		<?php 	
		$categories=array();
		$req = $bdd->query('SELECT * FROM category');
		while($donnes=$req->fetch()){
			if(strcmp($donnes['Name'],"Other")!=0 
				&& strcmp($donnes['Name'],"Others")!=0 ){
					array_push($categories, $donnes['Name']);		
			}
		}
		$req->closeCursor();
		?>
		<label><?php echo($category);?> </label> : <br/>
        <select name="godet">
			<?php 
			for($i=0;$i<count($categories);$i++){
			?>
				<option value="categories<?php echo($i);?>"><?php echo($categories[$i]);?></option>
			<?php
			}
			?>
		</select></p>
	<input type="submit" value="<?php echo($next);?>" />
</form>

	<a href="../../manageRecipe.php"> <?php echo($home);?> </a>
</div>
</script>
<?php
}
?>
</body>
</html>