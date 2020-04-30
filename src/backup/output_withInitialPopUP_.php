<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title></title>
    <link rel="icon" href="fav.ico">
	
    <!-- Bootstrap CSS -->
    <link href="http://skuastk.org/ewas/assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Magnific-popup -->
    <link rel="stylesheet" href="http://skuastk.org/ewas/assets/css/magnific-popup.css">
    <!-- Custom styles for this template -->
    <link href="http://skuastk.org/ewas/assets/css/main.css" rel="stylesheet">
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.2.js"></script>
	<style type="text/css">
		#overlay {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: #000;
		filter:alpha(opacity=70);
		-moz-opacity:0.7;
		-khtml-opacity: 0.7;
		opacity: 0.7;
		z-index: 100;
		display: none;
		}
		.cnt223 a{
		text-decoration: none;
		}
		.popup{
		width: 100%;
		margin: 0 auto;
		display: none;
		position: fixed;
		z-index: 101;
		}
		.cnt223{
		min-width: 600px;
		width: 600px;
		min-height: 150px;
		margin: 100px auto;
		background: #f3f3f3;
		position: relative;
		z-index: 103;
		padding: 90px 35px;
		border-radius: 16px;
		box-shadow: 0 2px 5px #000;
		}
		.cnt223 p{
		clear: both;
			color: #555555;
			/* text-align: justify; */
			font-size: 20px;
			font-family: sans-serif;
		}
		.cnt223 p a{
		color: #d91900;
		font-weight: bold;
		}
		.cnt223 .x{
		float: right;
		height: 35px;
		left: 22px;
		position: relative;
		top: -25px;
		width: 34px;
		}
		.cnt223 .x:hover{
		cursor: pointer;
		}
	</style>
	<script type='text/javascript'>
		$(function(){
		var overlay = $('<div id="overlay"></div>');
		overlay.show();
		overlay.appendTo(document.body);
		$('.popup').show();
		$('.close').click(function(){
		$('.popup').hide();
		overlay.appendTo(document.body).remove();
		return false;
		});
		$('.x').click(function(){
		$('.popup').hide();
		overlay.appendTo(document.body).remove();
		return false;
		});
		});
	</script>
</head>

<body>
<div class='popup'>
	<div class='cnt223'>
	<font size="-1" color="BLACK">Point mouse-over the image to see error reasons.</font>
	<h1><u>Analysis overview</u></h1>
		<p>
			<table width="100%" >
				<?php
				$com_type		=	file_get_contents("com_type.txt");
				$com_type		=	str_replace('"','',$com_type);				
				$out			=	file_get_contents("output_LDS.txt");
				$out_array		=	explode ("**", $out);
				$out_len		=	sizeof ($out_array);
				for ($i=2;$i<$out_len;$i++) {
					echo "<tr>";
					$processes	=	explode (",", $out_array[$i]);
					
					if ($processes[1] == 1) {
						echo "<td width=\"80%\" style=\"line-height:50px;\">$processes[0]</td>";						
						echo "<td width=\"20%\"><img src=\"http://skuastk.org/ewas/assets/img/tick.jpg\" width = \"40px\" height = \"40px\" ></td>";
					}  else {
						echo "<td width=\"80%\">$processes[0]</td>";
						echo "<td width=\"20%\"><img src=\"http://skuastk.org/ewas/assets/img/cross.jpg\" width = \"40px\" height = \"40px\" title=\"Possible reasons:\n$processes[0] \nhere is the message\nhere is the message\nhere is the message\nhere is the message\nhere is the message\" ></td>";
					}
					echo "</tr>";	
				}				
				?>
			</table>
		</p>
		</br>
		<a href='' class='close'>Close</a>
		
	</div>
</div>
<div class="loader">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
</div>

