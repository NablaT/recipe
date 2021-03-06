
<?php 
include '../config/isadmin.php';

if($isadmin){
	print_page();
}

function print_page(){
	include('../text/recipe/managerecipe_text.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3/org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"/>
	<meta http-equiv="Content-Language" content="fr"/>
	<head>
	<title> <?php echo($title);?></title>
         
        <link rel="stylesheet" href="../css/admin/recipe.css" type="text/css"/>
		   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    </head>
<body>
<h2> Menu </h2>
	<div id="wrapper">
    <ul class="menu">
	<li class="item1"><a href="#"><?php echo($recipe);?><span>5</span></a>
		<ul>
				<li class="subitem1"><a href="recipe/add/add_recipe.php"><?php echo($addrecipe);?></a></li>
                <li class="subitem2"><a href="recipe/edit/edit_recipe.php"><?php echo($editrecipe);?></a></li>
                <li class="subitem3"><a href="recipe/delete/delete_recipe.php"><?php echo($deleterecipe);?></a></li>
				<li class="subitem3"><a href="recipe/list/recipe_list.php"><?php echo($listrecipe);?></a></li>
				<li class="subitem3"><a href="recipe/search/search_recipe.php"><?php echo($searchrecipe);?></a></li>
		</ul>
	</li>
        <li class="item2"><a href="#"><?php echo($ingredients);?><span>5</span></a>
			<ul>
				<li class="subitem1"><a href="ingredients/add/add_ingredient.php"><?php echo($addingredient);?></a></li>
                <li class="subitem2"><a href="ingredients/edit/edit_ingredient.php"><?php echo($editingredient);?></a></li>
                <li class="subitem3"><a href="ingredients/delete/delete_ingredient.php"><?php echo($deleteingredient);?></a></li>
				<li class="subitem3"><a href="ingredients/list/ingredient_list.php"><?php echo($listingredient);?></a></li>
				<li class="subitem3"><a href="ingredients/delete/search_ingredient.php"><?php echo($searchingredient);?></a></li>
			</ul>
		</li>
        
	<li class="item1"><a href="#"><?php echo($logout)?><span>1</span></a>
		 <ul>
                <li class="subitem1"><a href="config/logout.php"> <?php echo($logout)?> </a></li>
            </ul>
	</li>
	<li class="item1"><a href="#"><?php echo($home)?><span>1</span></a>
		 <ul>
                <li class="subitem1"><a href="../menu.php"> <?php echo($home)?> </a></li>
            </ul>
	</li>
     </ul>
</div>
<script type="text/javascript">
$(function() {
 
    var menu_ul = $('.menu > li > ul'),
        menu_a  = $('.menu > li > a');
     
    menu_ul.hide();
 
    menu_a.click(function(e) {
        e.preventDefault();
        if(!$(this).hasClass('active')) {
            menu_a.removeClass('active');
            menu_ul.filter(':visible').slideUp('normal');
            $(this).addClass('active').next().stop(true,true).slideDown('normal');
        } else {
            $(this).removeClass('active');
            $(this).next().stop(true,true).slideUp('normal');
        }
    });
 
});
</script>
<?php
}
?>
</body>
</html>