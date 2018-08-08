library("htmlwidgets")
suppressPackageStartupMessages(library("heatmaply"))
Args <- commandArgs()
heatmapColor <- strsplit(Args[7],",")[[1]]
filename <- Args[6]
testdata <- read.table(paste('tmpfile',filename,sep='/'),header=T)
rownames(testdata) <- testdata[,1]
testdata <- testdata[,-1]
heatmaply(testdata,colors=heatmapColor,scale="none",margins=c(140,140),limits=c(-3,3)) %>% saveWidget(file=paste(filename,"html",sep="."),selfcontained=F)

