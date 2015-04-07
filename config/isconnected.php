
<?php 
//On démarre la session 
session_start();
$isconnected=true;
// On récupère nos variables de session
if (isset($_SESSION['login'])) {
		//On vérifie bien que la personne connectée est un admin.
		if(strcmp($_SESSION['type'],'admin')!=0 && strcmp($_SESSION['type'],'user')!=0){
			//print_r($_SESSION);
			// Le visiteur n'a pas été reconnu comme étant un admin de notre site. On utilise alors un petit javascript lui signalant ce fait
			echo '<body onLoad="alert(\'Vous ne pouvez accéder à cette page par manque de droits\')">';
			// puis on le redirige vers la page d'accueil
			echo '<meta http-equiv="refresh" content="0;URL=index.php">';
			$isconnected=false;
		}
		
		session_cache_limiter('private_no_expire, must-revalidate');
		// On teste pour voir si nos variables ont bien été enregistrées
}
else {
		echo '<body onLoad="alert(\'Veuillez vous connecter pour accéder à cette page\')">';
			// puis on le redirige vers la page d'accueil
			echo '<meta http-equiv="refresh" content="0;URL=index.php">';
		$isconnected=false;
}

?>