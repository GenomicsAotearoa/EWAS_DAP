stringGen <- function(n=1, lenght=20)
{
    randomString <- c(1:n)                  # initialize vector
    for (i in 1:n)
    {
        randomString[i] <- paste(sample(c(0:9, letters, LETTERS),
                                 lenght, replace=TRUE),
                                 collapse="")
    }
    return(randomString)
}
folder		<-	stringGen()



args					<-	commandArgs(TRUE)
dir 					<-	toString(args[1])
normalize				<-	toString(args[2])
email	 				<-	toString(args[3])
snp 					<-	toString(args[4])
xy_chr	 				<-	toString(args[5])
cr_pro 					<-	toString(args[6])
pheno 					<-	toString(args[7])
DM	 					<-	toString(args[8])
data_load_method		<-	toString(args[9])           # 1 for champ and 2 for minfi
arraytype				<-	toString(args[10])			#"EPIC" and "450K"
deconv					<-	toString(args[11])			
com_type				<-	toString(args[12])
array_corr				<-  toString(args[13])
batch_corr				<-	toString(args[14])
norm_name               <-  toString(args[15])



output				<-	""
number_of_dmps		<-	""
print (pheno)
print (DM)

if (array_corr == "ON") {
	print ("Array correction needed to be done.")
} else {
	print ("Array correction not req.")
}

if (batch_corr == "ON") {
	print ("Batch correction needed to be done.")
} else {
	print ("Batch correction not req.")
}

svd_corrections			<-	""

noquote(snp)
noquote(xy_chr)
noquote(cr_pro)

if(snp	==	"TRUE") {
snp		<-	1<2
} else {
snp		<-	1>2
}

if(xy_chr	==	"TRUE") {
xy_chr		<-	1<2
} else {
xy_chr		<-	1>2
}

if(cr_pro	==	"TRUE") {
cr_pro		<-	1<2
} else {
cr_pro		<-	1>2
}

if(com_type == "1") {
print("Catagorical")
}
if(com_type == "2") {
print("Con. normal dist")
}
if(com_type == "3") {
print("Con. non - normal dist")
}

suppressWarnings(suppressMessages(library("stringr", quietly = T)))
suppressWarnings(suppressMessages(library("ChAMP", quietly = T)))
suppressWarnings(suppressMessages(library("minfi", quietly = T)))
suppressWarnings(suppressMessages(library("qqman", quietly = T)))
suppressWarnings(suppressMessages(library("zip", quietly = T)))
suppressWarnings(suppressMessages(library("RColorBrewer", quietly = T)))
suppressWarnings(suppressMessages(library("mailR", quietly = T)))
suppressWarnings(suppressMessages(library("QCEWAS", quietly = T)))
suppressWarnings(suppressMessages(library("ComplexHeatmap", quietly = T)))
suppressWarnings(suppressMessages(library("samr", quietly = T)))
suppressWarnings(suppressMessages(library("IlluminaHumanMethylation450kanno.ilmn12.hg19", quietly = T)))
suppressWarnings(suppressMessages(library("IlluminaHumanMethylationEPICanno.ilm10b4.hg19", quietly = T)))


#baseDir		<-	getwd()
#baseDir 		<-	file.path(baseDir, dir)

setwd(dir)
print(getwd())
#memory.limit(10241024102410)


if(arraytype == "EPIC") {
print ("Arraytype is EPIC")
ann1			<-	getAnnotation(IlluminaHumanMethylationEPICanno.ilm10b4.hg19)
} else {
print ("Arraytype is 450K")
ann1			<-	getAnnotation(IlluminaHumanMethylation450kanno.ilmn12.hg19)
}
annotation		<-	data.frame(ann1[, c(1,2,4,22)])

norm			<-	""
foldername		<-	paste("/mnt/data/uploads/results/", folder, sep="")
dir.create(foldername, showWarnings = TRUE, recursive = FALSE, mode = "0777")

print (foldername)

svd_graph_no		<-	1

