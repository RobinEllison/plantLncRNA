<template>
	<div>
		<h1>{{specie}}</h1>
		<div>
			<p>
				The tissue-specific genes are a group of genes whose function and expression are preferred in one or several tissues/cell types. Identification of these genes helps better understanding of tissue–gene relationship, etiology and discovery of novel tissue-specific drug targets. In this study, a statistical method is introduced to detect tissue-specific genes from more than 123 125 gene expression profiles over 107 human tissues, 67 mouse tissues and 30 rat tissues. As a result, a novel subject-specialized repository, namely the tissue-specific genes database (TiSGeD), is developed to represent the analyzed results. Auxiliary information of tissue-specific genes was also collected from biomedical literatures.
			</p>
		</div>
		<div id="ts_hk_detection_detail_graph" style="height:600px;width: 100%;"></div>
	</div>
</template>
<script type="text/javascript">
	import * as echarts from "echarts";
	import axios from "axios";
	export default {
		data:function(){
			return {
				specie:this.$route.params.specie
			}
		},
		mounted:function(){
			axios.post("/vendor/index.php/ts_hk_detection/"+this.specie).then(function(response){
				var myData = new Array(response.data[0].length);
				response.data.forEach(function(v){
					var count = Object.values(v).filter(function(h){ return !parseInt(h);}).length;
					if(!myData[count-1]){
						myData[count-1]=1;
					}else{
						myData[count-1] +=1;
					}
				});
				console.log(myData);
				var optionData = myData.map(function(v,i){return i+1;});
				var myChart = echarts.init(document.getElementById("ts_hk_detection_detail_graph"));
				var option = {
					title:{
	                    text:"Expression of respiratory chain",
	                    subtext:"statics number of 21 plant sprcies",
	                    left:"left"
	                },
	                tooltip:{},
	                legend:{
	                    data:["number"]
	                },
	                toolbox:{
	                    feature:{
	                        restore:{
	                            show:true
	                        },
	                        saveAsImage:{
	                            show:true
	                        }
	                    }
	                },
	                xAxis:[{
	                    type:"category",
	                    data:optionData
	                }],
	                yAxis:[{
	                    type:"value"
	                }],
	                dataZoom:[
	                {
	                    type:"slider",
	                    start:0,
	                    end:100
	                },
	                {
	                    type:"inside",
	                    start:0,
	                    end:100
	                }
	                ],
	                series:[{
	                	name:"number",
	                	type:"bar",
	                	data:myData
	                }]
				};
				myChart.setOption(option);
			}).catch(function(error){
				console.log(error);
			});
		},

	}
</script>
<style type="text/css"></style>