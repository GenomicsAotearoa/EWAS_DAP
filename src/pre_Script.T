args		<-	commandArgs(TRUE)
dir 		<-	toString(args[1])
norm 		<-	toString(args[2])
email	 	<-	toString(args[3])
snp 		<-	toString(args[4])
xy_chr	 	<-	toString(args[5])
cr_pro 		<-	toString(args[6])
pheno 		<-	toString(args[7])
DM	 		<-	toString(args[8])
arraytype	<-	"450K"

print (dir)
print (norm)
print (email)
print (snp)
print (xy_chr)
print (cr_pro)
print (pheno)
print (DM)

library(ChAMP)

baseDir	<-	getwd()
baseDir <-	file.path(baseDir, dir)
setwd(baseDir)

myLoad <- champ.load(directory = getwd(),
		   method="ChAMP",
		   methValue="B",
		   autoimpute=TRUE,
		   filterDetP=TRUE,
		   ProbeCutoff=0,
		   SampleCutoff=0.05,
		   detPcut=0.05,
		   filterBeads=FALSE,
		   beadCutoff=0.05,
		   filterNoCG=TRUE,
		   filterSNPs=TRUE,
		   population=NULL,
		   filterMultiHit=TRUE,
		   filterXY=TRUE,
		   force=TRUE,
		   arraytype=arraytype)		   

			
norm	<-	champ.norm(beta=myLoad$beta,
					resultsDir="./CHAMP_Normalization/",
					method="BMIQ",
					plotBMIQ=FALSE,
					arraytype=arraytype,
					cores=4)
					
bcc	<-	champ.refbase(beta = norm, arraytype = arraytype)
			
design	<-	model.matrix(as.formula(sprintf("~0+%s",DM)), data = myLoad$pd)
print(design)
colnames(design) <- gsub("\\$", "_", colnames(design))
fit 	<-	lmFit(bcc$CorrectedBeta, design)

levels	<-	eval(parse(text=paste("nlevels(factor(myLoad$pd$", pheno, "))", sep = "")))
print(levels)
write.csv(levels, "temp3.csv")

if(levels == 2) {
	const_groups	<-	eval(parse(text=paste("levels(factor(myLoad$pd$", pheno, "))", sep = "")))
	g1				<-	paste("myLoad_pd_", pheno, const_groups[1], sep="")
	g2				<-	paste("myLoad_pd_", pheno, const_groups[2], sep="")	
	contMatrix		<-	eval(parse(text=paste("makeContrasts(", g1, "-", g2, ", levels=design)", sep="")))
}
write.csv(contMatrix, "temp2.csv")

fit2 <- contrasts.fit(fit, contMatrix)
fit2 <- eBayes(fit2)
p.ref = fit2$p.value[,1]
write.csv(p.ref, "temp.csv")