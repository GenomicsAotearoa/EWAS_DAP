<html>
<head>
		<title>Manhattan plot</title>
		<script src="http://skuastk.org/ewas/JS_HighCharts/highcharts.js"></script>
		<script src="http://skuastk.org/ewas/JS_HighCharts/exporting.js"></script>
</head>
<body>

<div id="container" style="min-width: 310px; height: 800px; max-width: 800px; margin: 0 auto"></div>

			<?php
				error_reporting(0);
				if (isset($_GET['data'])) {
					 $data		=	$_GET['data'];
				} else {
					echo "Error in processing data, try again or contact administrator.";
					exit();
				}
				$result_id       =   $_GET['result_id'];
                $target_folder   = "/mnt/data/uploads/results/" . $result_id;
                chdir($target_folder);
				$file				=	"manhattan_plotting_" . $data . ".csv";
				$data				=	file_get_contents($file);
				$data				=	str_replace("\"","", $data);
				$data				=	str_replace(" ","", $data);
				$data_lines			=	explode("\n", $data);
				
				
				$chr1				=	"["; $chr2				=	"["; $chr3				=	"["; $chr4				=	"[";
				$chr5				=	"["; $chr6				=	"["; $chr7				=	"["; $chr8				=	"[";
				$chr9				=	"["; $chr10				=	"["; $chr11				=	"["; $chr12				=	"[";
				$chr13				=	"["; $chr14				=	"["; $chr15				=	"["; $chr16				=	"[";
				$chr17				=	"["; $chr18				=	"["; $chr19				=	"["; $chr20				=	"[";
				$chr21				=	"["; $chr22				=	"["; $chrX				=	"["; $chrY				=	"[";
				
				foreach ($data_lines as $row){ 
					$data_linewise		=	explode(",", $row);
					$data_linewise[2] = trim(preg_replace('/\s\s+/', '', $data_linewise[2]));
					if($data_linewise[1] == 1) {
						$chr1		.=		"{x:1,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 2) {
						$chr2		.=		"{x:2,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 3) {
						$chr3		.=		"{x:3,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 4) {
						$chr4		.=		"{x:4,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 5) {
						$chr5		.=		"{x:5,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 6) {
						$chr6		.=		"{x:6,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 7) {
						$chr7		.=		"{x:7,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 8) {
						$chr8		.=		"{x:8,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 9) {
						$chr9		.=		"{x:9,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 10) {
						$chr10		.=		"{x:10,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 11) {
						$chr11		.=		"{x:11,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 12) {
						$chr12		.=		"{x:12,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 13) {
						$chr13		.=		"{x:13,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 14) {
						$chr14		.=		"{x:14,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 15) {
						$chr15		.=		"{x:15,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 16) {
						$chr16		.=		"{x:16,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 17) {
						$chr17		.=		"{x:17,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 18) {
						$chr18		.=		"{x:18,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 19) {
						$chr19		.=		"{x:19,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 20) {
						$chr20		.=		"{x:20,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 21) {
						$chr21		.=		"{x:21,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 22) {
						$chr22		.=		"{x:22,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 'X' || $data_linewise[1] == 'x' ) {
						$chrX			.=		"{x:23,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
					if($data_linewise[1] == 'Y' || $data_linewise[1] == 'y') {
						$chrY			.=		"{x:24,y:$data_linewise[0],name:'$data_linewise[2]'},";			
					}
				}

				$chr1				.=	"]"; $chr2				.=	"]"; $chr3				.=	"]"; $chr4				.=	"]";
				$chr5				.=	"]"; $chr6				.=	"]"; $chr7				.=	"]"; $chr8				.=	"]";
				$chr9				.=	"]"; $chr10				.=	"]"; $chr11				.=	"]"; $chr12				.=	"]";
				$chr13				.=	"]"; $chr14				.=	"]"; $chr15				.=	"]"; $chr16				.=	"]";
				$chr17				.=	"]"; $chr18				.=	"]"; $chr19				.=	"]"; $chr20				.=	"]";
				$chr21				.=	"]"; $chr22				.=	"]"; $chrX				.=	"]"; $chrY				.=	"]";
				
				$chr1				=	str_replace("\ '", "", $chr1);
				$chr2				=	str_replace(",]", "]", $chr2);
				$chr3				=	str_replace(",]", "]", $chr3);
				$chr4				=	str_replace(",]", "]", $chr4);
				$chr5				=	str_replace(",]", "]", $chr5);
				$chr6				=	str_replace(",]", "]", $chr6);
				$chr7				=	str_replace(",]", "]", $chr7);
				$chr8				=	str_replace(",]", "]", $chr8);
				$chr9				=	str_replace(",]", "]", $chr9);
				$chr10				=	str_replace(",]", "]", $chr10);
				$chr11				=	str_replace(",]", "]", $chr11);
				$chr12				=	str_replace(",]", "]", $chr12);
				$chr13				=	str_replace(",]", "]", $chr13);
				$chr14				=	str_replace(",]", "]", $chr14);
				$chr15				=	str_replace(",]", "]", $chr15);
				$chr16				=	str_replace(",]", "]", $chr16);
				$chr17				=	str_replace(",]", "]", $chr17);
				$chr18				=	str_replace(",]", "]", $chr18);
				$chr19				=	str_replace(",]", "]", $chr19);
				$chr20				=	str_replace(",]", "]", $chr20);
				$chr21				=	str_replace(",]", "]", $chr21);
				$chr22				=	str_replace(",]", "]", $chr22);
				$chrX				=	str_replace(",]", "]", $chrX);
				$chrY				=	str_replace(",]", "]", $chrY);
				
				echo "<input type=\"hidden\" id=\"chr1\"  name=\"chr1\" value=\"$chr1\" /> ";
				echo "<input type=\"hidden\" id=\"chr2\"  name=\"chr2\" value=\"$chr2\" /> ";
				echo "<input type=\"hidden\" id=\"chr3\"  name=\"chr3\" value=\"$chr3\" /> ";
				echo "<input type=\"hidden\" id=\"chr4\"  name=\"chr4\" value=\"$chr4\" /> ";
				echo "<input type=\"hidden\" id=\"chr5\"  name=\"chr5\" value=\"$chr5\" /> ";
				echo "<input type=\"hidden\" id=\"chr6\"  name=\"chr6\" value=\"$chr6\" /> ";
				echo "<input type=\"hidden\" id=\"chr7\"  name=\"chr7\" value=\"$chr7\" /> ";
				echo "<input type=\"hidden\" id=\"chr8\"  name=\"chr8\" value=\"$chr8\" /> ";
				echo "<input type=\"hidden\" id=\"chr9\"  name=\"chr9\" value=\"$chr9\" /> ";
				echo "<input type=\"hidden\" id=\"chr10\"  name=\"chr10\" value=\"$chr10\" /> ";
				echo "<input type=\"hidden\" id=\"chr11\"  name=\"chr11\" value=\"$chr11\" /> ";
				echo "<input type=\"hidden\" id=\"chr12\"  name=\"chr12\" value=\"$chr12\" /> ";
				echo "<input type=\"hidden\" id=\"chr13\"  name=\"chr13\" value=\"$chr13\" /> ";
				echo "<input type=\"hidden\" id=\"chr14\"  name=\"chr14\" value=\"$chr14\" /> ";
				echo "<input type=\"hidden\" id=\"chr15\"  name=\"chr15\" value=\"$chr15\" /> ";
				echo "<input type=\"hidden\" id=\"chr16\"  name=\"chr16\" value=\"$chr16\" /> ";
				echo "<input type=\"hidden\" id=\"chr17\"  name=\"chr17\" value=\"$chr17\" /> ";
				echo "<input type=\"hidden\" id=\"chr18\"  name=\"chr18\" value=\"$chr18\" /> ";
				echo "<input type=\"hidden\" id=\"chr19\"  name=\"chr19\" value=\"$chr19\" /> ";
				echo "<input type=\"hidden\" id=\"chr20\"  name=\"chr20\" value=\"$chr20\" /> ";
				echo "<input type=\"hidden\" id=\"chr21\"  name=\"chr21\" value=\"$chr21\" /> ";
				echo "<input type=\"hidden\" id=\"chr22\"  name=\"chr22\" value=\"$chr22\" /> ";
				echo "<input type=\"hidden\" id=\"chrX\"  name=\"chrX\" value=\"$chrX\" /> ";
				echo "<input type=\"hidden\" id=\"chrY\"  name=\"chrY\" value=\"$chrY\" /> ";
				
				
				?>
	
					<script type="text/javascript">
						//recieve data from php
						var chr1			=		eval(document.getElementById("chr1").value);	
						var chr2			=		eval(document.getElementById("chr2").value);
						var chr3			=		eval(document.getElementById("chr3").value);
						var chr4			=		eval(document.getElementById("chr4").value);
						var chr5			=		eval(document.getElementById("chr5").value);
						var chr6			=		eval(document.getElementById("chr6").value);
						var chr8			=		eval(document.getElementById("chr8").value);
						var chr7			=		eval(document.getElementById("chr7").value);
						var chr9			=		eval(document.getElementById("chr9").value);
						var chr10			=		eval(document.getElementById("chr10").value);
						var chr11			=		eval(document.getElementById("chr11").value);
						var chr12			=		eval(document.getElementById("chr12").value);
						var chr13			=		eval(document.getElementById("chr13").value);
						var chr14			=		eval(document.getElementById("chr14").value);
						var chr15			=		eval(document.getElementById("chr15").value);
						var chr16			=		eval(document.getElementById("chr16").value);
						var chr17			=		eval(document.getElementById("chr17").value);
						var chr18			=		eval(document.getElementById("chr18").value);
						var chr19			=		eval(document.getElementById("chr19").value);
						var chr20			=		eval(document.getElementById("chr20").value);
						var chr21			=		eval(document.getElementById("chr21").value);
						var chr22			=		eval(document.getElementById("chr22").value);
						var chrX			=		eval(document.getElementById("chrX").value);
						var chrY			=		eval(document.getElementById("chrY").value);
					
						// Make all the colors semi-transparent so we can see overlapping dots
						var colors = Highcharts.getOptions().colors.map(function (color) {
							return Highcharts.color(color).setOpacity(1).get();
						});

						Highcharts.chart('container', {
							chart: {
								zoomType: 'xy',
								type: 'scatter'								
							},
							
							boost: {
								useGPUTranslations: true,
								usePreAllocated: true
							},
			
							colors: colors,

							title: {
								text: 'Manhattan Plot'
							},
							subtitle: {
								text: 'Subtitle goes here . . . '
							},
							xAxis: {
								categories: ['', "Chr 1", "Chr 2", "Chr 3", "Chr 4", "Chr 5", "Chr 6", "Chr 7", "Chr 8",
											     "Chr 9", "Chr 10", "Chr 11", "Chr 12", "Chr 13", "Chr 14", "Chr 15", "Chr 16",
											     "Chr 17", "Chr 18", "Chr 19", "Chr 20", "Chr 21", "Chr 22", "X", "Y"
											]
							},
							yAxis: {
								title: {
									text: '<b>LOG(P-Value)</b>'
								}
							},
							plotOptions: {
								scatter: {
									showInLegend: true,
									jitter: {
										x: 0.24,
										y: 0
									},
									marker: {
										radius: 2,
										symbol: 'circle'
									},
									tooltip: {
										pointFormat: '{point.name}'
									}
								}
							},
							series: [{
								name: 'Chr 1',
								turboThreshold:100000,								
								data: chr1
							},{
								name: 'Chr 2',
								turboThreshold:100000,								
								data: chr2
							},{
								name: 'Chr 3',
								turboThreshold:100000,								
								data: chr3
							},{
								name: 'Chr 4',
								turboThreshold:100000,								
								data: chr4
							},{
								name: 'Chr 5',
								turboThreshold:100000,								
								data: chr5
							},{
								name: 'Chr 6',
								turboThreshold:100000,								
								data: chr6
							},{
								name: 'Chr 7',
								turboThreshold:100000,								
								data: chr7
							},{
								name: 'Chr 8',
								turboThreshold:100000,								
								data: chr8
							},{
								name: 'Chr 9',
								turboThreshold:100000,								
								data: chr9
							},{
								name: 'Chr 10',	
								turboThreshold:100000,							
								data: chr10
							},{
								name: 'Chr 11',
								turboThreshold:100000,								
								data: chr11
							},{
								name: 'Chr 12',
								turboThreshold:100000,								
								data: chr12
							},{
								name: 'Chr 13',	
								turboThreshold:100000,							
								data: chr13
							},{
								name: 'Chr 14',
								turboThreshold:100000,								
								data: chr14
							},{
								name: 'Chr 15',	
								turboThreshold:100000,							
								data: chr15
							},{
								name: 'Chr 16',
								turboThreshold:100000,								
								data: chr16
							},{
								name: 'Chr 17',	
								turboThreshold:100000,							
								data: chr17
							},{
								name: 'Chr 18',	
								turboThreshold:100000,							
								data: chr18
							},{
								name: 'Chr 19',
								turboThreshold:100000,								
								data: chr19
							},{
								name: 'Chr 20',	
								turboThreshold:100000,							
								data: chr20
							},{
								name: 'Chr 21',
								turboThreshold:100000,								
								data: chr21
							},{
								name: 'Chr 22',
								turboThreshold:100000,								
								data: chr22
							},{
								name: 'X',	
								turboThreshold:100000,							
								data: chrX
							},{
								name: 'Y',	
								turboThreshold:100000,							
								data: chrY
							}
							]
						});

					</script>
						
</body>
</html>
        
