<template>
    <div>
        <div style="height: 300px" >
            <el-row :gutter="20">
                <el-col :span="8">
                    <div class="grid-content bg-purple">
                        <img src="./assets/sorghum_cicolor.jpg" height="200px" width="200px" style="margin-left: 70px;margin-top: 50px">
                    </div>
                </el-col>
                <el-col :span="16">
                    <div class="grid-content bg-purple">
                        <h1 style="margin-top: 90px;margin-left: 190px">Sorghum cicolor</h1>
                        <div style="margin-top: 30px">
                            <el-button-group>
                                <el-button type="success"><a href="/express_matrix">Expression matrix</a></el-button>
                                <el-button type="success"><a href="/co_expression">Co-expression network</a></el-button>
                                <el-button type="success"><a href="/ts_hk_detection">Target gene detection</a></el-button>
                                <el-button type="success"><a href="/downloads">Downloads</a></el-button>
                            </el-button-group>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <div style="margin-top: 50px;margin-left: 70px">
            <h3>Overview</h3>
            <br>
            <p>Sorghum bicolor, commonly called sorghum and also known as great millet, durra, jowari, or milo, is a grass species cultivated for its grain, which is used for food, both for animals and humans, and for ethanol production(https://en.wikipedia.org/wiki/Sorghum_bicolor).
                In KELA, we identify 2712 lncRNA sequences from 9 tissues (plant , leaf, root, shoot, panicle, stem, ligule, epidermis, pollen) with 96 RNA-seq dataset .
                Among these sequences,there are 936 antisense-lncRNA, 786 novel intergenic-lncRNA, 94 novel intronic-lncRNA, 285 novel exonic-lncRNA and 611 other category lncRNA(class code indicate in http://cole-trapnell-lab.github.io/cufflinks/cuffcompare/) .
            </p>
            <br>
            <h3>Statistics</h3>
                <br>
                    <el-table :data="tableData2" style="width: 100%" :row-class-name="tableRowClassName">
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
                <br>
            <!--<h3>Sequencing, Assembly, and Annotation</h3>-->
            <!--<br>-->
            <!--<p>Main text</p>-->
        </div>
    </div>
</template>
<script>
    export default {
        methods: {
            tableRowClassName(row, index) {
                if (index === 1) {
                    return 'info-row';
                } else if (index === 3) {
                    return 'positive-row';
                }
                return '';
            }
        },
        data() {
            return {
                tableData2: [{
                    lnc: '2712',
                    anti: '936',
                    interlnc: '786',
                    introlnc:'94',
                    exlnc:'285',
                    otlnc:'611'
                }]
            }
        }
    }
</script>
<style scoped>
    .el-table .info-row {
        background: #c9e5f5;
    }

    .el-table .positive-row {
        background: #e2f0e4;
    }
    a:link{
        text-decoration: none;
    }
    a:visited{
        text-decoration: none;
    }
</style>