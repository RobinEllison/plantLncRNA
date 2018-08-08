<template>
    <div>
        <h1>Overview</h1>
        <p>
            this is some description about the express matrix of species. It may
            include how many specie and metadata.
        </p>
        <table>
            <thead>
            <tr>
                <th>specie</th>
                <th>root</th>
                <th>leaf</th>
                <th>body</th>
            </tr>
            </thead>
        </table>
        <div id="express_matrix_statics">

        </div>
    </div>

</template>
<script>
    import * as echarts from "echarts";
    export default {
        mounted:function () {
            var myChart = echarts.init(document.getElementById('express_matrix_statics'));
            var option = {
                title:{
                    text:"Samples statics"
                },
                tooltip:{},
                legend:{
                    data:['samples']
                },
                xAxis:{
                    data:['s1','s2','s3','s4','s5','s6','s7','s8']
                },
                yAxis:{},
                series:[{
                    name:'samples',
                    type:'bar',
                    data:['90','80','73','112','67','200','20','150'],
                }]
            };
            myChart.setOption(option);
            myChart.on('click',function (params) {
//                console.log(params);
                if(params.componentSubType=='bar'){
                    location.assign('/express_matrix/' + 'sorghum_bicolor');
                   // console.log('/express_matrix/' + 'sorghum_bicolor');
                    //console.log(params.name);
                }
            })
        }
    };
</script>
<style scoped>
    #express_matrix_statics{
        width: 100%;
        height:600px;
    }
    h1{
        text-align: center;
    }
</style>