tryCatch( {
if(data_load_method == 1) {
	print ("Selected champ")
	#myLoad		<-	champ.load ( directory = getwd(), method="ChAMP", methValue="B", autoimpute=TRUE, filterDetP=TRUE, filterBeads=TRUE, beadCutoff=0.05, filterNoCG=TRUE, filterSNPs=snp, filterMultiHit=cr_pro, filterXY=xy_chr, force=TRUE, arraytype = arraytype )
	#myLoad1	<-	champ.filter ( beta=myLoad2$beta, pd=myLoad2$pd, fixOutlier = TRUE, arraytype = arraytype )
	#myLoad		<-	champ.impute ( beta=myLoad1$beta, pd=myLoad1$pd, method="Combine", k=4, ProbeCutoff=0.5, SampleCutoff=0.1)
	#norm		<-	champ.norm   ( beta=myLoad$beta, method=normalize, arraytype=arraytype, cores=2 )
	print("*** 0")
	print(getwd())
	myLoad	<-	champ.import(directory = getwd(), offset=100, arraytype=arraytype)
	print("*** 1")
	#meth	<-	NROW(myLoad$Meth)
	#unmeth	<-	dim(myLoad$UnMeth)

		unlink("CHAMP_QCimages", recursive = TRUE)
		dir.create("CHAMP_QCimages", showWarnings = TRUE, recursive = FALSE, mode = "0644")
		print("*** 2")
		com_group	<-	eval(parse(text=paste(pheno, sep ="")))

		file		<-	paste(foldername, "/QC_MDS_WithoutDataFilter_PCAPlot.jpg", sep = "")
		jpeg(file, width = 1200, height = 1200)
		champ.QC    (	beta = myLoad$beta, pheno=com_group, mdsPlot=TRUE, densityPlot=FALSE, dendrogram=FALSE, PDFplot=TRUE, Rplot=TRUE, Feature.sel="SVD", resultsDir="./CHAMP_QCimages/"  )
		dev.off()

		unlink("CHAMP_QCimages", recursive = TRUE)
		dir.create("CHAMP_QCimages", showWarnings = TRUE, recursive = FALSE, mode = "0644")

		file		<-	paste(foldername, "/QC_MDS_WithoutDataFilter_DensityPlot.jpg", sep = "")
		jpeg(file, width = 1200, height = 1200)
		champ.QC    (	beta = myLoad$beta, pheno=com_group, mdsPlot=FALSE, densityPlot=TRUE, dendrogram=FALSE, PDFplot=TRUE, Rplot=TRUE, Feature.sel="SVD", resultsDir="./CHAMP_QCimages/" )
		dev.off()
		
		unlink("CHAMP_QCimages", recursive = TRUE)
		dir.create("CHAMP_QCimages", showWarnings = TRUE, recursive = FALSE, mode = "0644")


	
		myLoad	<-	champ.filter    (  beta = myLoad$beta, M = myLoad$M, pd=myLoad$pd, intensity = myLoad$intensity, Meth = myLoad$Meth, UnMeth = myLoad$UnMeth, detP = myLoad$detP, beadcount = myLoad$beadcount,	
						   fixOutlier = TRUE, autoimpute=FALSE, filterDetP=TRUE, SampleCutoff=0.05, detPcut=0.01, filterBeads=TRUE, beadCutoff=0.05, filterNoCG=TRUE, 
						   filterSNPs=snp, filterMultiHit=cr_pro, filterXY=xy_chr, arraytype = arraytype
				     		)


		com_group	<-	eval(parse(text=paste(pheno, sep ="")))

		file		<-		paste(foldername, "/QC_MDS_AfterDataFilter.jpg", sep = "")
		jpeg(file, width = 1200, height = 1200)
		champ.QC    (	beta = myLoad$beta, pheno=com_group, mdsPlot=TRUE, densityPlot=FALSE, dendrogram=FALSE, PDFplot=TRUE, Rplot=TRUE, Feature.sel="SVD", resultsDir="./CHAMP_QCimages/" )
		dev.off()
		unlink("CHAMP_QCimages", recursive = TRUE)
		dir.create("CHAMP_QCimages", showWarnings = TRUE, recursive = FALSE, mode = "0644")

	myLoad		<-	champ.impute ( beta=myLoad$beta, pd=myLoad$pd, method="Combine", k=4, ProbeCutoff=0.5, SampleCutoff=0.1)
        norm            <-      champ.norm   ( beta=myLoad$beta, method="BMIQ", arraytype=arraytype, cores=2 )
		
		output		<-      paste ( output, "QC and Filtering module:\n\n", "\t\tUser input", "\n\t\t\tSNP filering:", snp, "\n\t\t\tFilter non-specific probes:", cr_pro, "\n\t\t\tFilter CPG sites on X and Y chr:", xy_chr, "\n\t\tAdditional filtering criteria:", "\n\t\t\tSample P-Value filtering < 0.05", "\n\t\t\tProbe P-Value < 0.05", "\n\t\t\tBead Cut off < 0.05", sep="" )

	output          <-      paste ( output, "\n\n\nNormalization method : ", norm_name, sep="")
	
	#norm		<-	champ.norm   ( beta=myLoad$beta, method=normalize, arraytype=arraytype, cores=2 )
	#norm		<-	myLoad$beta	
	}
	else {
		print ("Selected minfi")
		print("*** 0")
		targets 	<- 		read.metharray.sheet(getwd(), pattern="covar_final.csv")
		print("*** 1")
		rgSet 		<- 		read.metharray.exp(targets=targets)
		print(rgSet)
		print("*** 2")
		detP		<-		detectionP(rgSet)
		keep		<-		colMeans(detP) < 0.05
		rgSet		<-		rgSet[,keep]
		targets		<-		targets[keep,]
		print("*** 3")
		#mset		<-		eval(parse(text=paste(normalize, "(", "rgSet", ")", sep = "")))
		mset            <-              eval(parse(text=paste("preprocessIllumina(rgSet, bg.correct=TRUE, normalize='controls', reference = 1)", sep = "")))
		print(mset)
		norm		<-		getBeta(mset)
		myLoad2		<-		champ.filter (  beta=norm, M=NULL, pd=targets, intensity=NULL, autoimpute=TRUE, filterNoCG = TRUE, 
								filterSNPs = snp, filterMultiHit = cr_pro, filterXY = xy_chr, fixOutlier = TRUE, arraytype = arraytype
							     )

		myLoad		<-		champ.impute(beta=myLoad2$beta, pd=myLoad2$pd, method="Combine", k=4, ProbeCutoff=0.5, SampleCutoff=0.1)
		norm		<-		myLoad$beta	
		
		output          <-      paste ( output, "QC and Filtering module:\n\n", "\t\tUser input", "\n\t\t\tSNP filering:", snp, "\n\t\t\tFilter non-specific probes:", cr_pro, "\n\t\t\tFilter CPG sites on X and Y chr:", xy_chr, "\n\t\tAdditional filtering criteria:", "\n\t\t\tSample P-Value filtering < 0.05", "\n\t\t\tProbe P-Value < 0.05", sep="" )

		output          <-      paste ( output, "\n\n\nNormalization method : ", norm_name, sep="")

	}
	#output			<-	paste ( output, "load,1", sep="" )
	},
	error = function(c) {
		output		<-	paste(output, "\n\nQC - module error", sep="")
	}
	# , warning = function(c) {
	#	output		<-	paste(output, "\n\nQC - module error", sep="")
	# }
)

