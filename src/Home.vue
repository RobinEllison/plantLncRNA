<template>
<div>
    <div style="background-color: aquamarine;">
        <el-carousel :interval="2000" type="card" height="300px">
            <el-carousel-item>
                <a><img src="./assets/amborella_trichopoda.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/ananas_comosus.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/brachypodium_distachyon.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/brassica_napus.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/citrus_sinesis.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/glycine_max.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/malus_demestica.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/medicago_truncatula.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/mus_acuminata.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a href="/rice"><img src="./assets/oryza_sativa.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/populus_trichocarpa.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/salvia_miltiorrhiza.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/solanum_tuberosum.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/sorghum_cicolor.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/glycine_max.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/vitis_vinifera.jpg"></a>
            </el-carousel-item>
            <el-carousel-item>
                <a><img src="./assets/zea_mays.jpg"></a>
            </el-carousel-item>
        </el-carousel>
    </div>
    <div style="margin-top: 50px">
        <el-row :gutter="20">
            <el-col :span="14">
                <div class="grid-content bg-purple" style="background-color: aquamarine;height: 500px;">
                    Main Text
                </div>
            </el-col>
            <el-col :span="1">
                <div class="grid-content bg-purple" style="height: 500px;">

                </div>
            </el-col>
            <el-col :span="7">
                <div class="grid-content bg-purple" style="background-color: blueviolet;height:500px">
                    <br>
                    <br>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="el-icon-message">&nbsp;&nbsp;&nbsp;News</i>
                    <br>
                    <br>
                    <iframe style="margin-left: 40px" src="/src/news.html" height="380px" width="310px">

                    </iframe>
                </div>
            </el-col>
            <el-col :span="2">
                <div class="grid-content bg-purple">
                </div>Manihot esculenta
            </el-col>
        </el-row>
    </div>
    <div>
        <el-table :data="meta_statics">
            <el-table-column prop="Strategy" label=" "></el-table-column>
            <el-table-column prop="Sorghum_bicolor" label="sbi"></el-table-column>
            <el-table-column prop="Malus_domestica" label="mdm"></el-table-column>
            <el-table-column prop="Brassica_rapa" label="brp"></el-table-column>
            <el-table-column prop="Musa_acuminata" label="mus"></el-table-column>
            <el-table-column prop="Ananas_comosus" label="ans"></el-table-column>
            <el-table-column prop="Theobroma_cacao" label="tcc"></el-table-column>
            <el-table-column prop="Salvia_miltiorrhiza" label="salm"></el-table-column>
            <el-table-column prop="Brachypodium_distachyon" label="bdi"></el-table-column>
            <el-table-column prop="Vitis_vinifera" label="vvi"></el-table-column>
            <el-table-column prop="Cucumis_sativus" label="csv"></el-table-column>
            <el-table-column prop="Zea_mays" label="zma"></el-table-column>
            <el-table-column prop="Manihot_esculenta" label="mes"></el-table-column>
            <el-table-column prop="Medicago_truncatula" label="mtr"></el-table-column>
            <el-table-column prop="Citrus_sinensis" label="cit"></el-table-column>
            <el-table-column prop="Populus_trichocarpa" label="pop"></el-table-column>
            <el-table-column prop="Solanum_tuberosum" label="sot"></el-table-column>
            <el-table-column prop="Oryza_sativa_japonica" label="osa"></el-table-column>
            <el-table-column prop="Glycine_max" label="gmx"></el-table-column>
            <el-table-column prop="Triticum_aestivum" label="tae"></el-table-column>
            <el-table-column prop="Amborella_trichopoda" label="atr"></el-table-column>
            <el-table-column prop="Brassica_napus" label="bna"></el-table-column>
        </el-table>
    </div>
</div>
</template>
<script>


