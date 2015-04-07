


<?php 
//We start the session 
session_start();
$isadmin=true;

// We take session variables
if (isset($_SESSION['login'])) {
		//We verify if user is a type "admin" 
		if(strcmp($_SESSION['type'],'admin')!=0){
			// User hasn't been recognized as a type "admin"
			echo '<body onLoad="alert(\'Vous ne pouvez accéder à cette page par manque de droits\')">';
			// Then we redirect to home page
			echo '<meta http-equiv="refresh" content="0;URL=menu_user.php"/>';
			$isadmin=false;
		}
		
	session_cache_limiter('private_no_expire, must-revalidate');
	// We test to verify if we save our variables
}
else {
		echo '<body onLoad="alert(\'Veuillez vous connecter pour accéder à cette page.\')">';
		// Then we redirect to home page
		echo '<meta http-equiv="refresh" content="0;URL=index.php;charset=utf8_decode">';
		$isadmin=false;
}

?>