#if(dim(norm)) { 
#     output		<-	paste(output, "DATA_LOAD,1", sep="**")
#}  else {
#     output		<-	paste(output, "DATA_LOAD,0", sep="**")       
#}

design			<-	model.matrix(as.formula(sprintf("~ %s", pheno)), data = myLoad$pd)

#if(design) {
    #output		<-	paste(output, "DESIGN_MATRIX,1", sep="**")
#} else {
    #output		<-	paste(output, "DESIGN_MATRIX,0", sep="**") 
#}

unlink("CHAMP_SVDimages", recursive = TRUE)
unlink("CHAMP_Normalization", recursive = TRUE)
unlink("CHAMP_EpiMod", recursive = TRUE)

com_group	<-	eval(parse(text=paste(pheno, sep ="")))
file		<-	paste(foldername, "/QC_MDS_Data_Filter_Normalization_PCAPlot.jpg", sep = "")
	jpeg(file, width = 1200, height = 1200)
	champ.QC    (	beta = norm, pheno=com_group, mdsPlot=TRUE, densityPlot=FALSE,
					dendrogram=FALSE, PDFplot=TRUE, Rplot=TRUE, Feature.sel="SVD", resultsDir="./CHAMP_QCimages/" 
				)
dev.off()
unlink("CHAMP_QCimages", recursive = TRUE)

file			<-	paste(foldername, "/", svd_graph_no, "_QC_SVD_Data_Filter_Normalization_SVDPlot.jpg", sep = "")
	jpeg(file, width = 1200, height = 1200)
	champ.SVD ( beta = norm, rgSet=NULL, pd=myLoad$pd, PDFplot=FALSE, RGEffect=FALSE, Rplot=TRUE )
dev.off()
svd_graph_no		<-	svd_graph_no+1
unlink("CHAMP_SVDimages", recursive = TRUE)

if(deconv == "1"){
tryCatch( {
		bcc			<-	champ.refbase(beta = norm, arraytype = arraytype)
		norm			<-	bcc$CorrectedBeta			
		output			<-	paste(output, "\n\n\nBlood cell correction method: Houseman Extended", sep="")
		svd_corrections		<-	"Fil_Norm_BCC"
		file			<-	paste(foldername, "/BloodCellCoef.csv", sep = "")
		write.csv(bcc$CellFraction, file)


		file		<-	paste(foldername, "/", svd_graph_no, "_QC_SVD_Fil_Norm_BloodCellCorrectionBCC.jpg", sep = "")
			jpeg(file, width = 1200, height = 1200)
			champ.SVD(beta = norm, rgSet=NULL, pd=myLoad$pd, PDFplot=TRUE, RGEffect=FALSE, Rplot=TRUE)
			dev.off()	
		svd_graph_no            <-      svd_graph_no+1
		unlink("CHAMP_SVDimages", recursive = TRUE)
	},
	error = function(c) {
		output		<-	paste(output, "Blood cell correction method: \n\t\tSelected: Houseman Ext. \n\t\tResult: Could not perform blood cell correction", sep="")
	},
	warning = function(c) {
		output		<-	paste(output, "Blood cell correction method: \n\t\tSelected: Houseman Ext. \n\t\tResult: Could not perform blood cell correction", sep="")
	}
)
} else {
print ("Blood cell deconvolution not required.")
output          <-      paste(output, "\n\n\nBlood cell correction method: None", sep="")

}

#svd	<-	tryCatch( {
#		file	<-	paste(foldername, "/SVD_After_BCC_QC.jpg", sep = "")
#		jpeg(file, width = 1200, height = 1200)
#		champ.SVD(beta = norm, rgSet=NULL, pd=myLoad$pd, PDFplot=TRUE, RGEffect=FALSE, Rplot=TRUE)
#		dev.off()
#		output		<-	paste(output, "SVD1,1", sep="**")
#	},
#	error = function(c) {
#		s	<-	0
#	},
#	warning = function(c) {
#		s	<-	0
#	}
#)
#if(svd == 0) {
#	output		<-	paste(output, "SVD1,0", sep="**")  
#}
#unlink("CHAMP_SVDimages", recursive = TRUE)


#if (array_corr == "ON") {
#pheno_temp			<-		str_replace(covars[,i], "myLoad\\$pd\\$", "")

