<?php 
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=recipe', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>
