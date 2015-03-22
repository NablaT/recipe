 <?php
/* @var $this RecipeController */
/* @var $data Recipe */
?>

<div class="view">
		<table id="pricetable">
			<thead>
				<tr>
					<th class="choiceA">Produit</th>
					<th class="choiceB">Pourcentage</th>
					<th class="choiceC on">Poids (kg)</th>
					<th class="choiceD">Nombre de Godet</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="side"><?php echo($donnes['Matierecourante']) ?></td>
					<td class="choiceA"><?php echo($donnes['Pourcentage']) ?></td>
					<td class="choiceB"><?php echo($donnes['Kg']) ?></td>
					<td class="choiceC on"><?php echo($donnes['Nbgodet']) ?></td>
				</tr>
			</tbody>
		</table><br/><p>
		<input type="button" name="Valider" value="Valider" 
		onclick="self.location.href='Recipe_View.php?numcom=<?php echo $donnes['Numcommande'];?>&step=<?php echo ($fullstep)?>'" style="background-color:#BDBDBD" tyle="color:white; font-weight:bold"onclick> 
		<br/> </p>
		<a href="planningprod.php"> Retour planning </a>
</div>