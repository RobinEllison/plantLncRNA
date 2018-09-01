


##################################


library("limma")
library("edgeR")

#读入数据
data1 <- read.table("edgeR_input.txt", header=TRUE, sep="\t" )   
head(data1)

#分组
group <- factor(c("A","A","B","B"))
y<-DGEList(counts=data1[,2:5], group=group, genes=data1[,1])
y

#标准化
y <- calcNormFactors(y)

#散度评估
y <- estimateDisp(y)

#检验
 et <- exactTest(y)   #Comparison of groups:  for B vs A
 topTags(et)


#输出结果
results <- topTags(et,n = length(data1[,1]))
write.table(results,"C:\\Users\\a\\Desktop\\文件准备\\degeR",col.names=T,row.names=T,sep="\t")",col.names=T,row.names=T,sep="\t")


