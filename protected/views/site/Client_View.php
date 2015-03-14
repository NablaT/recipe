<?php

include 'config.php';

$reponse=$bdd->query('SELECT * FROM client');

$save=array();//SELECT * FROM `client`
 

while($donnes =$reponse->fetch()){
	if(!in_array($donnes['client'],$save)){
		array_push($save,$donnes['client']);
		?>
		<p>
		
		<strong> Client </strong>: <?php echo $donnes['client']; ?><br/>
		
		</p>
		
		<input type="button" name="Valider" value="Valider" onclick="self.location.href='Designation_View.php?client=<?php echo $donnes['client'];?>'" style="background-color:#BDBDBD" style="color:white; font-weight:bold"onclick> 
		<?php 
	}
}
$reponse->closeCursor(); 
/*
<form action="Designation_View.php" method="post">
		<p>	
		<input type="submit" value="Valider" />
		</p>
		</form>
		
<a href="Designation_View.php?client=<?php echo $donnes['nom'];?>">
		<strong> Client </strong>: <?php echo $donnes['nom']; ?><br/>
		</a> 
*/
?>