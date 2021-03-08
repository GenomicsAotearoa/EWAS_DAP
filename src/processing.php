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
                <!--    <font size="+4" color="white"><b><u>EWASP</u> - A comprehensive pipeline for Epigenetic-wide Data Analysis.</b></font> -->
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
						<p><a href="index.html">Home</a> > Running - EWAS</p><br/>
							<header>
								<h2>Running - EWAS</h2>
							</header>

							
<?php 	
$covar				=		"";
$pheno				=		"";
$norm_method		=		"";
$pheno_final		=		"";
$snp				=		"";
$xy_chr				=		"";
$cr_probes			=		"";
$array_type			=		"";
$email				=		"-";
$design_matrix		=		"-";
$com_group			=		"";

$no_samples			=		0;
$number_of_samples	=		0;
$number_of_covar	=		0;
$norm_value			=		0;
$deconv				=		0;

if(isset($_POST['pheno_selected'])) {
$pheno			=		$_POST['pheno_selected'];
if($pheno == "ID") {
	print "Selected phenotype is incorrect, ID cannot be Phenotype.<br/>";
	echo "<a href=\"index.html\">Click here</a> to retry.<br/>";
	exit();
}
}

if(isset($_POST["covar_selected"])) {
$covar				=		$_POST['covar_selected'];
$covar				=		array_merge(array_diff($covar, array("ID")));
$number_of_covar	=		count ($covar);
$covar				=		implode (",", $covar);
print "Covariate selected : $covar ($number_of_covar)<br/>";
} else {
	print ("No covar selected.</br/>");
}


if(isset($_POST["samples"])) {
$temp1			=		explode ("**", $_POST["samples"]);
$ip			=		$temp1[0];                 # folder for storing info
$norm_method		=		$temp1[2];                 # normalization method
$email			=		$temp1[3];                 # email ID
$snp			=		$temp1[4];
$xy_chr			=		$temp1[5];
$cr_probes		=		$temp1[6];
$norm_value		=		intval($temp1[7]);
$arraytype		=		intval($temp1[8]);
$deconv			=		intval($temp1[9]);
$com_group		=		intval($temp1[10]);
$array_corr		=		$temp1[11];
$batch_corr		=		$temp1[12];
$norm_name		=		$temp1[13];



if($arraytype == 1) {
	$array_type		=		"EPIC";	
} else {
	$array_type		=		"450K";
}
$samples			=		explode ("##", $temp1[1]); # samples to used in analysis
$number_of_samples		=		count ($samples);

$covar = preg_replace('/[^A-Za-z0-9_,]/', '', $covar);
$pheno = preg_replace('/[^A-Za-z0-9_,]/', '', $pheno);


if($number_of_covar > 0) {
	$covar_file1			=	shell_exec("sws/csvtk cut -f ID,$covar,$pheno $ip/covar.csv");
} else {
	$covar_file1			=	shell_exec("sws/csvtk cut -f ID,$pheno $ip/covar.csv");	
}


$covar_file2			=	explode("\n", $covar_file1);
$covar_file5			=	"";

foreach ($samples as $val) {
	if($val != NULL) {
	  $covar_file3		=	preg_grep("/$val/i", $covar_file2);
		if($covar_file3 != NULL) {
			$covar_file4		=	implode(",", $covar_file3);
			$ids				=	explode(",", $covar_file4);
			$array				=	explode("_", $ids[0]);
			$covar_file5		.=	$covar_file4.",$array[0],$array[1],NA,NA,NA,NA\n";
		}
	}
}


$covar_file6		=		explode("\n", $covar_file5);
$number_of_samples	=		sizeof($covar_file6);
#print "<br/>Number of Samples : $number_of_samples";

if ($number_of_samples < 2) {
	print "Can't proceed with the input files. Number of samples are not adequate for analysis.<br/>";
	echo "<a href=\"index.html\">Click here</a> to retry.<br/>";
	exit();
}

$covar_file5		=		$covar_file2[0].",Sentrix_ID,Sentrix_Position,Pool_ID,Sample_Plate,Sample_Well,Project\n".$covar_file5;  ###Final covariate file 
$covar_file5		=		preg_replace('/[^A-Za-z0-9_,\.\\n]/', '', $covar_file5);

if(file_put_contents("$ip/covar_final.csv", $covar_file5)) {
	echo "<br/><br/><a href=\"$ip/covar_final.csv\">Download final covariate file.</a><br/><br/>";										
} else {
	print "We are facing some problem in selecting covariates.<br/> Please check covariate file, possible error could be <br/> 1. 'ID' column is not present in covariate file. <br/> 2. Multiple delimiters in covariate file. ";
	print "<a href=\"index.html\">Click here</a> to retry.<br/>";
	exit;
}

$pheno			=	"myLoad\\\$pd\\\$".$pheno;
if($number_of_covar > 0) {
	$design_matrix	=	"";
	foreach ($_POST['covar_selected'] as $val) {
		$design_matrix	.=	"myLoad\\\$pd\\\$".$val.",";	
	}
}
}

permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

foldername = substr(str_shuffle($permitted_chars), 0, 20);


#rename("$ip/covar.csv", "$ip/covar.txt");
unlink("$ip/covar.csv");
$norm_method_selection		=	0;  
if($number_of_samples < 250 && $norm_value < 6) {
	$norm_method_selection		=	2;	#norm_method_selection = 2 i.e. minfi is selected for normalization
} else {
	$norm_method_selection		=	1;	#norm_method_selection = 1 i.e. champ is selected for normalization
	
}

copy("r_script_LDS.R", "$ip/run.R");
#shell_exec("export LD_LIBRARY_PATH=/lib64:/usr/lib64:/usr/lib64/R/lib && nohup Rscript /opt/lampp/htdocs/ewas/ewas_pip/$ip/run.R $ip $norm_method $email $snp $xy_chr $cr_probes $pheno $design_matrix $norm_method_selection $array_type $deconv $com_group $array_corr $batch_corr $foldername > file.out 2> file.error < /dev/null &");

shell_exec("LD_LIBRARY_PATH=/lib64:/usr/lib64:/usr/lib64/R/lib nohup Rscript $ip/run.R $ip $norm_method $email $snp $xy_chr $cr_probes $pheno $design_matrix $norm_method_selection $array_type $deconv $com_group $array_corr $batch_corr $norm_name $foldername > $ip/file.out 2> $ip/file.error < /dev/null &");

#shell_exec("start Rscript C:/xampp/htdocs/ewas_dap/$ip/run.R $ip $norm_method $email $snp $xy_chr $cr_probes $pheno $design_matrix $norm_method_selection $array_type $deconv $com_group $array_corr $batch_corr > log.txt 2> errors.txt");
	/* 
	Hidden elements contain 
		1. IP address
		2. Normalization method 
		3. Email ID
		4. Decision SNPs
		5. Decision on XY-Chr probes
		6. Decision on Cross-Reactive probes
		7. Phenotype of interest
		8. Covariates adjust for
		9. Normalization Value (1 .. 7) 1 .. 5 for minfi; 6 .. 7 for ChAMP
	   10. Arraytype
	   11. Blood cell deconvulution
	   12. Comparision type
	   13. Array Correction yes/no
	   14. Batch Correction yes/no
	   15. Output folder name

	*/
	$out_link	=	"https://jupyter.nesi.org.nz/user-redirect/EWASP/reports/output.php?result_id=".$foldername;
?>

	<font size="+2">Your job is running.</font>
	<br/><br/>
	<a href="<?php echo "$out_link"; ?>" target="_blank"> Click here for output page. </a><br/><br/>
	Link to the output page will be shared at <b><?php echo "$email"; ?></b>
	<br/>
							
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
