<template>
    <div class="navigation">
        <el-row>
            <el-col :span="24">
                <el-menu  :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect" :router="true">
                    <el-menu-item index="/">Home</el-menu-item>
                    <el-submenu index="1">
                        <template slot="title">Species</template>
                        <el-menu-item index="/specie/sorghum_bicolor">Sorghum bicolor</el-menu-item>
                        <el-menu-item index="/specie/medicago_truncatula">Medicago truncatula</el-menu-item>
                        <el-menu-item index="/specie/citrus_sinensis">Citrus sinensis</el-menu-item>
                        <el-menu-item index="/specie/populus_trichocarpa">Populus trichocarpa</el-menu-item>
                        <el-menu-item index="/specie/solanum_tuberosum">Solanum tuberosum</el-menu-item>
                        <el-menu-item index="/specie/oryza_sativa_japonica">Oryza sativa japonica</el-menu-item>
                        <el-menu-item index="/specie/glycine_max">Glycine max</el-menu-item>
                        <el-menu-item index="/specie/triticum_aestivum">Triticum aestivum</el-menu-item>
                        <el-menu-item index="/specie/amborella_trichopoda">Amborella trichopoda</el-menu-item>
                        <el-menu-item index="/specie/brassica_napus">Brassica napus</el-menu-item>
                        <el-menu-item index="/specie/malus_domestica">Malus domestica</el-menu-item>
                        <el-menu-item index="/specie/brassica_rapa">Brassica rapa</el-menu-item>
                        <el-menu-item index="/specie/musa_acuminata ">Musa acuminata</el-menu-item>
                        <el-menu-item index="/specie/ananas_comosus">Ananas comosus</el-menu-item>
                        <el-menu-item index="/specie/theobroma_cacao">Theobroma cacao</el-menu-item>
                        <el-menu-item index="/specie/salvia_miltiorrhiza">Salvia miltiorrhiza</el-menu-item>
                        <el-menu-item index="/specie/brachypodium_distachyon">Brachypodium distachyon</el-menu-item>
                        <el-menu-item index="/specie/vitis_vinifera">Vitis vinifera</el-menu-item>
                        <el-menu-item index="/specie/cucumis_sativus">Cucumis sativus</el-menu-item>
                        <el-menu-item index="/specie/zea_mays">Zea mays</el-menu-item>
                        <el-menu-item index="/specie/manihot_esculenta">Manihot esculenta</el-menu-item>
                    </el-submenu>
                    <el-submenu index="3">
                        <template slot="title">Funanalysis</template>
                        <el-menu-item index="/express_matrix">Express Matrix</el-menu-item>
                        <el-menu-item index="/co_expression">Co-expression</el-menu-item>
                        <el-menu-item index="/ts_hk_detection">TS & HK detection </el-menu-item>
                        <el-menu-item index="/miRNA_LncRNA_interaction">miRNA-LncRNA interaction</el-menu-item>
                        <el-menu-item index="/literature_mining">Literature Mining</el-menu-item>
                    </el-submenu>
                    <el-submenu index="2">
                        <template slot="title">Tools</template>
                        <el-menu-item index="/blast" >blast</el-menu-item>
                        <el-menu-item index="/cpc_predection_online" >CPC Predection Online</el-menu-item>
                    </el-submenu>


                    <el-menu-item index="/downloads">downloads</el-menu-item>
                    <el-menu-item index="/QA">QA</el-menu-item>
                </el-menu>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    export default{
        data:function() {
            return {
                activeIndex: this.$route.path //解决刷新浏览器的自动寻找active
            };
        },
        methods: {
            handleSelect(key, keyPath) {
                // console.log(key);
            },
            handlesearch(event){
                alert("this is a exalple");
            }
        },
    }
</script>
<style>
    .el-menu-demo{
        background-color: lightgreen;
    }
</style>