<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title> <?php echo($title);?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin/recipe.css">

</head>
<body>
<?php 
include '../config/isadmin.php';

if($isadmin){
	print_page();
}

function print_page(){
	include('../text/managerecipe_text.php');
?>

<h2> <?php echo($title);?></h2>

<div id="wrapper">
    <ul class="menu">
        <li class="item1"><a href="add/add_recipe.php"><?php echo($first);?></a></li>
        <li class="item2"><a href="edit/edit_recipe.php"><?php echo($second);?></a></li>
        <li class="item3"><a href="delete/delete_recipe.php"><?php echo($third);?></a></li>
		<li class="item4"><a href="../menu.php"> <?php echo($home);?></a></li>
	</ul>
</div>
<?php
}
?>
</body>
</html>