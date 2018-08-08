<template>
    <div>
        <div class="specieHead">
            <img v-bind:src="image" width="200px" height="200px">
            <div>
                <h1>{{specieName}}</h1>
                <el-button-group>
                    <el-button type="success"><a v-bind:href="express_matrix_url">Expression matrix</a></el-button>
                    <el-button type="success"><a v-bind:href="co_expression_url">Co-expression network</a></el-button>
                    <el-button type="success"><a v-bind:href="ts_hk_detection_url">Target gene detection</a></el-button>
                    <el-button type="success"><a v-bind:href="downloads_url">Downloads</a></el-button>
                </el-button-group>
            </div>
        </div>


        <div class="description">
            <h3>Overview</h3>
            <p v-html="specieDescription"></p>
            <h3>Statics</h3>
            <el-table :data="tableMetaData" style="width: 100%">
                <el-table-column
                        prop="lnc"
                        label="LncRNA No."
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="anti"
                        label="Antisense No."
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="interlnc"
                        label="intergenic-lncRNA No.">
                </el-table-column>
                <el-table-column
                        prop="introlnc"
                        label="intronic-lncRNA No.">
                </el-table-column>
                <el-table-column
                        prop="exlnc"
                        label="exonic-lncRNA No.">
                </el-table-column>
                <el-table-column
                        prop="otlnc"
                        label="other category lncRNA No.">
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>
<script>

const metaData = {
    sorghum_bicolor:{
        image:'/src/assets/sorghum_cicolor.jpg',
        description:'Sorghum bicolor, commonly called sorghum and' +
                'also known as great millet, durra, jowari, or milo, is a grass species cultivated for its grain,Sorghum bicolor, ' +
                'commonly called sorghum and also known as great millet, ' +
                'durra, jowari, or milo, is a grass species cultivated for its grain'+
                'Sorghum bicolor, commonly called sorghum and also known as great millet,' +
                ' durra, jowari, or milo, is a grass species cultivated for its grain',
        statics:[{
            lnc: '2712',
            anti: '936',
            interlnc: '786',
            introlnc:'94',
            exlnc:'285',
            otlnc:'611'
        }]
    }
};
export default {
    methods:{

    },
    data:function () {
        return {
            image:metaData[this.$route.params.specie]["image"],
            specieName:this.$route.params.specie,
            tableMetaData:metaData[this.$route.params.specie]["statics"],
            specieDescription:metaData[this.$route.params.specie]["description"],
            express_matrix_url:'/express_matrix/'+this.$route.params.specie,
            co_expression_url:'/co_expression_url/'+this.$route.params.specie,
            ts_hk_detection_url:"/ts_hk_detection_url/"+this.$route.params.specie,
            downloads_url:'/downloads'
        }
    }
}
</script>
<style scoped>
    .specieHead img, .specieHead div{
        display: inline-block;
        padding: 20px;
    }
    h1{
        text-align: center;
    }
    .specieHead{
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
    .description{
        padding: 30px;
    }

</style>