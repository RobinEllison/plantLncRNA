import Downloads from "./Downloads.vue"
import Expression from "./Expression.vue"
import MiRNA_LncRNA_interaction from "./MiRNA_LncRNA_interaction.vue"
import Home from "./Home.vue"
import Tools from "./Tools.vue"
import Express_matrix from "./Express_matrix.vue"
import Express_matrix_detail from './Express_matrix_detail.vue'
import Sorghum_cicolor from "./Sorghum_cicolor.vue"
import Co_expression from "./Co_expression.vue"
import Co_expression_detail from "./Co_expression_detail.vue"
import Ts_hk_detection from "./Ts_hk_detection.vue"
import Ts_hk_detection_detail from "./Ts_hk_detection_detail.vue"
import Specie from './Specie.vue'

export default [
    {path:"/",component:Home},
    {path:"/co_expression",component:Co_expression},
    {path:"/co_expression/:specie",component:Co_expression_detail},
    {path:"/downloads",component:Downloads},
    {path:"/expression",component:Expression},
    {path:"/express_matrix",component:Express_matrix},
    {path:"/express_matrix/:specie",component:Express_matrix_detail},
    {path:"/miRNA_LncRNA_interaction",component:MiRNA_LncRNA_interaction},
    {path:'/specie/:specie',component:Specie},
    {path:"/sorghum_cicolor",component:Sorghum_cicolor},
    {path:"/ts_hk_detection",component:Ts_hk_detection},
    {path:"/ts_hk_detection/:specie",component:Ts_hk_detection_detail},
    {path:"/tools",component:Tools}
]