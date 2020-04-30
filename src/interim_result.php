<!DOCTYPE html>
<html lang="">
<head>
  
  <title>Title Page</title>
  <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/multi-select.css">
</head>
<body>

<?php 

$IP							=		$_SERVER['REMOTE_ADDR'].time();
$pvalue 					=		$_POST["pvalue"];
$conf_factors				=		"";

$cont						=		"";
$case						=		"";
$control					=		"";

$cross_reactive_probes		=		0;
$xy_chr						=		0;
$snps						=		0;
$bval_sel					=		0;
$idat_sel					=		0;
$covar_sel					=		0;
$beta_filesize				=		0;
$anal_type					=		0;
$idat_files					=		"";
$green_final				=		""; #array containing ids of green samples to be processed
$red_final					=		"";  #array containing ids of red samples to be processed



mkdir ($IP, 0755);

if(isset($_POST['cross_reactive'])) {
   $cross_reactive_probes	=		1;	
}

if(isset($_POST['xy_chr'])) {
   $xy_chr					=		1;	
}

if(isset($_POST['snps'])) {
   $snps					=		1;	
}

if(isset($_POST["preprocess"])) {
	print "Preprocessing Method selected :" .$_POST['preprocess']."<br/>";
	
}


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

if($_FILES['covar']['size'] > 0 ){
	$covar_sel					=		1;
	$fileName = $_FILES["covar"]["name"];
    $filetmp = $_FILES['covar']['tmp_name'];
	$fileSize = $_FILES['covar']['size'];
	$errors= array();
	if($fileSize > 5120152) {
         $errors[]='File size must be less than 5 MB';
    }
	if(empty($errors)==true) {
         move_uploaded_file($filetmp,"$IP/".$fileName);
         echo "File uploaded Successfully.<br/>";
		 $covar_data1		=		file_get_contents("$IP/$fileName");
		 $covar_data2		=		explode("\n", $covar_data1);
		 $covar_header		=		explode(",", $covar_data2[0]);
		 echo "<h1>Select covariate(s)</h1>";
		 echo "<select name=\"covar_selected\" id='pre-selected-options' multiple='multiple'>";
		 foreach ($covar_header as $val) {
				echo "<option value=\"";echo $val;echo "\">";echo $val;echo "</option>";		  
		 }
		 echo "</select>";
		 
		 echo "<h1>Select phenotype</h1>";
		 echo "<select name=\"pheno_selected\">";
		 foreach ($covar_header as $val) {
				echo "<option value=\"";echo $val;echo "\">";echo $val;echo "</option>";		  
		 }
		echo "</select>";
    }
} else {
	print "Covariate file not selected.";
}


if($_FILES['idats']['size'] > 0){
	$idat_sel					=		1;
	$countfiles = count($_FILES['idats']['name']);	
	for($i=0; $i<$countfiles; $i++) {
		$filename = $_FILES['idats']['name'][$i];
		move_uploaded_file($_FILES['idats']['tmp_name'][$i], "$IP/".$filename);
		print "<br/>Uploaded file : $filename";
		$idat_files				.=		"$filename\n";
	}
	print("<br/>");
	$idat_files1				=		explode("\n", $idat_files);
	
	$green						=		preg_grep("/grn/i", $idat_files1);
	$red						=		preg_grep("/red/i", $idat_files1);
	$green = str_ireplace("_grn.idat","", $green);
	$red = str_ireplace("_red.idat","", $red);
		
	$d1 						=		array_diff($green, $red);
	$d2							=		array_diff($red, $green);
	$result						=		array_merge($d1, $d2);
	
	if (empty($result)) {
		echo "<br/>Sample are consistant.</br>";
	}
	else {
		print "<br/>Some inconsistancy where found in samples files. File "; 
		foreach($result as $val) {
			print "$val ";
		}
		print " seems not correct.</br>";
	}
	
	$green_final				=		array_diff($green, $result);
	$red_final					=		array_diff($red, $result);
	
	print "Samples to be processed are: ";
	if (!empty($green_final)) {
	foreach($green_final as $val) {
			print "$val ";
		}		
	} else {
		print "None.<br/>";
	}
	print "<br/><br/>";
}


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



print("<br/><br/>Upload folder : ".$IP."<br/>");
print("Pvalue : ".$pvalue."<br/>");
print("Cross_reactive Probes :" .$cross_reactive_probes."<br/>");
print("Non-Autosomal sites :" .$xy_chr."<br/>");
print("SNPs :" .$snps."<br/>");
print("Confonding factors :" .$conf_factors."<br/>");


?>
  
  
  
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.multi-select.js"></script>
  <script type="text/javascript">
  // run pre selected options
  $('#pre-selected-options').multiSelect();
  </script>
  
  
</body>

</html>