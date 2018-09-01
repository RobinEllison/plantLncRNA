


##################################


library("limma")
library("edgeR")

#��������
data1 <- read.table("edgeR_input.txt", header=TRUE, sep="\t" )   
head(data1)

#����
group <- factor(c("A","A","B","B"))
y<-DGEList(counts=data1[,2:5], group=group, genes=data1[,1])
y

#��׼��
y <- calcNormFactors(y)

#ɢ������
y <- estimateDisp(y)

#����
 et <- exactTest(y)   #Comparison of groups:  for B vs A
 topTags(et)


#������
results <- topTags(et,n = length(data1[,1]))
write.table(results,"C:\\Users\\a\\Desktop\\�ļ�׼��\\degeR",col.names=T,row.names=T,sep="\t")",col.names=T,row.names=T,sep="\t")