#tryCatch( {		
#				norm			<-		champ.runCombat(beta=norm,pd=myLoad$pd,variablename="Sample_Group2",batchname=c("Array"),logitTrans=TRUE)
#				output			<-		paste(output, "Array,1", sep="**")
#				
##				file		<-	paste(foldername, "/QC_SVD_Array", svd_corrections, ".jpg", sep = "")
#					jpeg(file, width = 1200, height = 1200)
#					champ.SVD(beta = norm, rgSet=NULL, pd=myLoad$pd, PDFplot=FALSE, RGEffect=FALSE, Rplot=TRUE)
#					dev.off()
#				unlink("CHAMP_SVDimages", recursive = TRUE)
##			},
#			error = function(c) {							
#				output			<-	paste(output, "Array,0", sep="**")
#			},
#			warning = function(c) {	
#				output			<-	paste(output, "Array,0", sep="**")
#			}
#	)
#}

#if (batch_corr == "ON") {
#tryCatch( {		
#				norm			<-		champ.runCombat(beta=norm,pd=myLoad$pd,variablename="Sample_Group2",batchname=c("Slide"),logitTrans=TRUE)
#				output			<-		paste(output, "Slide,1", sep="**")
#				
#				file		<-	paste(foldername, "/QC_SVD_Slide", svd_corrections, ".jpg", sep = "")
#						jpeg(file, width = 1200, height = 1200)
#						champ.SVD(beta = norm, rgSet=NULL, pd=myLoad$pd, PDFplot=FALSE, RGEffect=FALSE, Rplot=TRUE)
#						dev.off()
#				unlink("CHAMP_SVDimages", recursive = TRUE)
#			},
#			error = function(c) {							
#				output			<-	paste(output, "Slide,0", sep="**")
#			},
#			warning = function(c) {	
#				output			<-	paste(output, "Slide,0", sep="**")
#			}
#)
#} 

if (array_corr == "ON") {
DM		<-	str_replace(DM, "-", "")
DM		=	paste(DM, "myLoad$pd$Slide,", sep="")
}

if (batch_corr == "ON") {
DM		=	paste(DM, "myLoad$pd$Array,", sep="")	
} 

output                  <-      paste(output, "\n\n\nConfounding factors adjustment module" ,sep="")
if (DM == "-") {
print ("No correction required")
}	else {
	covars		<-	str_split(DM, ",", simplify = TRUE)
	len 		<-	length(covars)-1

	for (i in 1:len) {
		s <- 0
		adj		<-	tryCatch( {		
								cmd				<-	parse (text=paste("removeBatchEffect(norm, batch = ", covars[,i] , ", design=design)", sep =""))
								temp_bvals		<-	eval(cmd)
								norm			<-	temp_bvals
								covar_temp		<-	str_replace(covars[,i], "myLoad\\$pd\\$", "")	
								temp1			<-	paste(covar_temp, " correction", ",", "1", sep="")
								output			<-	paste(output, "\n\t\tAdjusted successfully for : ", covar_temp, sep="")									
								s <- 1

						},
						error = function(c) {
							adj		<-		0						
							#covar_temp		<-	str_replace(covars[,i], "myLoad\\$pd\\$", "")
							#temp1			<-	paste(covar_temp, " correction", ",", "0", sep="")
							#output			<-	paste(output, temp1, sep="**")
						},
						warning = function(c) {	
							adj		<-		0						
							#covar_temp		<-	str_replace(covars[,i], "myLoad\\$pd\\$", "")
							#temp1			<-	paste(covar_temp, " correction", ",", "0", sep="")
							#output			<-	paste(output, temp1, sep="**")
						}
				)
			if (adj == 0) {
				covar_temp		<-	str_replace(covars[,i], "myLoad\\$pd\\$", "")
				output			<-	paste(output, "\n\t\tAdjustment not successful for : ", covar_temp, sep="")
			}	
			if (adj != 0) {
				svd_corrections		<-	paste(svd_corrections, covar_temp, sep="_")
				file		<-	paste(foldername, "/", svd_graph_no, "_QC_SVD_", svd_corrections, "_SVDPlot.jpg", sep = "")
					jpeg(file, width = 1200, height = 1200)
					champ.SVD(beta = norm, rgSet=NULL, pd=myLoad$pd, PDFplot=FALSE, RGEffect=FALSE, Rplot=TRUE)
					dev.off()
				unlink("CHAMP_SVDimages", recursive = TRUE)
				svd_graph_no            <-      svd_graph_no+1
			}	
	}
}

#svd	<-	tryCatch( {
#		file	<-	paste(foldername, "/SVD_After_BCC_QC.jpg", sep = "")
#		jpeg(file, width = 1200, height = 1200)
#		champ.SVD(beta = norm, rgSet=NULL, pd=myLoad$pd, PDFplot=TRUE, RGEffect=FALSE, Rplot=TRUE)
#		dev.off()
#		output		<-	paste(output, "SVD1,1", sep="**")
#	},
#	error = function(c) {
#		s	<-	0
#	},
#	warning = function(c) {
#		s	<-	0
#	}
#)
#if(svd == 0) {
#	output		<-	paste(output, "SVD1,0", sep="**")  
#}
#unlink("CHAMP_SVDimages", recursive = TRUE)

