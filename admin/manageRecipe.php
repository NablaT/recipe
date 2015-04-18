
<?php 
include '../config/isadmin.php';

if($isadmin){
	print_page();
}

function print_page(){
	include('../text/managerecipe_text.php');
?>
<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title> <?php echo($title);?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin/recipe.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>

<body>
<h2> <?php echo($title);?></h2>

<div id="wrapper">
    <ul class="menu">
        <li class="item1"><a href="#"><?php echo($recipe);?><span>3</span></a>
			<ul>
				<li class="subitem1"><a href="add/add_recipe.php"><?php echo($first);?></a></li>
                <li class="subitem2"><a href="edit/edit_recipe.php"><?php echo($second);?></a></li>
                <li class="subitem3"><a href="delete/delete_recipe.php"><?php echo($third);?></a></li>
			</ul>
		</li>
        <li class="item2"><a href="#"><?php echo($ingredients);?><span>3</span></a>
			<ul>
				<li class="subitem1"><a href="ingredient/add/add_recipe.php"><?php echo($ingfirst);?></a></li>
                <li class="subitem2"><a href="ingredient/edit/edit_recipe.php"><?php echo($ingsecond);?></a></li>
                <li class="subitem3"><a href="ingredient/delete/delete_recipe.php"><?php echo($ingthird);?></a></li>
			</ul>
		</li>
		<li class="item4"><a href="../menu.php"> <?php echo($home);?></a></li>
	</ul>
</div>
<?php
}
?>
</body>
</html>