export default{
    name:"home",
    data:function () {
        return {
            meta_statics:[
                {
                    Strategy:'intronic',Malus_domestica:603,Brassica_rapa:193,Musa_acuminata:496,Ananas_comosus:723,Theobroma_cacao:218,Salvia_miltiorrhiza:364
                    ,Brachypodium_distachyon:569,Vitis_vinifera:1041,Cucumis_sativus:250,Zea_mays:1945,Manihot_esculenta:3379,Medicago_truncatula:1068,Citrus_sinensis:56
                    ,Populus_trichocarpa:232,Solanum_tuberosum:1877,Oryza_sativa_japonica:1064,Sorghum_bicolor:94,Glycine_max:218,Triticum_aestivum:915,Amborella_trichopoda:992
                    ,Brassica_napus:194
                },
                {
                    Strategy:'exonic',Malus_domestica:463,Brassica_rapa:324,Musa_acuminata:291,Ananas_comosus:450,Theobroma_cacao:741,Salvia_miltiorrhiza:196
                    ,Brachypodium_distachyon:285,Vitis_vinifera:441,Cucumis_sativus:219,Zea_mays:541,Manihot_esculenta:589,Medicago_truncatula:801,Citrus_sinensis:95
                    ,Populus_trichocarpa:569,Solanum_tuberosum:1078,Oryza_sativa_japonica:325,Sorghum_bicolor:285,Glycine_max:215,Triticum_aestivum:504,Amborella_trichopoda:184
                    ,Brassica_napus:536
                },
                {
                    Strategy:'intergenic',Malus_domestica:4002,Brassica_rapa:2497,Musa_acuminata:1693,Ananas_comosus:2950,Theobroma_cacao:2777,Salvia_miltiorrhiza:3215
                    ,Brachypodium_distachyon:1992,Vitis_vinifera:3132,Cucumis_sativus:1663,Zea_mays:12747,Manihot_esculenta:22667,Medicago_truncatula:6563,Citrus_sinensis:1094
                    ,Populus_trichocarpa:1783,Solanum_tuberosum:15220,Oryza_sativa_japonica:2463,Sorghum_bicolor:786,Glycine_max:827,Triticum_aestivum:13502,Amborella_trichopoda:8001
                    ,Brassica_napus:3789
                },
                {
                    Strategy:'antisense',Malus_domestica:1229,Brassica_rapa:1124,Musa_acuminata:743,Ananas_comosus:835,Theobroma_cacao:786,Salvia_miltiorrhiza:610
                    ,Brachypodium_distachyon:974,Vitis_vinifera:1343,Cucumis_sativus:721,Zea_mays:1810,Manihot_esculenta:2252,Medicago_truncatula:2716,Citrus_sinensis:384
                    ,Populus_trichocarpa:1725,Solanum_tuberosum:2883,Oryza_sativa_japonica:1316,Sorghum_bicolor:936,Glycine_max:770,Triticum_aestivum:2275,Amborella_trichopoda:436
                    ,Brassica_napus:1865
                },
                {
                    Strategy:'other',Malus_domestica:1848,Brassica_rapa:517,Musa_acuminata:734,Ananas_comosus:1204,Theobroma_cacao:584,Salvia_miltiorrhiza:327
                    ,Brachypodium_distachyon:917,Vitis_vinifera:1040,Cucumis_sativus:602,Zea_mays:1892,Manihot_esculenta:4556,Medicago_truncatula:2776,Citrus_sinensis:280
                    ,Populus_trichocarpa:673,Solanum_tuberosum:2333,Oryza_sativa_japonica:1611,Sorghum_bicolor:611,Glycine_max:835,Triticum_aestivum:3185,Amborella_trichopoda:1035
                    ,Brassica_napus:1035
                },
                {
                    Strategy:'all',Malus_domestica:8145,Brassica_rapa:4655,Musa_acuminata:3957,Ananas_comosus:6162,Theobroma_cacao:5106,Salvia_miltiorrhiza:4712
                    ,Brachypodium_distachyon:4737,Vitis_vinifera:6997,Cucumis_sativus:3455,Zea_mays:18935,Manihot_esculenta:33443,Medicago_truncatula:13924,Citrus_sinensis:1909
                    ,Populus_trichocarpa:4982,Solanum_tuberosum:23391,Oryza_sativa_japonica:6779,Sorghum_bicolor:2865,Glycine_max:2865,Triticum_aestivum:20381,Amborella_trichopoda:10648
                    ,Brassica_napus:7419
                }
            ]
        }
    }
}
</script>
<style>

</style>