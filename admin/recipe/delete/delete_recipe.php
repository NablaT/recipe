

<?php 
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
	<title><?php echo($deleterecipe);?></title>
	<link rel="stylesheet" type="text/css" href="../../../css/admin/framemanagerecipe.css">

</head>
<body>
<h2> <?php echo($deleterecipe);?></h2>
<form method="post" action="verify_edit.php">
    <p>
        <label><?php echo($recipename);?></label> : <br/><input type="text" name="nom" id="nom"/>
		<br/>
    </p>
	<input type="submit" value="<?php echo($delete);?>" />
</form>

<a href="../../manageRecipe.php">  <?php echo($home);?></a>
<?php
}
?>
</body>
</html>