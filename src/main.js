import Vue from 'vue'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import "element-ui/lib/theme-default/index.css"
// import axios from "axios"

Vue.use(VueRouter);
Vue.use(ElementUI);

import App from './App.vue'
import Routes from './routes'



const router= new VueRouter({
    mode:"history",
    base:__dirname,
    routes:Routes
});

new Vue({
    el:"#app",
    router:router,
    render: h => h(App)

});

