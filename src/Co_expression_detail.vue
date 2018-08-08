<template>
	<div>
		<h1>{{this.$route.params.specie}}</h1>
		<hr>
		<p>The concept of gene co-expression networks was first introduced by Butte and Kohane in 1999 as relevance networks.[5] They gathered the measurement data of medical laboratory tests (e.g. hemoglobin level ) for a number of patients and they calculated the Pearson correlation between the results for each pair of tests and the pairs of tests which showed a correlation higher than a certain level were connected in the network (e.g. insulin level with blood sugar). Bute and Kohane used this approach later with mutual information as the co-expression measure and using gene expression data for constructing the first gene co-expression network.[6]</p>
		<el-row>
			<el-col :span='8'>
				<el-input type="textarea" :rows="2" placeholder="One transcript per line" v-model="textarea">
			</el-col>
			<el-col :span='8'>
				<el-select v-model="value" placeholder='select'>
					<el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value"></el-option>
				</el-select>
			</el-col>
			<el-col :span='8'>
				<el-button @click="viewdata">Viewdata</el-button>
			</el-col>
		</el-row>
		<div style="width: 100%;height: 800px;" id="co_expression_network"></div>
        <div style="width:100%;height:600px;" id="edge_detail"></div>
	</div>
</template>
<script>
	import * as echarts from "echarts";
    import axios from "axios";
    export default {
    	data:function(){
    		return {
    			textarea:"",
    			specie:this.$route.params.specie,
    			options:[
    				{value:'vague',label:"vague"},
    				{value:'precise',label:"precise"}
    			],
    			value:"vague"
    		}
    	},
    	methods:{
    		viewdata:function(){
                var count = (this.textarea.match(/TU/g) || []).length ;
    			if(count == 0 || (count ==1 && this.value == "precise")){
                    // console.log(this.textarea);
                    // console.log(count);
    				alert("Please input more transcripts");
    			}else{
    				var vm = this;
    				axios.post("/vendor/index.php/co_expression_detail/"+vm.specie,{optionType:vm.value,textarea:vm.textarea}).then(function(response){
                        var mydata = response.data;
                        if(mydata.length ==0 ){
                            document.getElementById("co_expression_network").innerHTML = "<h1>No result</h1>";
                        }else{
                            var myChar = echarts.init(document.getElementById("co_expression_network"));
                            var tmp = {};
                            for(var i =0;i<mydata.length;i++){
                                if(tmp.hasOwnProperty(mydata[i]["source"])){tmp[mydata[i]["source"]] +=1;}else {
                                    tmp[mydata[i]["source"]] =1;
                                }
                                if(tmp.hasOwnProperty(mydata[i]["target"])){tmp[mydata[i]["target"]] +=1;}else {
                                    tmp[mydata[i]["target"]] =1;
                                }
                            }
                            var nodes = Object.keys(tmp).map(function(value){
                                return {name:value,value:tmp[value],draggable:true};
                            });
                            var option = {
                                title:{
                                    text:"Co expression newwork"
                                },
                                tooltip:{},
                                series:[{
                                    type:'graph',
                                    layout:'force',
                                    focusNodeAdjacency:true,
                                    label:{
                                        normal:{
                                            position : 'right',
                                            formatter:'{b}'
                                        }
                                    },
                                    data:nodes,
                                    edges:mydata,
                                    force:{
                                        edgeLength:66,
                                        repulsion:20
                                    }
                                }]
                            };
                            myChar.setOption(option);
                            // console.log(nodes);
                            myChar.on('click',function(params){
                                // console.log(params);
                                if(params.dataType=="edge"){
                                    axios.post("/vendor/index.php/co_expression_detail_edge/"+vm.specie,{data:params.data}).then(function(response){
                                        console.log(response.data);
                                        var co_expression_data = response.data["co_expression_data"][0];
                                        var expression_data = response.data["expression_data"];
                                        var sampleID = Object.keys(expression_data[0]).filter(function(el){return el != "transID";});
                                        var myChar_inside = echarts.init(document.getElementById("edge_detail"));
                                        var option_inside = {
                                            title:{
                                                text:"source:"+co_expression_data["source"]+" target:"+co_expression_data["target"]+" evalue:"+co_expression_data["evalue"]+" pvalue:"+co_expression_data["pvalue"]
                                            },
                                            tooltip:{
                                                trigger:"axis",
                                                axisPointer:{
                                                    type:'cross'
                                                }
                                            },
                                            legend:{
                                                data:[co_expression_data["source"],co_expression_data["target"]]
                                            },
                                            xAxis:[{
                                                type:"category",
                                                data:sampleID,
                                                axisPointer:{
                                                    type:"shadow"
                                                }
                                                }],
                                            yAxis:[{
                                                type:'value'
                                            }],
                                            series:[
                                            {
                                                name:expression_data[0]["transID"],
                                                type:"bar",
                                                data:sampleID.map(function(el){return expression_data[0][el];})
                                            },
                                            {
                                                name:expression_data[1]["transID"],
                                                type:"bar",
                                                data:sampleID.map(function(el){return expression_data[1][el];})
                                            }
                                            ]
                                        };
                                        myChar_inside.setOption(option_inside);
                                    });
                                }
                            });
                        }
    					// console.log(response.data);
    				});
    			}
    		}
    	}
    }
</script>
<style type="text/css"></style>