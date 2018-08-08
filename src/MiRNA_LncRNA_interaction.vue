<template>
<div>
    <el-row :gutter="20">
        <el-col :span="6">
            <el-select v-model="specie" placeholder="please select a specie">
                <el-option v-for="specie in species" :key="specie" :value="specie" :label="specie"></el-option>
            </el-select>
        </el-col>
        <el-col :span="6">
            <el-input type="textarea" :rows="1" placeholder="miRNA id" v-model="miRNAID"></el-input>
        </el-col>
        <el-col :span="6">
            <el-input type="textarea" :rows="1" placeholder="lncRNA id" v-model="lncRNAID"></el-input>
        </el-col>
        <el-col :span="6" style="text-align: center;margin: auto">
            <el-button @click="miRNA_LncRNA_interaction">submit</el-button>
        </el-col>
    </el-row>
    <div id="result_table">

    </div>
</div>
</template>
<script>
import axios from "axios"
export default{
    data:function () {
        return {
            species:[
                "sorghum_cicolor",
                "triticum_aestivum",
                "oryza_sativa_japancia",
                "zea_mays","brachypodium_distachyon",
                "amborella_trichopoda",
                "vitis_vinifera",
                "mus_acuminata",
                "medicago_truncatula",
                "brassica_rapa",
                "brassica_napus",
                "glycine_max",
                "populus_trichocarpa",
                "solanum_tuberosum",
                "theobroma_cacao",
                "salvia_miltiorrhiza",
                "malus_demestica",
                "ananas_comosus",
                "citrus_sinesis"
            ],
            specie:"",
            miRNAID:'',
            lncRNAID:''
        }
    },
    methods:{
        miRNA_LncRNA_interaction:function () {
            var vm = this;
            var re = /\r\n|\n|\r/g;
            if(vm.miRNAID){
                var miRNAIDArray = vm.miRNAID.split(re).map(function (v) {
                    return v.trim().replace(/^>/,'');
                });
            }else {
                var miRNAIDArray = [];
            };
            if(vm.lncRNAID){
                var lncRNAIDArray = vm.lncRNAID.split(re).map(function (v) {
                    return v.trim().replace(/^>/,'');
                });
            }else{
                var lncRNAIDArray = [];
            }


            axios.post("/vendor/index.php/miRNA_lncRNA_interaction/"+vm.specie,{'miRNAID':miRNAIDArray,'lncRNAID':lncRNAIDArray}).then(function (response) {
                response = response.data;
                var theadContent = Object.keys(response[0]);
                var table = document.createElement("table");
                var thead = document.createElement("thead");
                var tbody = document.createElement('tbody');
                table.appendChild(thead);
                table.appendChild(tbody);
                document.getElementById('result_table').innerHTML='';
                document.getElementById("result_table").appendChild(table);
                var theadTr = document.createElement('tr');
                thead.appendChild(theadTr);
                theadContent.forEach(function (v) {
                    var th = document.createElement('th');
                    th.innerText = v;
                    theadTr.appendChild(th);
                });
                response.forEach(function (v) {
                    var tbodyTr = document.createElement('tr');
                    tbody.appendChild(tbodyTr);
                    theadContent.forEach(function (k) {
                        var td = document.createElement('td');
                        td.innerText = v[k];
                        tbodyTr.appendChild(td);
                    })
                });
            }).catch(function (error) {
                console.log(error);
            })
        }
    }
}
</script>
<style>
    #result_table table,th,td{
        border: 1px solid black;
        border-collapse: collapse;
        align-content: center;
        text-align: center;
        padding: 10px;
    }
    #result_table th{
        height: 40px;
        background-color: #ceffa3;
    }
    #result_table tr:nth-child(even){
        background-color: #f2f2f2;
    }
    #result_table tr:hover{
        background-color: #bef5bd;
    }
    #result_table table{
        width: 100%;
    }
    #result_table {
        margin-top: 20px;
        max-height: 600px;
        overflow: auto;
    }
</style>