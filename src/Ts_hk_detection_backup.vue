<template>
    <div>
        <el-row type="flex" justify="space-around">
            <el-row :span="4">
                <el-select v-model="specie" placeholder="select a specie">
                    <el-option v-for="item in species"
                               :key="item.value"
                               :label="item.value"
                               :value="item.value">
                    </el-option>
                </el-select>
            </el-row>
            <el-row :span="4">
                <el-select v-model="selectedSampleList" multiple filterable placeholder="select samples(default:all)">
                    <el-option v-for="item in sampleList"
                               :key="item.sample"
                               :label="item.sample"
                               :value="item.sample">
                    </el-option>
                </el-select>
            </el-row>
            <el-row :span="4">
                <el-input placeholder="default:1" v-model.number="cutoff">
                    <template slot="prepend">Cutoff:</template>
                </el-input>
            </el-row>
            <el-row :span="4">
                <el-input placeholder="default:1" v-model.number="sd">
                    <template slot="prepend">Standard deviation:</template>
                </el-input>
            </el-row>
            <el-row :span="4">
                <span>select tissue specific color:</span>
                <el-color-picker v-model="tsColor" ></el-color-picker>
            </el-row>
            <el-row :span="4">
                <span>select house keeping color:</span>
                <el-color-picker v-model="hkColor" ></el-color-picker>
            </el-row>
            <el-row :span="4">
                <el-button @click="get_ts_hk_rawdata">Submit</el-button>
            </el-row>
        </el-row>
        <div id="ts_hk_table"></div>
    </div>
</template>
<script>
    import axios from "axios"
    export default {
        data:function(){
            return {
                species:[
                    {value:"sorghum_cicolor"},
                    {value:"triticum_aestivum"},
                    {value:"oryza_sativa_japancia"},
                    {value:"zea_mays",label:"zea_mays"},
                    {value:"brachypodium_distachyon"},
                    {value:"amborella_trichopoda"},
                    {value:"vitis_vinifera"},
                    {value:"mus_acuminata"},
                    {value:"medicago_truncatula"},
                    {value:"brassica_rapa"},
                    {value:"brassica_napus"},
                    {value:"glycine_max"},
                    {value:"populus_trichocarpa"},
                    {value:"solanum_tuberosum"},
                    {value:"theobroma_cacao"},
                    {value:"salvia_miltiorrhiza"},
                    {value:"malus_demestica"},
                    {value:"ananas_comosus"},
                    {value:"citrus_sinesis"}
                ],
                specie:"",
                sampleList:[],
                selectedSampleList:[],
                cutoff:1,
                sd:1,
                tsColor:"#61a0a8",
                hkColor:"#d48265"
            }
        },
        methods:{
            get_ts_hk_rawdata:function () {
                var vm = this;
                axios.post("/vendor/index.php/ts_hk_detection/"+this.specie).then(function (response) {
                    var tableHeader = vm.selectedSampleList.length?vm.selectedSampleList.slice():Object.keys(response.data[0]);
                    if(tableHeader.indexOf("transID")+1){
                        tableHeader.unshift(tableHeader.splice(tableHeader.indexOf("transID"),1)[0]);
                    }else {
                        tableHeader.unshift("transID");
                    }
                    tableHeader.unshift("ts_hk");
                    var divTable = document.getElementById("ts_hk_table");
                    divTable.innerHTML = "";
                    var table = document.createElement("table");
                    var tableThead = document.createElement("thead");
                    var tableTbody = document.createElement("tbody");
                    table.appendChild(tableThead);
                    table.appendChild(tableTbody);
                    divTable.appendChild(table);
                    var tableHeaderTr = document.createElement("tr");
                    tableHeader.forEach(function (v) {
                       var th = document.createElement("th");
                       th.innerText = v;
                       tableHeaderTr.appendChild(th);
                    });
                    var showTh = document.createElement("th");
                    showTh.innerText = "show";
                    tableHeaderTr.appendChild(showTh);

                    tableThead.appendChild(tableHeaderTr);
                    response.data.forEach(function (v) {
                        var filterV = tableHeader.map(function (i) {
                            return Number(v[i]);
                        });
                        var status = vm.ts_hk_response_filter(filterV);
                        var tr =document.createElement("tr");
                        if(status==0){
                            return;
                        }else if(status ==1){
                            tr.style.backgroundColor= vm.hkColor;
                            v['ts_hk'] = "house keeping";
                        }else {
                            tr.style.backgroundColor= vm.tsColor;
                            v['ts_hk'] = "tissue specific";
                        }
                        tableHeader.forEach(function (h) {
                            var td = tr.insertCell();
                            td.innerText = v[h];
                        });
                        var td = tr.insertCell();
                        var button = document.createElement("button");
                        button.innerHTML = "display";
                        button.addEventListener("click",function () {
                            tr.parentNode.removeChild(tr);
                        });
                        td.appendChild(button);
                        tableTbody.appendChild(tr);
                    });
                    divTable.addEventListener("scroll",function () {
                        var translate = "translate(0,"+this.scrollTop+"px)";
                        this.querySelector("thead").style.transform = translate;
                    });
                }).catch(function (error) {
                    console.log(error);
                });
            },
            ts_hk_response_filter:function (d) {
                var cutoff = this.cutoff;
                var sd = this.sd;
                var dCopy = d.slice();
                delete dCopy["transID"];
                var ampkData = Object.values(dCopy);
                if(ampkData.every(function (v) {return v<cutoff;})){
                    return 0;
                }else {
                    if(ampkData.includes(0)) return 2;
                    var sum = 0;
                    var squareSum = 0;
                    ampkData.forEach(function (v,i) {
                        var t = Number(v)==0?v:Math.log2(v);
                        sum +=t;
                        squareSum +=Math.pow(t,2);
                    });
                    if(ampkData.length =1) return 1;
                    var calSd = Math.sqrt(squareSum/(ampkData.length-1)-Math.pow(sum,2)/ampkData.length/(ampkData.length-1));
                    if(calSd<sd){
                        return 1;
                    }else{
                        return 2;
                    }


                }
            }
        },
        watch:{
            specie:function (newSpecie) {
                if(newSpecie){
                    var vm = this;
                    axios.get("/vendor/index.php/ts_hk_detection/"+newSpecie).then(function (response) {
                        vm.sampleList = response.data.slice(1);
                    }).catch(function (error) {
                        console.log(error);
                    });
                }
            }
        }
    }
</script>
<style>
    #ts_hk_table table,th,td{
        border: 1px solid black;
        border-collapse: collapse;
        align-content: center;
        text-align: center;
    }
    #ts_hk_table th,td{
        padding: 10px;
    }
    #ts_hk_table thead{
        background-color: #b3d4fc;
    }
    #ts_hk_table{
        margin-top: 20px;
        /*width: 100%;*/
        max-height: 600px;
        overflow: auto;
        margin: 20px 20px;
    }

</style>