temp_bvals	<-	"-"
file		<-	paste ( foldername, "/QC_MDSFinal_", svd_corrections, "_PCAPlot.jpg", sep = "")
jpeg(file, width = 1200, height = 1200)
champ.QC  (	beta = norm, pheno=com_group, mdsPlot=TRUE, densityPlot=FALSE, dendrogram=FALSE, PDFplot=TRUE, Rplot=TRUE, Feature.sel="SVD", resultsDir="./CHAMP_QCimages/" )
dev.off()
unlink("CHAMP_QCimages", recursive = TRUE)

#file            <-      paste ( foldername, "/QC_MDSFinal_", svd_corrections, "_DendoGram.jpg", sep = "")
#jpeg(file, width = 1200, height = 1200)
#champ.QC  (     beta = norm, pheno=com_group, mdsPlot=FALSE, densityPlot=FALSE, dendrogram=TRUE, PDFplot=TRUE, Rplot=TRUE, Feature.sel="SVD", resultsDir="./CHAMP_QCimages/" )
#dev.off()


file		<-	paste ( foldername, "/com_type.txt", sep = "")
write.table (com_type, file, quote = TRUE, sep = ",", row.names = FALSE, col.names = FALSE)


m_values		<-	log2(norm/(1 - norm))
#m_values		<-	norm

output                  <-      paste(output, "\n\nUpload directory   :   ", dir, sep="")

samples_processed	<-	ncol(m_values)
output                  <-      paste(output, "\n\nNumber of samples processed   :   ", samples_processed, sep="")

probes_processed        <-      nrow(m_values)
output                  <-      paste(output, "\n\nNumber of probes processed    :   ", probes_processed, sep="")

pheno_temp		<-      str_replace(pheno, "myLoad\\$pd\\$", "")
output        		<-      paste(output, "\n\n\nDifferential analysis module:\n", sep="")

