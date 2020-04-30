

library(ChAMP)




x <- rnorm(6000,0,1)

png("temp.png", width=500, height=500)
hist(x, col="lightblue")
dev.off()

