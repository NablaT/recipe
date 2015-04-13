<!DOCTYPE>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<title> <?php echo($title);?></title>
	<link rel="stylesheet" type="text/css" href="../css/formu.css">

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
        <li class="item1"><a href="add_old_formu.php"><?php echo($first);?></a></li>
        <li class="item2"><a href="edit_old_formu.php"><?php echo($second);?></a></li>
        <li class="item3"><a href="delete_old_formu.php"><?php echo($third);?></a></li>
		<li class="item4"><a href="menu_admin.php"> <?php echo($home);?></a></li>
	</ul>
</div>
<?php
}
?>
</body>
</html>