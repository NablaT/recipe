
<?php 
//We start the session 
session_start();
$isconnected=true;
// We take session variables 
if (isset($_SESSION['login'])) {
		//We verify if user is a type "user" 
		if(strcmp($_SESSION['type'],'admin')!=0 && strcmp($_SESSION['type'],'user')!=0){
			// User hasn't been recognized as a type "user"
			echo '<body onLoad="alert(\'Vous ne pouvez acc�der � cette page par manque de droits\')">';
			// Then we redirect to home page
			echo '<meta http-equiv="refresh" content="0;URL=../index.php">';
			$isconnected=false;
		}
		
		session_cache_limiter('private_no_expire, must-revalidate');
		// We test to verify if we save our variables
}
else {
		echo '<body onLoad="alert(\'Veuillez vous connecter pour acc�der � cette page\')">';
			// Then we redirect to home page
			echo '<meta http-equiv="refresh" content="0;URL=../index.php">';
		$isconnected=false;
}

?>