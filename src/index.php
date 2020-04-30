<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Illumina EPIC / 450K / 27K Illumina microarray data analysis - Web server</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
	<link href="css/hide-show-fields-form.css" rel="stylesheet"/>


    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
	
	<script type="text/javascript">
		function adjust_textarea(h) {
			h.style.height = "20px";
			h.style.height = (h.scrollHeight)+"px";
		}
	</script>
	
	<script type="text/javascript" language="javascript">
		function checkfile(sender) {
			var validExts = new Array(".IDAT", ".idat");
			var fileExt = sender.value;
			fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
			if (validExts.indexOf(fileExt) < 0) {
			  alert("Invalid file selected, valid file formats are of " +
					   validExts.toString() + " types.");
			  return false; 
			}
			else return true;
		}
		function upload_beta(sender) {
			var validExts = new Array(".csv");
			var fileExt = sender.value;
			fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
			if (validExts.indexOf(fileExt) < 0) {
			  alert("Invalid file selected, valid file format is " +
					   validExts.toString() + " types.");
			  return false;
			}
			else return true;
		}
	</script>

</head>

<body>

    <div class="main">
        <div class="container">
            <form method="POST" id="signup-form" class="signup-form" action="preview.php" enctype="multipart/form-data">
                <div>
                    <h3>Raw data input</h3>
                    <fieldset>	
						<table>
							<tr>
								<td align="center">
									<h2><u>EWASP</u> - A Comprehensive data analysis pipeline for Population-based EWAS</h2>									
								</td>
								<td style="display: block;">
									<img src="img/ga_logo.jpeg" width="350px" />
								</td>
							</tr>
						</table>
                        
						<div class="cd-tabs js-cd-tabs">
							<nav>
								<ul class="cd-tabs__navigation js-cd-navigation">
									<li><a data-content="inbox" class="cd-selected" href="#0">Upload IDAT file</a></li>
									<li><a data-content="new" href="#0">Upload Beta-Values</a></li>

								</ul>
							</nav>

								<script>
								function upload() {
								document.getElementById("folder_id").disabled=false;
								document.getElementById("idats").disabled=true;
								document.getElementById("idat_button").style.backgroundColor = "#15203e";
								document.getElementById("upload_button").style.backgroundColor = "#6e7a9a";
								
								}
								function server() {
								document.getElementById("idats").disabled=false;
								document.getElementById("folder_id").disabled=true;
								document.getElementById("idat_button").style.backgroundColor = "#6e7a9a";
								document.getElementById("upload_button").style.backgroundColor = "#15203e";
								}
								</script>

							<ul class="cd-tabs__content js-cd-content">
								<li data-content="inbox" class="cd-selected">
									<table width="100%" >
										<tr >
											<td width="8%" bgcolor="#15203e">												
												<input type="radio" name="data" value = "1" onclick="server()" style="height: 1.5em" >
											</td>
											<td width="37%">
												<input type="button" value="Upload IDAT files" style="font-size: 22px;background-color: #15203e;color:white; padding:10px 24px;" />
											</td>
											<td width="5%" ></td>
											<td width="8%" bgcolor="#15203e">
												<input type="radio" name="data" value = "2" onclick="upload()" style="height: 1.5em" />
											</td>											
											<td width="37%">											
												<input type="button" value="Enter foldername" style="font-size: 22px;background-color: #15203e; color:white; padding:10px 24px;" />																						</td>
											</td>
										</tr>
										<tr>
											<td colspan="2"><input type="file" onchange="checkfile(this);" id="idats" name="idats[]" disabled="disabled" allowdirs multiple /></td>
											<td width="5%"></td>
											<td colspan="2"><input type="text" name="folder_id" placeholder="Enter foldername" id="folder_id" disabled="disabled" autocomplete = "OFF" height="50px" width="200px"></td>
										</tr>
									</table>
									<div class="dark-wrapper">
										<b><font size = "+2">Select Preprocessing method&nbsp;&nbsp;</font></b>
										<div class="tooltip"><img src="images/help.png" width="20px" height="20px" />
										  <span class="tooltiptext">
											We currently recommend using Illumina (Genome Studion) Normalisation
										  </span>
										</div>
										<select name="preprocess" class="select-css">
											<option value="1">Raw Normalization (No normalization)</option>
											<option value="2">Quantile Normalization</option>
											<option value="3" selected>Illumina (Genome Studio) Normalization (recommended)</option>
											<option value="4">Noob Normalization</option>
											<option value="5">SWAN Normalization</option>
											<option value="6">FUNNORM Normalization</option>
											<option value="7" >BMIQ Normalization</option>
											<option value="8">PBC Normalization</option>
											<option value="7">Noob + BMIQ Normalization (recommended but slow)</option>
											<option value="7">Funnorm + BMIQ Normalization</option>
											<option value="7">SWAN + BMIQ Normalization</option>
											<option value="8">Noob + PBC Normalization</option>
											<option value="8">Funnorm + PBC Normalization</option>
											<option value="8">SWAN + PBC Normalization</option>
											<option value="7">Noob + Quantile Normalization</option>
										</select>
									</div>
									
									<div class="dark-wrapper">
										<b><font size = "+2">Blood cell deconvolution method&nbsp;&nbsp;</font></b>
										<div class="tooltip"><img src="images/help.png" width="20px" height="20px" />
										  <span class="tooltiptext">
												Selecting the Houseman Extended method will generate blood cell coefficients that will be automatically loaded as covariates to correct for blood cell composition.
										  </span>
										</div>
										<select class="select-css" name="deconv">
											<option value = "0" selected></option>
											<option value = "1">Extended Housemann (recommended)</option>
										</select>
									</div>
								</li>

								<li data-content="new">

								<b><font size = "+3">Upload Beta-value file:&nbsp;&nbsp;</font></b>
								<div class="tooltip"><img src="images/help.png" width="20px" height="20px" />
								  <span class="tooltiptext">
									  Format for beta value data file
									<img src="img/beta.png" height="350px"> 
								  </span>
								</div>				
								<br/><br/>
									<input type="file" name="beta_value" value="beta_value" id="beta_value" onchange="upload_beta(this);">
								
								
									<div class="dark-wrapper">
										<b><font size = "+2">Select Preprocessing method&nbsp;&nbsp;</font></b>
										<div class="tooltip"><img src="images/help.png" width="20px" height="20px" />
										  <span class="tooltiptext">
												Recommended is BMIQ for Beta-Value Normalisation
										  </span>
										</div>
										<select name="preprocess_beta" class="select-css">
											<option value="1">BMIQ Normalization (recommended)</option>
											<option value="2">PBC Normalization</option>											
										</select>
									</div>									
								</li>		
							</ul> <!-- cd-tabs__content -->
							<h4>This work was supported by Genomics Aotearoa – a New Zealand Ministry of Business, <br/>Innovation and Employment funded research platform.</h4>
						</div>
                    </fieldset>

                    <h3>Phenotype data input</h3>
                    <fieldset>
						<table>
							<tr>
								<td>
									<h1>Upload Phenotypic data and Covariates file</h1>
								</td>
								<td style="display: block; margin: 0 0 0 40%; ">
									<img src="img/ga_logo.jpeg" width="300px" />
								</td>
							</tr>
						</table>                        
							<div class="fieldset-content">
																									
								<h2>Upload annotation file (.csv only):</h2>
								<input type="file" name="covar" id="covar" value="covar" onchange="upload_beta(this);" required />
								<br/><br/>
								<input type="text" name="email" placeholder="Enter your email ID" autocomplete="off" required /></td>								
								<br/><h2>Sample annotation file</h2>
								<img src="img/sample_table.png" width="60%" height="50%" style="margin-left: auto; margin-right: auto;display: block;"  />
								
								<!--
								<div class="form-group">
									<h2>Select analysis type</h2><br/>
										<table>
										<tr>
										<td width="40%">
											<div>
											  <input type="radio" name="anal_type" value="1" style="height:15px;width:15px;margin:auto;" id="choice-animals-cats"  />
											  <label for="choice-animals-cats" style="margin:auto;"><font size="+1">Contineous variable analysis</font></label>
											
											  <div class="reveal-if-active">
												<textarea name ="cont" cols="40" rows="5" placeholder="Enter data (Sample ID,value)" style="overflow:auto; font-size:20px;"  ></textarea>
											  </div>
											</div>										
										</td><td width="20%"></td>
										<td width="40%" style="text-align:center">
											<div>
											  <input type="radio" name="anal_type" value="2" style="height:15px;width:15px;margin:auto;" id="choice-animals-dogs"  />
											  <label for="choice-animals-dogs" style="margin:auto;"><font size="+1"> Case / Control study</font></label>
											  <div class="reveal-if-active">
												<textarea name ="case" cols="40" rows="5" placeholder="Enter case sampleIDs" style="overflow:auto; font-size:20px;"  ></textarea>
												<textarea name ="control" cols="40" rows="5" placeholder="Enter control sampleIDs" style="overflow:auto; font-size:20px;"  ></textarea>
											  </div>
											</div>
										</td>
										</tr>
										</table>									
								</div>
								-->
							
                            
                        </div>
                    </fieldset>

					<h3>Advanced options</h3>
                    <fieldset>

						<table>
							<tr>
								<td>
									<h1><u>Advanced options</u></h1>
								</td>
								<td style="display: block; margin: 0 0 0 150%; ">
									<img src="img/ga_logo.jpeg" width="300px" />
								</td>
							</tr>
						</table>
                        
                        <div class="fieldset-content">
						<table>
							<tr width = "90%">
								<td width = "60%" align="center"><h4><font size = "+2"> Select array-type </font></h4></td>
								<td width = "40%" colspan="2" align="center">																
								<select name="arraytype" class="select-css">
									<option value="1">EPIC array</option>
									<option value="2">450K array</option>	
									<option value="2">27K array</option>								
								</select>									
								</td>								
							</tr>
							<tr width = "90%">
								<td width = "60%" align="center"><h4><font size = "+2"> Select comparision group type</font></h4></td>
								<td width = "40%" colspan="2" align="center">																
								<select name="analysis_type" class="select-css">
									<option value="1">Catagorical variable</option>
									<option value="2">Continuous (normal distribution)</option>									
									<option value="3">Continuous (non-normal distribution)</option>									
								</select>									
								</td>								
							</tr>
							<tr width = "90%">
								<td width = "50%" align="center"><h4><font size = "+2"> Filters out cross-reactive (non specific) sites </font></h4></td>
								<td width = "25%" align="center"><label class="switch">
									<input type="checkbox" name="cross_reactive" checked><span class="slider round"></span></label>
								</td>
								<td width = "20%">
									<div class="tooltip"><img src="images/help.png" width="25px" height="25px" />
									  <span class="tooltiptext">
										Setting this option will remove all non specific sites from the data according to Chen et al. and McCartney et al. <b>Recommended to remove cross-reactive probes from data.</b>
									  </span>
									</div>								
								</td>
							</tr>
							
							<tr width = "90%">
								<td width = "50%" align="center"><h4><font size = "+2"> Remove non-autosomal sites </font></h4></td>
								<td width = "25%" align="center"><label class="switch">
									<input type="checkbox" name="xy_chr"><span class="slider round"></span></label>
								</td>
								<td width = "20%">
									<div class="tooltip"><img src="images/help.png" width="25px" height="25px" />
									  <span class="tooltiptext">
										Setting this option will remove all CPG sites in chromosomes X and Y. <b>Not recommended </b> in most analyses.  

									  </span>
									</div>
								</td>
							</tr>
							
							<tr width = "90%">
								<td width = "50%" align="center">
									<h4>																		
										<font size = "+2"> Remove polymorphic sites </font>
									</h4>
								</td>
								<td width = "25%" align="center"><label class="switch">
									<input type="checkbox" name="snps"><span class="slider round"></span></label>
								</td>
								<td width = "20%">
									<div class="tooltip"><img src="images/help.png" width="25px" height="25px" />
									  <span class="tooltiptext">
										Setting this option will remove all CpG sites that are known to be associated with a SNP (mQTLs).  <b>This option is not recommended.</b> mQTLs are easily identified by examining B-value plots 
									  </span>
									</div>
								</td>
								<!--<td width = "20%">
									<input  type="number" placeholder="Enter MAF" name="maf" step="0.01" min="0" max="1"/>																	
								</td>-->								
							</tr>
							<tr width = "90%">
								<td width = "50%" align="center"><h4><font size = "+2"> Batch correction </font></h4></td>
								<td width = "25%" align="center"><label class="switch">
									<input type="checkbox" name="batch_corr"><span class="slider round"></span></label>
								</td>
								<td width = "20%">
									<div class="tooltip"><img src="images/help.png" width="25px" height="25px" />
									  <span class="tooltiptext">
										This option adjusts the analysis for inter-array variations. <b>Recommended</b>
									  </span>
									</div>
								</td>
							</tr>
							<tr width = "90%">
								<td width = "50%" align="center"><h4><font size = "+2"> Array position correction </font></h4></td>
								<td width = "25%" align="center"><label class="switch">
									<input type="checkbox" name="array_corr"><span class="slider round"></span></label>
								</td>
								<td width = "20%">
									<div class="tooltip"><img src="images/help.png" width="25px" height="25px" />
									  <span class="tooltiptext">
										This option adjusts the analysis for intra-array (sample position) variations. <b>Recommended</b>
									  </span>
									</div>
								</td>
							</tr>


						</table>
						
						<!--<input type="text" name="pvalue" placeholder="Enter P-Value cut-off (Optional)" autocomplete="off" min="0" max="1"/> -->
						<br/>
                        </div>
						
						<input type="Submit" value="Submit data" name="submit" style="background:#4966b1;color:#fff;width:400px;margin:0 auto;"/>
					</fieldset>			
					
                </div>				
            </form>
        </div>
    </div>
	<!-- For editing preview go to main.js line 54 
		Change name on finish:"" vendor/jquery-steps/jaquery-stepsmin.js file
	-->
    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendor/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="vendor/jquery-steps/jquery.steps.min.js"></script>
    <script src="vendor/minimalist-picker/dobpicker.js"></script>
    <script src="vendor/nouislider/nouislider.min.js"></script>
    <script src="vendor/wnumb/wNumb.js"></script>
    <script src="js/main.js"></script>
	<script src="js/main2.js"></script>
	<script src="js/hide-show-fields-form.js"></script>


</body>

</html>
