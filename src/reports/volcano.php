<html>
<head>
		<title>Volcano plot</title>
		<script src="http://skuastk.org/ewas/JS_HighCharts/highcharts.js"></script>
		<script src="http://skuastk.org/ewas/JS_HighCharts/boost.js"></script>
		<script src="http://skuastk.org/ewas/JS_HighCharts/exporting.js"></script>
</head>
<style>
.highcharts-figure, .highcharts-data-table table {
    min-width: 400px; 
    max-width: 600px;
    margin: 1em auto;
}
</style>

<body>

<figure class="highcharts-figure"><div id="container"></div></figure>



			<?php
				if (isset($_GET['data'])) {
					 $data		=	$_GET['data'];
				} else {
					echo "Error in processing data, try again or contact administrator.";
					exit();
				}
				$result_id       =   $_GET['result_id'];
                $target_folder   = "/mnt/data/uploads/results/" . $result_id;
                chdir($target_folder);
				$file_snps			=	"graph_plotting_snps_" . $data . ".csv";
				$file_non_snps		=	"graph_plotting_non_snps_" . $data . ".csv";
				
				$data_snp			=	file_get_contents($file_snps);
				$data_snp			=	str_replace("\"","", $data_snp);
				$data_snp			=	str_replace("\n",",", $data_snp);
				$data_snp			=	"[$data_snp]";
				$data_snp			=	str_replace(",]", "]", $data_snp);			
				
				$data_non_snp		=	file_get_contents($file_non_snps);
				$data_non_snp		=	str_replace("\"","", $data_non_snp);
				$data_non_snp		=	str_replace("\n",",", $data_non_snp);
				$data_non_snp		=	"[$data_non_snp]";
				$data_non_snp		=	str_replace(",]", "]", $data_non_snp);
				
				
				echo "<input type=\"hidden\" id=\"DP_SNP\"     name=\"DP_SNP\"     value=\"$data_snp\"     /> ";
				echo "<input type=\"hidden\" id=\"DP_Non_SNP\" name=\"DP_Non_SNP\" value=\"$data_non_snp\" /> ";
				
				
				?>
	
				<script type="text/javascript">
								
					var SNPs			=	eval(document.getElementById("DP_SNP").value);
					var Non_SNPs		=	eval(document.getElementById("DP_Non_SNP").value);
					
					if (!Highcharts.Series.prototype.renderCanvas) {
						throw 'Module not loaded';
					}

					console.time('scatter');
					Highcharts.chart('container', {

						chart: {
							zoomType: 'xy',
							type: 'scatter',
							height: '100%'
						},

						boost: {
							useGPUTranslations: true,
							usePreAllocated: true
						},

						xAxis: {
							//min: -1,
							//max: 1,	
							
							gridLineWidth: 1,
							title: {
								text: '<span style="font-size: 16px">LOG(FC)</span>'
							}
						},

						yAxis: {
							// Renders faster when we don't have to compute min and max
							//min: 0,
							//max: 10,
							
							minPadding: 0,
							maxPadding: 0,
							title: {
								text: '<span style="font-size: 16px">LOG(P-Value)</span>'
							}
						},

						title: {
							text: 'Volcano plot'
						},

						legend: {
							enabled: true
						},

						series: [{
							name: 'Non-SNP',
							color: 'rgb(192, 48, 167)',
							fillOpacity: 0.5,
							data: Non_SNPs,
							turboThreshold:9000000,
							marker: {
								radius: 2
							},
							tooltip: {
								followPointer: false,
								pointFormat: '[{point.name}]'
							}
						},
						{
							name: 'SNP',
							color: 'rgb(82, 215, 132)',
							fillOpacity: 0.5,
							data: SNPs,	
							turboThreshold:9000000,
							marker: {
								radius: 2
							},
							tooltip: {
								followPointer: false,
								pointFormat: '[{point.name}]'
							}
						}
						]

					});
					console.timeEnd('scatter');
					
					
				</script>
		
</body>
</html>
        
