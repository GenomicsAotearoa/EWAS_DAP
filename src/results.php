<!DOCTYPE HTML>

<html>
	<head>
    <title>Job results</title>		
		<script src="preview/js/skel.min.js"></script>
		<script src="preview/js/init.js"></script>
		
		<link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/multi-select.css">
		<link rel="stylesheet" href="preview/css/skel-noscript.css" />
		<link rel="stylesheet" href="preview/css/style.css" />
		<link rel="stylesheet" href="preview/css/style-desktop.css" />
	</head>
	<body>

		<!-- Header -->
		<div id="header">
	                <!--    <font size="+4" color="white"><b><u>EWASP</u> - A comprehensive pipeline for Epigenetic-wide Data Analysis.</b></font> -->
	    </div>
		<!-- Header --> 

		<!-- Main -->
		<div id="main">
			<div class="container">
				<div class="row">
					
				<!-- Content -->
				<div id="content" class="6u skel-cell-important">
					<section>
						<ul>
						<?php
							$dir = getenv("EWAS_RESULTS");
							$path = getenv("EWAS_REPORT_PATH") . "/reports/output.php?result_id=";
							$cdir = scandir($dir);
								foreach ($cdir as $key => $value)
								{
									if (!in_array($value,array(".","..")))
									{
										if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
										{
											echo "<li><a href=\"" . $path . $value ."\">" . $value . "</a></li>";
										}
									}
								}
						?>	
						</ul>
					</section>
				</div>
			</div>
		</div>

		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.multi-select.js"></script>
		<script type="text/javascript"></script>
  
  
	</body>
</html>
