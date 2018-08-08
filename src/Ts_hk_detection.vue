<template>
    <div>
        <h1>Tissue specif verus house keeping detection</h1>
        <p>
            In molecular biology, housekeeping genes are typically constitutive genes that are required for the maintenance of basic cellular function, and are expressed in all cells of an organism under normal and patho-physiological conditions.[1][2][3] Although some housekeeping genes are expressed at relatively constant rates in most non-pathological situations, the expression of other housekeeping genes may vary depending on experimental conditions.[4]

The origin of the term "housekeeping gene" remains obscure. Literature from 1976 used the term to describe specifically tRNA and rRNA.[5] For experimental purposes, the expression of one or multiple housekeeping genes is used as a reference point for the analysis of expression levels of other genes. The key criterion for the use of a housekeeping gene in this manner is that the chosen housekeeping gene is uniformly expressed with low variance under both control and experimental conditions. Validation of housekeeping genes should be performed before their use in gene expression experiments such as RT-PCR.
        </p>
        <div id="ts_hk_detection_graph" style="height: 600px;width: 100%;"></div>
    </div>
</template>
<script type="text/javascript">
    import * as echarts from "echarts";
    import axios from "axios";
    export default{
        mounted:function(){
            var myChart = echarts.init(document.getElementById("ts_hk_detection_graph"));
            var option = {
                title:{
                    text:"Housekeeping verus Tissue specific",
                    subtext:"statics number of LNCRna of 21 plant sprcies",
                    left:"left"
                },
                tooltip:{
                    trigger:"axis",
                    axisPointer:{
                        type:"shadow"
                    }
                },
                legend:{
                    data:["Housekeeping","Tissue specific"]
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
                    data:["s1","s2","s3","s4","s5","s6"]
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
                series:[
                {
                    name:"Housekeeping",
                    type:"bar",
                    stack:"all",
                    itemStyle:{
                        normal:{
                            label:{
                                show:true,
                                position:"insideTop"
                            }
                        }
                    },
                    data: [20.0, 40.9, 70.0, 23.2, 25.6, 76.7]
                },
                {
                    name:"Tissue specific",
                    type:"bar",
                    stack:"all",
                    itemStyle:{
                        normal:{
                            label:{
                                show:true,
                                position:"insideTop"
                            }
                        }
                    },
                    data:[20.6, 50.9, 90.0, 26.4, 28.7, 70.7]
                }
                ]
            };
            myChart.setOption(option);
            myChart.on("click",function(params){
                if(params.seriesType=="bar"){
                    console.log(params.name);
                    location.assign("/ts_hk_detection/sorghum_bicolor")
                }
            });
        }
    }
</script>
<style type="text/css"></style>