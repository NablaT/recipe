 <!DOCTYPE html>
<html>
<head>
<title> Menu </title>
<link rel="stylesheet" href="css/menu.css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="jquery.aw-showcase.js"></script>
<script type="text/javascript">

$(document).ready(function()
{
	$("#showcase").awShowcase(
	{
		content_width:			700,
		content_height:			470,
		fit_to_parent:			false,
		auto:					false,
		interval:				3000,
		continuous:				false,
		loading:				true,
		tooltip_width:			200,
		tooltip_icon_width:		32,
		tooltip_icon_height:	32,
		tooltip_offsetx:		18,
		tooltip_offsety:		0,
		arrows:					true,
		buttons:				true,
		btn_numbers:			true,
		keybord_keys:			true,
		mousetrace:				false, /* Trace x and y coordinates for the mouse */
		pauseonover:			true,
		stoponclick:			true,
		transition:				'vslide', /* hslide/vslide/fade */
		transition_delay:		300,
		transition_speed:		500,
		show_caption:			'onhover', /* onload/onhover/show */
		thumbnails:				true,
		thumbnails_position:	'outside-last', /* outside-last/outside-first/inside-last/inside-first */
		thumbnails_direction:	'vertical', /* vertical/horizontal */
		thumbnails_slidex:		0, /* 0 = auto / 1 = slide one thumbnail / 2 = slide two thumbnails / etc. */
		dynamic_height:			false, /* For dynamic height to work in webkit you need to set the width and height of images in the source. Usually works to only set the dimension of the first slide in the showcase. */
		speed_change:			true, /* Set to true to prevent users from swithing more then one slide at once. */
		viewline:				false /* If set to true content_width, thumbnails, transition and dynamic_height will be disabled. As for dynamic height you need to set the width and height of images in the source. */
	});
});

</script>
</head>
<body>

<div style="width: 845px; margin: auto;">
	
	<!-- This is the button used to switch between One Page and Slideshow. -->
	<?php 
	include("data.php");
	
	if($numberOfRecipe>0){
		$allPath=array();
		$recipes=scandir("images/showcase"); 
		if(count($recipes)<3){
			echo("The folder doesn't contains any images"); 
		}
		else{
			?>
			<div id="showcase-arrow-previous" class="showcase"> </div>
			<div id="showcase" class="showcase">
				<!-- Each child div in #showcase with the class .showcase-slide represents a slide. -->
				<?php
				for($i=2; $i<count($recipes); $i++){
					$currentPath="images/showcase/".$recipes[$i]; 
				?>
				<div class="showcase-slide">
					<!-- Put the slide content in a div with the class .showcase-content. -->
					<div class="showcase-content">
						<div class="showcase-image">
						<img src="<?php echo($currentPath);?>" alt="<?php echo("Image ".$i);?>" />
						</div>
					</div>
					<!-- Put the thumbnail content in a div with the class .showcase-thumbnail -->
					<div class="showcase-thumbnail">
						<img src="<?php echo($currentPath);?>" alt="<?php echo($i);?>" width="140px" />		
					</div>
				</div>
				<?php
				}
				?>
			</div>
			
			<div id="showcase-arrow-next" class="showcase"> </div>
			<?php
		}
			
	}
	else{
		echo ("File can't be read");
	}
?>
</body>
</html>
