<!DOCTYPE HTML>

<html>
	<head>
    <title>Illumina EPIC / 450K / 27K Illumina microarray data analysis - Web portal</title>		
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
		<!--	<font size="+4" color="white"><b><u>EWASP</u> - A comprehensive pipeline for Epigenetic-wide Data Analysis.</b></font> -->
		</div> 
	<!-- Header --> 

	<!-- Main -->
		<div id="main">
			<div class="container">
				<div class="row">

					<!-- Sidebar -->
					<div id="sidebar" class="5u">
						<section>
							<header>
								<h2>Recommended Readings </h2>
							</header>
							<div class="row">
								<section class="15u">
								<ul class="default">
								<li><a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC5864890/">Effect of Batch correction</a></li>
								<li><a href="https://www.ncbi.nlm.nih.gov/pubmed/28410574">Comparision between different Blood cell correction methods</a></li>
								<li><a href="https://www.ncbi.nlm.nih.gov/pubmed/24138928">DNA methylation age of human tissues and cell types</a></li>
								<li><a href="https://bmcbioinformatics.biomedcentral.com/articles/10.1186/1471-2105-11-587">Comparison of Beta-value and M-value for quantifying methylation levels</a></li>
								<li><a href="https://www.ncbi.nlm.nih.gov/pubmed/30669119">DNA methylation GrimAge strongly predicts lifespan and healthspan.</a></li>
								<li><a href="https://bioconductor.org/packages/release/bioc/html/limma.html">LIMMA</a></li>
								<li><a href="https://bioconductor.org/packages/release/bioc/html/minfi.html">MINFI</a></li>
								<li><a href="https://bioconductor.org/packages/release/bioc/html/ChAMP.html">ChAMP</a></p></li>
								<li><a href="http://bioconductor.org/packages/release/bioc/html/REMP.html">REMP</a></p></li>
								<li><a href="https://cran.r-project.org/web/packages/Rfit/index.html">Rank-based Regression</a></p></li>
								<li><a href="https://www.flutterbys.com.au/stats/tut/tut7.1.html">Linear Regression</a></p></li>
								<li><a href="https://link.springer.com/chapter/10.1007/978-3-030-02634-9_12">Gene enrichment analysis</a></p></li>
								</ul>
								</section>
							</div>
						</section>
					</div>
					
					<!-- Content -->
					<div id="content" class="6u skel-cell-important">
					  <section>
						<form method="POST" action="processing.php" enctype="multipart/form-data">
						<p><a href="index.html">Home</a> > Select covariates and phenotype</p><br/>
								<font size="+3" face="Arial"><b>Select Covariates and Phenotype of interest</b></font>
							
							
<?php 

$IP							=		$_SERVER['REMOTE_ADDR'].time();
$cont						=		"";
$case						=		"";
$control					=		"";
$cross_reactive_probes		=		"FALSE";
$xy_chr						=		"FALSE";
$snps						=		"FALSE";
$bval_sel					=		0;
$idat_sel					=		0;
$beta_filesize				=		0;
$anal_type					=		0;
$email						=		"-";
$idat_files					=		"";
$norm_method				=		"";
$norm_method_name			=		"";
$green_final				=		"";  # ids of green samples to be processed
$red_final					=		"";  # ids of red samples to be processed
$samples_processed			=		"";
$method						=		"";
$no_sample					=		0;
$method						=		$_POST['data'];  
$norm_value					=		$_POST['preprocess'];
$arraytype					=		$_POST['arraytype'];
$deconv						=		$_POST['deconv'];
$analysis_type				=		$_POST['analysis_type'];
#$maf						=		$_POST['maf'];

#if($maf	==	'') {
#	$maf	=	1;
#} 

if($method == "1")  { 
	mkdir ($IP, 0777); 
} else {
	$IP				=	$_POST['folder_id'];
}

if (!file_exists($IP)) {
	echo "Please specify correct foldername. Please note foldername is case sensitive, you are requested to enter foldername correctly and <a href=\"index.html\">retry again.</a>";
	exit;
}

