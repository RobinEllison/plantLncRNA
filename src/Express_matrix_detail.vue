<template>
    <div>
        <h1>{{this.$route.params.specie}}</h1>
        <p>descripton</p>
        <div id="specie_statics"></div>
        <div id="tissue_phenotype">
            <table style="width: 100%"></table>
        </div>
        <div v-if="selectedTissue.length > 0">
            <el-button style="width: 100%" type="primary" @click="fetchExpressData">fetch the Data</el-button>
        </div>
        <div id="express_matrix" style="max-height: 300px;overflow: auto;">
            <table style="width:100%;"></table>
        </div>
        <div>
            <el-row type="flex" justify="space-around">
                <el-col :span="6"><el-color-picker v-model="heatmapColor1" ></el-color-picker></el-col>
                <el-col :span="6"><el-color-picker v-model="heatmapColor2" ></el-color-picker></el-col>
                <el-col :span="6"><el-color-picker v-model="heatmapColor3" ></el-color-picker></el-col>
                <el-col :span="6"><el-button @click="heatmap">Draw heatmap</el-button></el-col>
            </el-row>
        </div>
    </div>
</template>
<script type="text/javascript">
    import axios from "axios";
    import * as echarts from 'echarts';
    export default{
        data:function(){
            return {
                selectedTissue:[],
                metadata:null,
                specie:this.$route.params.specie,
                heatmapShow:false,
                heatmapColor1:"#FF0000",
                heatmapColor2:"#000000",
                heatmapColor3:"#00FF00",
                heatmapRowNumber:""
            }
        },
        watch:{
            selectedTissue:function (newvalue) {
                var tableHeader = ['sampleID','privateSampleID','tissue','phenotype','latinName','checkbox'];
                var table = document.getElementById('tissue_phenotype').getElementsByTagName('table')[0];
                table.innerHTML = '';
                if(newvalue.length > 0){
                    var thead = document.createElement('thead');
                    var tbody = document.createElement('tbody');
                    var tr = document.createElement('tr');
                    tableHeader.forEach(function (value) {
                        var th = document.createElement('th');
                        th.innerHTML = value;
                        tr.appendChild(th);
                    });
                    thead.appendChild(tr);
                    tableHeader.pop();
                    this.metadata.forEach(function (value) {
                        if(newvalue.includes(value["tissue"])){
                            var tr = document.createElement('tr');
                            tableHeader.forEach(function (v) {
                                var td = document.createElement('td');
                                td.innerHTML = value[v];
                                tr.appendChild(td);
                            });
                            var td = document.createElement('td');
                            var inputcheckbox = document.createElement('input');
                            inputcheckbox.type = 'checkbox';
                            td.appendChild(inputcheckbox),tr.appendChild(td);
                            tbody.appendChild(tr);
                        }
                    });
                    table.appendChild(thead);
                    table.appendChild(tbody);
                };
            }
        },
        created:function () {
            var vm = this;
            axios.get('/vendor/index.php/summary/'+this.$route.params.specie).then(function (response) {
                vm.metadata = response.data;
            }).catch();
        },
        methods:{
            fetchExpressData:function () {
//                alert("you clicked me");
                var vm = this;
                var divNode = document.getElementById('tissue_phenotype');
                var checkboxNodes = divNode.getElementsByTagName('input');
                var selectedPrivateSampleID = [];
                for(var i = 0;i<checkboxNodes.length;i++){
                    if(checkboxNodes[i].checked){
                        if(selectedPrivateSampleID.includes(checkboxNodes[i].parentNode.parentNode.childNodes[1].innerText)){
                            continue;
                        }else{
                            selectedPrivateSampleID.push(checkboxNodes[i].parentNode.parentNode.childNodes[1].innerText);
                        }
                        
                    }
                }
                if(selectedPrivateSampleID.length == 0){
                    alert('you do not select selectedPrivateSampleID');
                    return;
                }else {
                    axios.post('/vendor/index.php/expression_matrix/'+vm.specie,{selectedPrivateSampleID:selectedPrivateSampleID}).then(function (response) {
                        console.log(response);
                        if(response.data.length > 0){
                            var table = document.getElementById('express_matrix').getElementsByTagName('table')[0];
                            table.innerHTML = '';
                            var thead = document.createElement('thead');
                            var tbody = document.createElement('tbody');
                            var theader = Object.keys(response.data[0]);
                            table.appendChild(thead),table.appendChild(tbody);
                            var tr = document.createElement('tr');
                            theader.forEach(function (v) {
                                var th = document.createElement('th');
                                th.innerHTML = v;
                                tr.appendChild(th);
                            });
                            var th = document.createElement('th');
                            th.innerHTML = 'checkbox';
                            tr.appendChild(th);
                            thead.appendChild(tr);
                            response.data.forEach(function (v) {
                                var tr = document.createElement('tr');
                                theader.forEach(function (va) {
                                    var td = document.createElement('td');
                                    td.innerHTML = v[va];
                                    tr.appendChild(td);
                                });
                                var td = document.createElement('td');
                                var inputcheckbox = document.createElement('input');
                                inputcheckbox.type = 'checkbox';
                                td.appendChild(inputcheckbox),tr.appendChild(td);
                                tbody.appendChild(tr);
                            })
                        }
                    }).catch();
                }
            },
            heatmap:function () {
                var vm = this;
                var divNode = document.getElementById('tissue_phenotype');
                var checkboxNodes = divNode.getElementsByTagName('input');
                var selectedPrivateSampleID = [];
                for(var i = 0;i<checkboxNodes.length;i++){
                    if(checkboxNodes[i].checked){
                        selectedPrivateSampleID.push(checkboxNodes[i].parentNode.parentNode.childNodes[1].innerText);
                    }
                }
                var selectedTransID = [];
                var transIDinputNode = document.getElementById('express_matrix').getElementsByTagName('input');
                for(var i=0;i<transIDinputNode.length;i++){
                    if(transIDinputNode[i].checked){
                        selectedTransID.push(transIDinputNode[i].parentNode.parentNode.childNodes[0].innerText);
                    }
                }
                if(transIDinputNode.length<=2){
                    alert('you must select mort than one transID');
                }
                if(selectedPrivateSampleID.length <= 1){
                    alert('you must select more than one selectedPrivateSampleID');
                    return;
                }else{
                    axios.post('/vendor/index.php/expressionHeatmap/'+vm.specie,{selectedPrivateSampleID:selectedPrivateSampleID,selectedTransID:selectedTransID,heatmapColor:[this.heatmapColor1?this.heatmapColor1:"#FF0000",this.heatmapColor2?this.heatmapColor2:"#000000",this.heatmapColor3?this.heatmapColor3:"#00FF00"]}).then(function (response) {
                       window.open(response.data);
                        console.log(response.data);
                    })
                }
            },
        },
        mounted:function () {
            var vm = this;
            var specie = this.specie;
            axios.get('/vendor/index.php/express_matrix_basic_data/'+specie).then(function (response) {
                var xaxisdata = [];
                var seriesdata = [];
                response.data.forEach(function (item) {
                    xaxisdata.push(item['tissue']);
                    seriesdata.push(item['tissueNumber']);

                });
                var myChart = echarts.init(document.getElementById('specie_statics'));
                var mycolor = ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3','#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
                var mycolorcopy = ['#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3','#c23531','#2f4554', '#61a0a8', '#d48265', '#91c7ae','#749f83',  '#ca8622', '#bda29a','#6e7074', '#546570', '#c4ccd3'];
                var option ={
                    title:{
                        text:"Species statics"
                    },
                    tooltip:{},
                    legend:{
                        data:[specie]
                    },
                    xAxis:{
                        data:xaxisdata
//                        data:['root','leaf','body','flower','plant','shoot','stem','panicle']
                    },
                    yAxis:{},
                    series:[{
                        name:specie,
                        type:'bar',
                        itemStyle:{
                            normal:{
                                color:function (params) {
                                    return mycolor[params.dataIndex];
                                }
                            }
                        },
                        data:seriesdata
//                        data:['90','80','73','112','67','200','20','150'],
                    }]
                };
                myChart.setOption(option);
                myChart.on('click',function (params) {
                    if(params.componentSubType == 'bar'){
                        if(mycolor[params.dataIndex] == 'red'){
                            mycolor[params.dataIndex] = mycolorcopy[params.dataIndex];
                            vm.selectedTissue.splice(vm.selectedTissue.indexOf(params.name),1);
                        }else{
                            mycolor[params.dataIndex] = 'red';
                            vm.selectedTissue.push(params.name);
                        }
                        myChart.setOption(option);
//                        axios('/vendor/index.php/tissue_phenotype')
                    }
//                    console.log(params);
                });
            }).catch();
        }
    }
</script>
<style>
    #specie_statics{
        height: 600px;
        width: 100%;
    }
    #matrix_table table,th,td{
        border: 1px solid black;
        border-collapse: collapse;
        align-content: center;
        text-align: center;
    }
    #matrix_table th,td{
        padding: 10px;
    }
    #matrix_table th{
        height: 40px;
        background-color: #ceffa3;
    }
    #matrix_table tr:nth-child(even){
        background-color: #f2f2f2;
    }
    #matrix_table tr:hover{
        background-color: #bef5bd;
    }
    #matrix_table table{
        width: 100%;
    }
    #matrix_table{
        margin-top: 20px;
        /*width: 100%;*/
        max-height: 600px;
        overflow: auto;
        margin: 20px 20px;
    }
</style>