<div class="body-container container-fluid">
    <a class="menu-btn" href="javascript:void(0)">
        <i class="ion ion-grid"></i>
    </a>
    <div class="row justify-content-center">
        <!--=================== side menu ====================-->
        <div class="col-lg-2 col-md-3 col-12 menu_block">

            <!--logo -->
            <div class="logo_box">
                <a href="#">
                    <img src="http://skuastk.org/ewas/assets/img/logo.png" alt="cocoon">
                </a>
            </div>
            <!--logo end-->

            <!--filter menu -->
            <div class="side_menu_section">
                <h4 class="side_title">EWAS Output</h4>
                <ul  id="filtr-container"  class="filter_nav">
					
						<li  data-filter="*" class="active"><a href="javascript:void(0)" >all Graphs</a></li>
						<li data-filter=".QC"> <a href="javascript:void(0)">Data QC Plots</a></li>
						<li data-filter=".qq_plot"><a href="javascript:void(0)">QQ Plots</a></li>
						<li data-filter=".manhatten_plot"><a href="javascript:void(0)">Manhatten Plots</a></li>
					<?php
						if ($com_type == 1) {
							echo "<li data-filter=\".heatmap\"><a href=\"javascript:void(0)\">Heatmap</a></li>";
							echo "<li data-filter=\".volcano\"><a href=\"javascript:void(0)\">Volcano Plots</a></li>";
						}
					?>
						<li data-filter=".BVD"><a href="javascript:void(0)">Beta value distribution plots</a></li>
						<li data-filter=".HS"><a href="javascript:void(0)">Key genes</a></li>
					
                </ul>
            </div>
			<!--main menu -->
			<?php
			$file		=	scandir('./');
			$HM			=	preg_grep("/HM/", $file);
			$QC			=	preg_grep("/QC/", $file);
			$QQ			=	preg_grep("/graph_QQ/", $file);
			$manhat		=	preg_grep("/graph_M/", $file);
			$vol		=	preg_grep("/_volcano_plot/", $file);
			$beta_dist	=	preg_grep("/Beta_Val_dist_/", $file);
			$DMP		=	preg_grep("/DMP_/", $file);
            $BCC		=	preg_grep("/BloodCellFractions.csv/", $file);
                    
             echo "<div class=\"side_menu_section\">";
                 echo "<ul class=\"menu_nav\">";
                 echo "<h4 class=\"side_title\">Download Data</h4>";
                     echo "<li>";
                         echo "<a href=\"result.zip\">";
                            echo "Download all results (ZIP file)";
                         echo "</a>";
                     echo "</li>";
					 echo "<li>";
                         echo "<a href=\"DMRs.csv\">";
                            echo "Download list of DMRs";
                         echo "</a>";
                     echo "</li>";
					 echo "<li>";
                         echo "<a href=\"horvath_server_CPG_sites.csv\">";
                            echo "Download beta values for Horvath server";
                         echo "</a>";
                     echo "</li>";
					 echo "<li>";
                         echo "<a href=\"beta.csv\">";
                            echo "Beta values";
                         echo "</a>";
                     echo "</li>";
                    if ($BCC) {
                        echo "<li>";
                            echo "<a href=\"BloodCellFractions.csv\">";
                                echo "Blood Cell Fraction";
                            echo "</a>";
                        echo "</li>";
                    }
					 echo "<h4 class=\"side_title\" style=\" color:#ffe2b2;margin-bottom: -5px;margin-top: 25px;\">Download DMPs</h4>";
					 foreach ($DMP as $value) {
                     echo "<li>";
                         echo "<a href=\"$value\">";
                            echo "<font size=\" -1 \">DMPs : \"$value\" </font>";
                         echo "</a>";
                     echo "</li>";
					 }
                    
                 echo "</ul>";
                 echo "<br/><br/>";
                 echo "<img src=\"http://130.216.216.57/ewas/ewas_pip/out/svd_convention.jpg\" style=\"display: block; margin-left: auto; margin-right: auto; width: 50%;\" />";
             echo "</div>";
			
			?>
            <!--main menu end -->
            <!--filter menu end -->

           

        </div>

        <!--=================== content body ====================-->
        <div class="col-lg-10 col-md-9 col-12 body_block  align-content-center">
            <div class="portfolio">
                <div class="container-fluid">
                    <!--=================== masaonry portfolio start====================-->
                    <div class="grid img-container justify-content-center no-gutters">
                        <div class="grid-sizer col-sm-12 col-md-6 col-lg-3"></div>
						<?php
						
						
						foreach ($QC as $value) {
						$new_value		=	str_replace("myLoad\$pd\$","",$value);
						$new_value		=	str_replace("_SVD_QC","",$new_value);							
                        echo "<div class=\"grid-item QC col-sm-12 col-md-6 col-lg-3\">";
                            echo "<a href=\"$value\" title=\"Quality Control (stage : $new_value)\">";
                                echo "<div class=\"project_box_one\">";
                                    echo "<img src=\"$value\" alt=\"pro1\" />";
                                    echo "<div class=\"product_info\">";
                                        echo "<div class=\"product_info_text\">";
                                            echo "<div class=\"product_info_text_inner\">";
                                                echo "<i class=\"ion ion-plus\"></i>";
                                                echo "<h4>QC plots : $new_value</h4>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</a>";
                        echo "</div>";
						}		
						
						foreach ($HM as $value) {
						echo "<div class=\"grid-item  heatmap col-sm-12 col-md-6 col-lg-3\">";
                        echo "<a href=\"$value\" title=\"Heatmap (stage : $value)\">";
                                echo "<div class=\"project_box_one\">";
                                    echo "<img src=\"$value\" alt=\"pro1\" />";
                                    echo "<div class=\"product_info\">";
                                        echo "<div class=\"product_info_text\">";
                                            echo "<div class=\"product_info_text_inner\">";
                                                echo "<i class=\"ion ion-plus\"></i>";
                                                echo "<h4> Heatmap stage : $value</h4>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</a>";
                        echo "</div>";						
                        }
						
						foreach ($QQ as $value) {
                        echo "<div class=\"grid-item qq_plot col-sm-12 col-md-6 col-lg-3\">";
                            echo "<a href=\"$value\" title=\"QQ Plot (stage : $value)\">";
                                echo "<div class=\"project_box_one\">";
                                    echo "<img src=\"$value\" alt=\"pro1\" />";
                                    echo "<div class=\"product_info\">";
                                        echo "<div class=\"product_info_text\">";
                                            echo "<div class=\"product_info_text_inner\">";
                                                echo "<i class=\"ion ion-plus\"></i>";
                                                echo "<h4>QQ Plot stage : $value</h4>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</a>";
                        echo "</div>";
						}
						
						foreach ($manhat as $value) {
                        echo "<div class=\"grid-item  manhatten_plot  col-sm-12 col-md-6 col-lg-3\">";
						  $stage_temp		=	str_ireplace(".graph_M.Png","",$value);
                            echo "<a href=\"$value\" title=\"Manhattan Plot (stage : $stage_temp)\">";
                                echo "<div class=\"project_box_one\">";
                                    echo "<img src=\"$value\" alt=\"pro1\" />";
                                    echo "<div class=\"product_info\">";										
										echo "<input type=\"button\" onclick=\"window.open('manhattan.php?data=$stage_temp')\" value=\"Click here for interactive Manhattan Plot\"/>";
                                        echo "<div class=\"product_info_text\">";
                                            echo "<div class=\"product_info_text_inner\">";
                                                echo "<i class=\"ion ion-plus\"></i>";
                                                echo "<h4>Manhattan Plot stage : $stage_temp</h4>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</a>";
                        echo "</div>";
						}
						
						foreach ($vol as $value) {
                        echo "<div class=\"grid-item volcano col-sm-12 col-md-6 col-lg-3\">";
						  $stage_temp		=	str_ireplace("_volcano_plot.jpg","",$value);
                            echo "<a href=\"$value\" title=\"Volcano Plot (stage : $stage_temp)\">";
                                echo "<div class=\"project_box_one\">";
                                    echo "<img src=\"$value\" alt=\"pro1\" />";
                                    echo "<div class=\"product_info\">";
                                        echo "<div class=\"product_info_text\">";																				
										echo "<input type=\"button\" onclick=\"window.open('volcano.php?data=$stage_temp')\" value=\"Click here for interactive volcano plot.\"/>";
                                            echo "<div class=\"product_info_text_inner\">";
                                                echo "<i class=\"ion ion-plus\"></i>";
                                                echo "<h4>Volcano Plot stage : $stage_temp</h4>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</a>";
                        echo "</div>";
						}
						
						foreach ($beta_dist as $value) {
                        echo "<div class=\"grid-item BVD col-sm-12 col-md-6 col-lg-3\">";
                            echo "<a href=\"$value\" title=\"BVD Plot (stage : $value)\">";
                                echo "<div class=\"project_box_one\">";
                                    echo "<img src=\"$value\" alt=\"pro1\" />";
                                    echo "<div class=\"product_info\">";
                                        echo "<div class=\"product_info_text\">";
                                            echo "<div class=\"product_info_text_inner\">";
                                                echo "<i class=\"ion ion-plus\"></i>";
                                                echo "<h4>BVD Plot stage : $value</h4>";
                                            echo "</div>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</a>";
                        echo "</div>";
						}
						
						echo "<div class=\"grid-item HS col-sm-6 col-md-3 col-lg-3\">";
                                echo "<div class=\"project_box_one\">";
                                    echo "<object data=\"1.pdf\" type=\"application/pdf\" width=\"100%\" height=\"500\">";
										echo "<iframe src=\"1.pdf\"></iframe>";
									echo "</object>";                                    
                                echo "</div>";
                        echo "</div>";
						?>
						
                    </div>
                    <!--=================== masaonry portfolio end====================-->
                </div>
            </div>
        </div>
        <!--=================== content body end ====================-->
    </div>
</div>


<!-- jquery -->
<script src="http://skuastk.org/ewas/assets/js/jquery.min.js"></script>
<!-- bootstrap -->
<script src="http://skuastk.org/ewas/assets/js/popper.js"></script>
<!--slick carousel -->
<!--Portfolio Filter-->
<script src="http://skuastk.org/ewas/assets/js/imgloaded.js"></script>
<script src="http://skuastk.org/ewas/assets/js/isotope.js"></script>
<!-- Magnific-popup -->
<script src="http://skuastk.org/ewas/assets/js/jquery.magnific-popup.min.js"></script>
<!--Counter-->
<script src="http://skuastk.org/ewas/assets/js/jquery.counterup.min.js"></script>
<!-- WOW JS -->
<script src="http://skuastk.org/ewas/assets/js/wow.min.js"></script>
<!-- Custom js -->
<script src="http://skuastk.org/ewas/assets/js/main.js"></script>
</body>
</html>