if($_FILES['covar']['size'] > 0 ){
	$fileName 		= 	"covar.csv";
    $filetmp 		= 	$_FILES['covar']['tmp_name'];
	$fileSize 		= 	$_FILES['covar']['size'];
	$errors			= 	array();
	if($fileSize > 5120152) {
         $errors[]	=	'Covariate filesize should be less than 5 MB';
    }
	if(empty($errors)  ==  true) {
         move_uploaded_file($filetmp,"$IP/".$fileName);
		 $covar_data1		=		file_get_contents("$IP/$fileName");
		 $covar_data2		=		explode("\n", $covar_data1);
		 $covar_data2[0]	=		preg_replace('/[^A-Za-z0-9_,]/', '', $covar_data2[0]);
		 $covar_header		=		explode(",", $covar_data2[0]);

		 echo "<br/><br/><br/><font size=\"+2\"><b><u>Select phenotype</u></b></font><br/><br/>";
		 echo "<select name=\"pheno_selected\" style=\"width:450px;padding:10px 10px 15px 15px; \">";
			foreach ($covar_header as $val) {
					echo "<option selected value=\"";echo $val;echo "\">";echo $val;echo "</option>";		  
			}
		 echo "</select>";		 
		 
		 echo "<br/><br/><font size=\"+2\"><b><u>Select covariate(s)</u></b></font><br/><br/>";
		 echo "<select name=\"covar_selected[]\" id='pre-selected-options' multiple='multiple' >";
		 foreach ($covar_header as $val) {
				echo "<option value=\"";echo $val;echo "\">";echo $val;echo "</option>";		  
		 }
		 echo "</select>";		 
		
    $covar_data3		=	implode("\n", $covar_data2);
	file_put_contents("$IP/$fileName", "$covar_data3");
	}
} else {
	print "Please upload covariate/phenotype file.";
}

echo "<br/>";

if(isset($_POST['data'])) {
if($method == "1") {
	if($_FILES['idats']['size'] > 0){
		$idat_sel		=		1;
		$countfiles = count($_FILES['idats']['name']);	
		for($i=0; $i<$countfiles; $i++) {
			$filename = $_FILES['idats']['name'][$i];
			move_uploaded_file($_FILES['idats']['tmp_name'][$i], "$IP/".$filename);
			$idat_files	.=		"$filename\n";
		}
		$idat_files1	=		explode("\n", $idat_files);	
		$green			=		preg_grep("/grn/i", $idat_files1);
		$red			=		preg_grep("/red/i", $idat_files1);
		$green			=		str_ireplace("_grn.idat","", $green);
		$red			=		str_ireplace("_red.idat","", $red);
		$d1 			=		array_diff($green, $red);
		$d2				=		array_diff($red, $green);
		$result			=		array_merge($d1, $d2);
		
		if (!empty($result)) {
			echo  "<br/><br/><font size=\"+3\"><b><u>Issue with IDAT files</u></b></font><br/>";
			print "<br/><font size=\"+2\"><b>Following files can't be processed: <br/><br/></b></font>"; 
			
			echo "<div style=\"overflow:scroll; width:400px; height: 100px;\" > "; 
			$i			=		1;
			foreach($result as $val) {
				echo "<div style=\"line-height: 1.15em; font-size: 16px;\"> ";
				echo "$i. \t ";
				echo "<a>";
				print "$val</div><br/>";
				echo "</a>";
				$i++;
			}
			echo "</div>";
			}		
		$green_final		=		array_diff($green, $result);  # final samples to be processed for bvalue calculation.
		$red_final			=		array_diff($red, $result);    # final samples to be processed for bvalue calculation.
		$samples_processed	=		implode("##", $green_final);
		
		#print_r($green_final);
		#print_r($red_final);
		#print "<br/>Processed samples : $samples_processed<br/>";
	}
}
	if($method == "2") {
		$green			=		"";
		$red			=		"";
		$files 		=		scandir($IP);		
		foreach ($files as $idat)	{
			if (preg_match("/_Red.idat/", $idat))  {
					$red		.=		"$idat**";
				}
			if (preg_match("/_Grn.idat/", $idat))  {
					$green		.=		"$idat**";
				}
		}
		$red_files		=		explode("**", $red);
		$green_files	=		explode("**", $green);
		
		$green			=		str_ireplace("_grn.idat","", $green_files);
		$red			=		str_ireplace("_red.idat","", $red_files);
		$d1 			=		array_diff($green, $red);
		$d2				=		array_diff($red, $green);
		$result			=		array_merge($d1, $d2);
		
		if (!empty($result)) {
			echo  "<br/><br/><font size=\"+3\"><b><u>Issue with IDAT files</u></b></font><br/>";
			print "<br/><font size=\"+2\"><b>Following files can't be processed: <br/><br/></b></font>"; 
			
			echo "<div style=\"overflow:scroll; width:400px; height: 100px;\" > "; 
			$i			=		1;
			foreach($result as $val) {
				echo "<div style=\"line-height: 1.15em; font-size: 16px;\"> ";
				echo "$i. \t ";
				echo "<a>";
				print "$val</div><br/>";
				echo "</a>";
				$i++;
			}
			echo "</div>";
			}		
		$green_final		=		array_diff($green, $result);  # final samples to be processed for bvalue calculation.
		$red_final			=		array_diff($red, $result);    # final samples to be processed for bvalue calculation.
		$no_sample			=		sizeof($green_final);
		$samples_processed	=		implode("##", $green_final);
	}
}

if(isset($_POST['array_corr'])) {
	$array_corr		=	"ON";	
} else {
	$array_corr		=	"OFF";
}

