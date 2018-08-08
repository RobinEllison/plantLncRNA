<template>
    <div id="myapp">
        <div class="content">
            <div class="logo" style="height: 50px"><img width="100%" height="50px" src="./assets/mylogo.jpg"></div>
            <Navigation></Navigation>
            <router-view></router-view>
        </div>
        <div class="footer">
            <Footer></Footer>
        </div>

    </div>
</template>
<script>
    import Navigation from "./Navigation.vue"
    import Footer from "./Footer.vue"
    export default {
        name:'app',
        components:{Navigation,Footer}
    }
</script>
<style>
    html{
        height: 100%;
    }
    body{
        height: 100vh;
        margin: 0;
    }
    #myapp{
        display: flex;
        flex-direction: column;
        height: 100vh;
    }
    .content{
        flex:1 0 auto;
    }
    .footer{
        flex-shrink: 0;
        border-top: solid 5px black;
        padding: 20px;
    }

</style>