tryCatch( {
	if(com_type == "3") {			
			print ("Calculating DMPs")
			com_group	<-	log2(com_group + 1)
			DMPs		<-	dmpFinder(m_values, com_group, type = "continuous", qCutoff = 1, shrinkVar=TRUE)			
			DMPs$Name	<-	rownames(DMPs)
			result		<-	merge(x = annotation, y = DMPs, by = "Name", all.y = TRUE)
						
			output		<-	paste(output, "\t\t\tRank Regression on : ", pheno_temp, "\t\t\tAnalysis type : Continuous variable", sep="")

				colnames(result)[8]			<-		"P_VAL"	
				colnames(result)[2]			<-		"CHR"				
				colnames(result)[3]			<-		"MAPINFO"				
				colnames(result)[4]			<-		"gene"

				file           				<-      paste(foldername, "/DMP_contineous_var.csv", sep = "")
                write.csv (result, file)

				result$PValue				<-		abs(log10(result$P_VAL))
				result$CHR					<-		result$CHR %>% str_replace_all("chr", "")	
				
				EWAS_plots ( result, plot_QQ = TRUE, plot_Man = TRUE, plot_cutoff_p = 1, plot_QQ_bands = FALSE, high_quality_plots = FALSE, save_name = paste(foldername, "/Plots", sep="" ) )				
				
				################################################################################
				#####################code for beta value distribution graphs####################
				################################################################################
				
				top_DMPs				<-		subset(result, P_VAL < 0.05 )
				top_DMPs				<-		top_DMPs[order(top_DMPs$P_VAL),]
				
				if(NROW(top_DMPs) == 0) { 
					number_of_dmps 			<-		"No significant DMPs identificated from given criteria. Please try again with different normalization method or confonding factor(s)."					
				}
				###################interactive manhattan plotting code ##########################
				file				<-		paste ( foldername, "/manhattan_plotting_Plots.csv", sep = "")
				graph_data			<-		""
				
				if(NROW(top_DMPs) > 20000) {
					graph_data			<-		paste ( top_DMPs$PValue[1:20000], ",", top_DMPs$CHR[1:20000], ",", top_DMPs$Name[1:20000], "_", top_DMPs$gene[1:20000], sep = "")															
				}
				if(NROW(top_DMPs) <= 20000) {
					graph_data			<-		paste ( top_DMPs$PValue, ",", top_DMPs$CHR, ",", top_DMPs$Name, "_", top_DMPs$gene, sep = "")															
				}
				
				write.table (graph_data, file, quote = TRUE, sep = ",", row.names = FALSE, col.names = FALSE)
				###################interactive manhattan plotting code ends #####################
				
				
				if(NROW(top_DMPs) > 50) {
					cpg_sites	<-	top_DMPs$Name[1:50]
					cpg_sites	<-	data.frame(cpg_sites)
				}
				if(NROW(top_DMPs) <= 50) {
					cpg_sites	<-	top_DMPs$Name
					cpg_sites	<-	data.frame(cpg_sites)
				}				
			 		
				match1			<-	match(cpg_sites$cpg_sites, rownames(norm))
				
				beta_dist_scatter_plots		<-		norm[match1,]
				beta_dist_scatter_plots		<-		data.frame(beta_dist_scatter_plots)
				beta_dist_scatter_plots		<-		t(beta_dist_scatter_plots)
				cpg_header					<-		colnames(beta_dist_scatter_plots)
				
				for	(i in 1:50) {					
						file			<-		paste(foldername, "/Beta_Val_dist_", cpg_header[i], ".jpg", sep = "")	
						jpeg(file, width = 1200, height = 1200)	
						main_legend		<-	paste("Scatter plot; CPG site: ", cpg_header[i], sep="")
						plot ( beta_dist_scatter_plots[,i], pch=20, cex=2, col="blue", main = main_legend, ylim= range(0,1), ylab = "Beta districution", xlab = "Sample number")
					}
				dev.off()
				
				################################################################################
				#####################code for beta valie distribution graphs####################
				################################################################################
	}
	
	if(com_type == "2") {
				DMPs		<-	dmpFinder(m_values, com_group, type = "continuous", qCutoff = 1, shrinkVar=TRUE)			
				DMPs$Name	<-	rownames(DMPs)
				result		<-	merge(x = annotation, y = DMPs, by = "Name", all.y = TRUE)
		
				output          <-      paste(output, "\t\t\tLinear Regression on : ", pheno_temp, "\t\t\tAnalysis type : Continueous variable", sep="")

					colnames(result)[8]			<-		"P_VAL"	
					colnames(result)[2]			<-		"CHR"				
					colnames(result)[3]			<-		"MAPINFO"				
					colnames(result)[4]			<-		"gene"

					file           				 <-      paste(foldername, "/DMP_contineous_var.csv", sep = "")
					write.csv (result, file)

					result$PValue				<-		abs(log10(result$P_VAL))
					result$CHR					<-		result$CHR %>% str_replace_all("chr", "")	
					
					EWAS_plots ( result, plot_QQ = TRUE, plot_Man = TRUE, plot_cutoff_p = 1, plot_QQ_bands = FALSE, high_quality_plots = FALSE, save_name = paste(foldername, "/Plots", sep="" ) )				
					
					################################################################################
					#####################code for beta value distribution graphs####################
					################################################################################
					
					top_DMPs				<-		subset(result, P_VAL < 0.05 )
					top_DMPs				<-		top_DMPs[order(top_DMPs$P_VAL),]
					
					if(NROW(top_DMPs) == 0) { 
						number_of_dmps 			<-		"No significant DMPs identificated from given criteria. Please try again with different normalization method or confonding factor(s)."
					}
					###################interactive manhattan plotting code ##########################
					file				<-		paste ( foldername, "/manhattan_plotting_Plots.csv", sep = "")
					
					graph_data			<-		""
					
					if(NROW(top_DMPs) > 20000) {
					graph_data			<-		paste ( top_DMPs$PValue[1:20000], ",", top_DMPs$CHR[1:20000], ",", top_DMPs$Name[1:20000], "_", top_DMPs$gene[1:20000], sep = "")															
					}
					if(NROW(top_DMPs) <= 20000) {
					graph_data			<-		paste ( top_DMPs$PValue, ",", top_DMPs$CHR, ",", top_DMPs$Name, "_", top_DMPs$gene, sep = "")															
					}
					
					write.table (graph_data, file, quote = TRUE, sep = ",", row.names = FALSE, col.names = FALSE)
					###################interactive manhattan plotting code ends #####################
					
					
					if(NROW(top_DMPs) > 50) {
					cpg_sites	<-	top_DMPs$Name[1:50]
					cpg_sites	<-	data.frame(cpg_sites)
					}
					if(NROW(top_DMPs) <= 50) {
						cpg_sites	<-	top_DMPs$Name
						cpg_sites	<-	data.frame(cpg_sites)
					}				
						
					match1				<-	match(cpg_sites$cpg_sites, rownames(norm))
					
					beta_dist_scatter_plots		<-	norm[match1,]
					beta_dist_scatter_plots		<-	data.frame(beta_dist_scatter_plots)
					beta_dist_scatter_plots		<-	t(beta_dist_scatter_plots)
					cpg_header			<-	colnames(beta_dist_scatter_plots)
					
					for	(i in 1:50) {					
							file	<-	paste(foldername, "/Beta_Val_dist_", cpg_header[i], ".jpg", sep = "")	
							jpeg(file, width = 1200, height = 1200)	
							main_legend			<-	paste("Scatter plot; CPG site: ", cpg_header[i], sep="")
							plot ( beta_dist_scatter_plots[,i], pch=20, cex=2, col="blue", main = main_legend, ylim= range(0,1), ylab = "Beta districution", xlab = "Sample number")
						}
					dev.off()
					
					################################################################################
					#####################code for beta valie distribution graphs####################
					################################################################################
	}
	
	if(com_type == "1") {
			com_group_new	<-	eval(parse(text=paste("as.character(", pheno, ")", sep ="")))
			DMPs		<-	champ.DMP ( beta = m_values, pheno = com_group_new, compare.group = NULL, adjPVal = 1, arraytype = arraytype)
			DMP_groups	<-	names(DMPs)			
			
			output		<-      paste(output, "\t\t\tF-Test Performed on : ", pheno_temp, "\t\t\tAnalysis type : Categorical variable", sep="")

			for	(no_dmps in 1:length(DMPs)) {
				file				<-	paste(foldername, "/DMP_", DMP_groups[no_dmps], ".csv", sep = "")
				write.csv (DMPs[[no_dmps]], file)

				colnames(DMPs[[no_dmps]])[4]		<-		"P_VAL"			
				DMPs[[no_dmps]]$PValue				<-		abs(log10(DMPs[[no_dmps]]$P_VAL))
								
				EWAS_plots ( DMPs[[no_dmps]], plot_QQ = TRUE, plot_Man = TRUE, plot_cutoff_p = 1, plot_QQ_bands = TRUE, high_quality_plots = FALSE, save_name = paste(foldername, "/", DMP_groups[no_dmps], sep="") )
				
				print("EWAS Plotting done . . . ")
				
				################################################################################
				##################### code for beta value distribution graphs ##################
				####################### Interactive Manhattan Plot #############################
				################################################################################
				
				
				top_DMPs			<-		subset(DMPs[[no_dmps]], P_VAL < 0.05 )
				top_DMPs			<-		top_DMPs[order(top_DMPs$P_VAL),]
				top_DMPs$Name   	<-		rownames(top_DMPs)
				
				file				<-		paste ( foldername, "/manhattan_plotting_", DMP_groups[no_dmps], ".csv", sep = "")				
				graph_data			<-		""
				
				if(NROW(top_DMPs) > 20000) {
				graph_data			<-		paste ( top_DMPs$PValue[1:20000], ",", top_DMPs$CHR[1:20000], ",",
											rownames(top_DMPs)[1:20000], "_", top_DMPs$gene[1:20000], sep = "")															
				}
				if(NROW(top_DMPs) <= 20000) {
				graph_data			<-		paste ( top_DMPs$PValue, ",", top_DMPs$CHR, ",",
											rownames(top_DMPs), "_", top_DMPs$gene, sep = "")															
				}
								
				write.table (graph_data, file, quote = TRUE, sep = ",", row.names = FALSE, col.names = FALSE)
				
				if(NROW(top_DMPs) > 20) {
				cpg_sites	<-	top_DMPs$Name[1:20]
				cpg_sites	<-	data.frame(cpg_sites)
				}
				if(NROW(top_DMPs) <= 20) {
					cpg_sites	<-	top_DMPs$Name
					cpg_sites	<-	data.frame(cpg_sites)
				}				
				
				match1						<-	match(cpg_sites$cpg_sites, rownames(norm))
				beta_dist_scatter_plots		<-	norm[match1,]
				beta_dist_scatter_plots		<-	data.frame(beta_dist_scatter_plots)
				beta_dist_scatter_plots		<-	t(beta_dist_scatter_plots)
				cpg_header					<-	colnames(beta_dist_scatter_plots)
				
				for	(i in 1:20) {					
						file	<-	paste(foldername, "/Beta_Val_dist_", cpg_header[i], "_", DMP_groups[no_dmps], ".jpg", sep = "")	
						jpeg(file, width = 1200, height = 1200)	
						main_legend			<-	paste("Scatter plot; Stage: ", DMP_groups[no_dmps], "- CPG site: ", cpg_header[i], sep="")
						plot (  beta_dist_scatter_plots[,i], pch=20, cex=2, col="blue", main = main_legend, 
								ylim= range(0,1), ylab = "Beta districution", xlab = "Sample number")
					}
				dev.off()
				
				################################################################################
				#####################code for beta value distribution graphs####################
				################################################################################
		 		
				##################### Code for volcano plot goes here . . . ####################

				snps			<-	read.table("../snps.txt", header = FALSE) 	  	### for volcano plot reading snps
				
				DMPs[[no_dmps]]$view			<-		1
				DMPs[[no_dmps]]$view[1:10]		<-		2
				
				comm			<-		intersect(rownames(DMPs[[no_dmps]]), snps$V1)
				DMPs[[no_dmps]]$snps			<-	1
				mat				<-	match(comm, rownames(DMPs[[no_dmps]]))
				DMPs[[no_dmps]]$snps[mat]		<-	2
				df_snps			<-	DMPs[[no_dmps]][mat,]
				

				non_snp_DMPs		<-		setdiff(rownames(DMPs[[no_dmps]]), snps$V1)
				mat					<-		match(non_snp_DMPs, rownames(DMPs[[no_dmps]]))
				df_non_snps			<-		DMPs[[no_dmps]][mat,]
				
				
				###################### code for interactive volcano plot ########################
				
				file						<-		paste ( foldername, "/graph_plotting_snps_", DMP_groups[no_dmps], ".csv", sep = "")				
				graph_data_snps				<-		paste ( "{x:", df_snps$logFC,
															",y:", df_snps$PValue,
															",name:'", rownames(df_snps), "_", df_snps$gene, "'}",
															sep = "")								
				write.table(graph_data_snps, file, quote = TRUE, sep = ",", row.names = FALSE, col.names = FALSE)
				
				file						<-		paste ( foldername, "/graph_plotting_non_snps_", DMP_groups[no_dmps], ".csv", sep = "")				
				graph_data_non_snps			<-		paste ( "{x:", df_non_snps$logFC,
															",y:", df_non_snps$PValue,
															",name:'", rownames(df_non_snps), "_", df_non_snps$gene, "'}",
															sep = "")								
				write.table(graph_data_non_snps, file, quote = TRUE, sep = ",", row.names = FALSE, col.names = FALSE)

				
				
				###################### code ends for interactive volcano plot ###################
				
				
				file	<-	paste(foldername, "/",  DMP_groups[no_dmps], "_volcano_plot", ".jpg", sep = "")
				jpeg(file, width = 1800, height = 1200)	
				plot (  DMPs[[no_dmps]]$logFC, -log10(DMPs[[no_dmps]]$P_VAL), pch=19, 
						col = c("BLUE", "RED")[DMPs[[no_dmps]]$snps], 
						xlim=c(-1,1), xlab="Log2 fold change", ylab= "-Log10 P-Value", bty="l" 
					 )
				data_subset	<-	subset(DMPs[[1]], view > 1)
				text(data_subset$logFC, -log10(data_subset$P_VAL), rownames(data_subset))
				dev.off()
				

				#########Code for volcano plot ends here . . . #############


				#########Code for heatmap goes here . . . #############
				file		<-	paste(foldername, "/",  DMP_groups[no_dmps], "_HM", ".jpg", sep = "")
				jpeg(file, width = 1200, height = 1200)	
				heatmap(as.matrix(head(DMPs[[no_dmps]][7:8], n=100)),  Colv = NA, scale = "none", 
									cexCol=1, main="Methylation value of top 100 CPG sites")
				dev.off()
				#########Code for heatmap goes here . . . #############
				
			}			
		}
		
			horvath1			<-		read.csv("../horvath_cpg_sites.csv", header=TRUE)
			match1				<-		match(horvath1$Name, rownames(norm))
			horvath_sub			<-		norm[match1,]
			
			file		<-	paste(foldername, "/horvath_server_CPG_sites.csv", sep = "")
			write.table (horvath_sub, file, quote = TRUE, sep = ",", row.names = TRUE, col.names = TRUE)
			
			file		<-	paste(foldername, "/beta.csv", sep = "")
			write.table (norm, file, quote = TRUE, sep = ",", row.names = TRUE, col.names = TRUE)

			DMRs		<-	champ.DMR ( beta=norm, pheno=com_group, arraytype=arraytype, adjPvalDmr=1, cores=5, smoothFunction=runmedByCluster, useWeights=TRUE )
			file		<-	paste ( foldername, "/DMRs",  ".csv", sep = "")		
			write.table (DMRs[[1]], file, quote = TRUE, sep = ",", row.names = TRUE, col.names = TRUE)
			
			file		<-	paste ( foldername, "/HS/genes", sep = "")	
			HS			<-	champ.EpiMod  (  beta = norm, pheno = com_group, nseeds = 100, gamma = 0.5, sizeR.v = c(1,100), minsizeOUT = 10, PDFplot = TRUE, nMC = 1000,
											 resultsDir = file, arraytype = arraytype 
										  )

			file		<-	paste(foldername, "/key_genes.txt", sep = "")
			file.copy("topEPI-Epi-X.txt", file)
		
		},
		error = function(c)   {  
		output		<-	paste(output, "\t\t\tOOPS: DMP Identification failed", sep="")   
		},
		warning = function(c) {  
		output		<-	paste(output, "\t\t\tOOPS: DMP Identification failed", sep="")   
		}
)