if(isset($_POST['batch_corr'])) {
	$batch_corr		=	"ON";	
} else {
	$batch_corr		=	"OFF";
}

if(isset($_POST['cross_reactive'])) {
   $cross_reactive_probes	=		"TRUE";	
}

if(isset($_POST['xy_chr'])) {
   $xy_chr			=		"TRUE";	
}

if(isset($_POST['snps'])) {
   $snps			=		"TRUE";	
}

if(isset($_POST['email'])) {
	$email			=		$_POST['email'];
	echo "<font size=\"+2\"><br/>Result will be forwarded to <u><b>$email</b></u></font><br/><br/><br/>";
}

if(isset($_POST["preprocess"])) {
	switch ($_POST['preprocess']){
		case 1:
			$norm_method		=		"preprocessRaw";
			$norm_method_name	=		"Raw - No Normalization";
			break;
		case 2:
			$norm_method		=		"preprocessQuantile";
			$norm_method_name	=		"Quantile Normalization";
			break;
		case 3:
			$norm_method		=		"preprocessIllumina";
			$norm_method_name	=		"Illumina - Genome Studio Normalization";
			break;
		case 4:
			$norm_method		=		"preprocessNoob";
			$norm_method_name	=		"NOOB Normalization";
			break;
		case 5:
			$norm_method		=		"preprocessSWAN";
			$norm_method_name	=		"SWAN Normalization";
			break;
		case 6:
			$norm_method		=		"preprocessFunnorm";
			$norm_method_name	=		"Functional Normalization";
			break;
		case 7:
			$norm_method		=		"BMIQ";
			$norm_method_name	=		"BMIQ Normalization";
			break;
		case 8:
			$norm_method		=		"PBC";
			$norm_method_name	=		"PBC Normalization";
			break;
	}	
}

/*
if(isset($_POST['conf_factors'])) {
   	$conf_factors				=		$_POST["conf_factors"];
	$CFs						=		explode (",", $conf_factors);
	$CFs_len					=		count($CFs);
	print "Confounding factors : " .$CFs_len. ".\n";
	foreach ($CFs as &$value) {
		print "<br/>";
		print $value;
}
}
*/

if($_FILES['beta_value']['size'] > 0 && $idat_sel == 0){
	$bval_sel				=	1;
	move_uploaded_file($_FILES['beta_value']['tmp_name'],"$IP/".$_FILES["beta_value"]["name"]);
	$beta_filesize				=		$_FILES['beta_value']['size'];
	print "<br/>Beta file size : $beta_filesize <br/>";
}

if(isset($_POST['anal_type'])) {
   	if($_POST['anal_type'] == 1) {
		$anal_type				=		1;
		print "<br/>You selected contineous analysis type.<br/>";
		$cont					=		$_POST['cont'];
		$cont_var1				=		explode("\n", $cont);
		foreach ($cont_var1 as $values) {
			print "$values<br/>";			
		}
	}
	else {
		if($_POST['anal_type'] == 2) {
		$anal_type				=		2;
		print "<br/>You selected case/control study type.<br/>";
		$case					=		$_POST['case'];
		$control				=		$_POST['control'];		
		$case_var1				=		explode("\n", $case);
		$control_var1			=		explode("\n", $control);
		print_r($case_var1);
		print_r($control_var1);
	}
	}
}

echo "<input type=\"hidden\" name=\"samples\" value=\"";   echo "$IP**$samples_processed**$norm_method**$email**$snps**$xy_chr**$cross_reactive_probes**$norm_value**$arraytype**$deconv**$analysis_type**$array_corr**$batch_corr**$norm_method_name";   echo "\"";
	/* 
	Hidden elements contain 
		0. IP address 
		1. samples to be processed 
		2. Normalization method 
		3. Email ID
		4. Decision SNPs
		5. Decision on XY-Chr probes
		6. Decision on Cross-Reactive probes
		7. Normalization Value (1 .. 7) 1 .. 5 for minfi; 6 .. 7 for ChAMP
		8. Arraytype
		9. Blood cell deconvulution
	   10. Analysis type
	   11. Array Correction yes/no
	   12. Batch Correction yes/no
	   13. Normalization name/string
	*/
?>
								<div class="ph-container">
									<div class="ph-float">
										<input type="submit" value="RUN EWAS" class='ph-button ph-btn-blue' />
									</div>   
								</div> 
							</form>
						  </section>
					</div>
				</div>
			</div>
		</div>
	<!-- /Main -->

	<!-- Tweet -->
		<div id="tweet">
			<div class="container">
				<!--
				<section>
					<blockquote> &ldquo;Some quote goes here . . .&rdquo; </blockquote>
				</section>
				-->
			</div>
		</div>
	<!-- /Tweet -->
	
	
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.multi-select.js"></script>
	<script type="text/javascript">
	// run pre selected options
	$('#pre-selected-options').multiSelect();
	</script>
  
  
	</body>
</html>
