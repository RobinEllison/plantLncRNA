This is the first version for plantLncRNA database!
My OS is CentOS Linux release 7.5.1804, while you may need change your config according to your coumputer OS.

step 1: setup the virtual host. Ref blog:https://www.digitalocean.com/community/tutorials/how-to-set-up-apache-virtual-hosts-on-centos-7
Add '127.0.0.1	www.privatelncrna.com' to the end of /etc/hosts file

step2: install the dependent R packages:heatmaply. Offical tutorial: https://github.com/talgalili/heatmaply.
To install the stable version: install.packages('heatmaply').
To install the latest version on github:
# good packages to install for this to work smoothly:

install.packages(c("Rcpp","ggplot2","munsell","htmltools","DBI","assertthat",
"gridExtra","digest","fpc","TSP","registry","gclus","gplots","RColorBrewer",
"stringr","labeling","yaml"))

# You'll need devtools
install.packages.2 <- function (pkg) if (!require(pkg)) install.packages(pkg);
install.packages.2('devtools')
# make sure you have Rtools installed first! if not, then run:
#install.packages('installr'); install.Rtools()

devtools::install_github("ropensci/plotly") # you will probably benefit from the latest version of plotly
devtools::install_github('talgalili/heatmaply')