file		<-		paste(foldername, "/output.php", sep = "")
out_vis 	<-		file.copy("../out/output.php", file, overwrite = TRUE)
file		<-		paste(foldername, "/volcano.php", sep = "")
vol_vis 	<-		file.copy("../out/volcano.php", file, overwrite = TRUE)
file		<-		paste(foldername, "/manhattan.php", sep = "")
vol_vis 	<-		file.copy("../out/manhattan.php", file, overwrite = TRUE)


link		<-		paste("Hi,\n\nHere is the data analysis result.\n", number_of_dmps, paste("\n\n",Sys.getenv('EWAS_ROOT'),sep = "") , folder, "/output.php", "\n\n\nAnalysis summary:\n\n", output, sep="") 

send.mail(from = Sys.getenv('EWAS_EMAIL_FROM'), to = email, subject = "EWAS Data analysis result", body = link, smtp = list(host.name =  Sys.getenv('EWAS_EMAIL_HOST'), port = Sys.getenv('EWAS_EMAIL_PORT'), user.name = Sys.getenv('EWAS_EMAIL_USER'), passwd = Sys.getenv('EWAS_EMAIL_PASSWORD'), ssl = TRUE), authenticate = TRUE, send = TRUE)


#OutApp					<-		COMCreate("Outlook.Application")
#outMail					=		OutApp$CreateItem(0)
#outMail[["To"]]			=		email
#outMail[["subject"]]	=		"EWAS Data analysis result."
#outMail[["body"]]		=		paste("Hi,\n\nHere is the data analysis result.\n\n", link, sep="")
#email_status			<-		outMail$Send()

#if(email_status) {
#	output		<-	paste(output, "EMAIL,1", sep="**")
#} else {
#	output		<-	paste(output, "EMAIL,0", sep="**")
#}

file	<-	paste(foldername, "/Analysis_Summary.txt", sep = "")
write.table(output, file, append = FALSE, row.names = FALSE, col.names = FALSE)

unlink("CHAMP_SVDimages", recursive = TRUE)
unlink("CHAMP_QCimages", recursive = TRUE)
unlink("CHAMP_Normalization", recursive = TRUE)
unlink("CHAMP_EpiMod", recursive = TRUE)
