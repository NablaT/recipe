  <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> Menu </title>
<link rel="stylesheet" href="../css/helpmetocook/index.css" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="bootstrap/js/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<body>

<?php
include ('../config/isconnected.php');
include('../text/menuhelpme_text.php');
//To fix textarea: resize:none; 
?>
<div class="login-card">
	<h1> <?php echo($title);?> </h1>
	<form method="post" action="recipelist.php">
	<p>
		<label for="description"> <?php echo($description);?> </label></br>
		<textarea name="textarea"> </textarea >
		</br>
		<?php echo($option);?></br>
		<input type="radio" name="radio" value="0" id="0" /> <label for="0error"> 0 </label>
		<input type="radio" name="radio" value="1" id="1" /> <label for="1error"> 1 </label>
		<input type="radio" name="radio" value="2" id="2" /> <label for="2error">2</label>
		<input type="radio" name="radio" value="3" id="3" /> <label for="3error">3</label>
		<input type="radio" name="radio" value="more" id="more" /> <label for="more">More</label><br/><br/><br/><br/>
		<input type="submit" name="find" class="login login-submit" value="<?php echo($validate);?>" />
	   </p>
	</form>
	</p>
	</form>
</div>
</body>

</html>
