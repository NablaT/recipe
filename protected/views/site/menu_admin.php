<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3/org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"/>
	<meta http-equiv="Content-Language" content="fr"/>
	<head>
        <title>Menu principal</title>
         
        <link rel="stylesheet" href="styles.css" type="text/css"/>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    </head>
<body>
<?php 
include 'isadmin.php';

if($isadmin){
	print_page();
}

function print_page(){
?>
<h2> Menu </h2>
	<div id="wrapper">
    <ul class="menu">
        <li class="item1"><a href="#">Production <span>2</span></a>
			 <ul>
                <li class="subitem1"><a href="planningprod.php">Accès planning </a></li>
                <li class="subitem2"><a href="page1.php">Ajout de tâches planning</a></li>
            </ul>
		</li>
		<li class="item1"><a href="#">Analyses <span>1</span></a>
			 <ul>
                <li class="subitem1"><a href="analyse_vrac.php">Analyse Vrac </a></li>
            </ul>
		</li>
		<li class="item1"><a href="#"> N° de lot VRAC <span>2</span></a>
			 <ul>
                <li class="item1"><a href="search_numlotvrac.php">Rechercher N° de lot VRAC</a></li>
				<li class="item2"><a href="list_numlotvrac.php">Liste des N° de lot VRAC </a></li>
            </ul>
		</li>
        <li class="item2"><a href="#">Formules<span>6</span></a>
			<ul>
                <li class="subitem1"><a href="add_formu.php">Ajouter une formule</a></li>
                <li class="subitem2"><a href="edit_formu.php">Editer une formule </a></li>
				<li class="subitem2"><a href="edit_nomformu.php">Editer le nom d'une formule </a></li>
                <li class="subitem3"><a href="delete_formu.php"> Supprimer une formule </a></li>
				<li class="subitem1"><a href="choice_list_formu.php">Liste des formules</a></li>
				<li class="subitem1"><a href="menu_old_formu.php"> Anciennes formules </a>
            </ul>
		</li>
		<li class="item2"><a href="#">Densités <span>2</span></a>
			<ul>
                <li class="subitem1"><a href="maj_densite.php">Mise à jour densité matière première </a></li>
				<li class="subitem1"><a href="#">Lancer une analyse des densités par formulation </a></li>
            </ul> <?php //analyse_densite.php ?>
		</li>
		<li class="item2"><a href="#">Tolérances<span>3</span></a>
			<ul>
                <li class="subitem1"><a href="maj_tolerance_phec.php">Mise à jour tolérance pH et Ec </a></li>
                <li class="subitem2"><a href="maj_tolerance_matiere.php"> Mise à jour tolérance densité par matière </a></li>
                <li class="subitem3"><a href="maj_tolerance_vrac.php">Mise à jour tolérance densité vrac </a></li>
            </ul>
		</li>
				<li class="item2"><a href="#">Matières premières <span>4</span></a>
			<ul>
                <li class="subitem1"><a href="add_matprem.php">Ajouter une nouvelle matière première</span></a></li>
                <li class="subitem2"><a href="edit_matprem.php"> Editer une matière première</a></li>
                <li class="subitem3"><a href="delete_matprem.php"> Supprimer une matière première</a></li>
				<li class="subitem1"><a href="choice_list_matprem.php">Liste des matières premières</a></li>
		   </ul>
		</li>
				<li class="item2"><a href="#">Additifs <span>4</span></a>
			<ul>
                <li class="subitem1"><a href="add_additif.php">Ajouter un nouvel additif</span></a></li>
                <li class="subitem2"><a href="edit_additif.php"> Editer un additif</a></li>
                <li class="subitem3"><a href="delete_additif.php"> Supprimer un additif</a></li>
				<li class="subitem1"><a href="choice_list_addi.php">Liste des additifs</a></li>

            </ul>
		</li>
        <li class="item4"><a href="#">Les Fiches <span>4</span></a>
			<ul>
				<li class="subitem2"><a href="#">Liste des fabrications VRAC</a></li>
                <li class="subitem1"><a href="menu_fiche_fabrication.php"> Fiches de fabrications</a></li>
                <li class="subitem1"><a href="menu_old_fiche_fabrication.php"> Anciennes fiches</a></li>
				<li class="subitem2"><a href="#">Fiche d'ensachage</a></li>
            </ul>	
		</li>

	<li class="item1"><a href="#">Déconnexion <span>1</span></a>
		 <ul>
                <li class="subitem1"><a href="logout.php"> Se déconnecter </a></li>
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