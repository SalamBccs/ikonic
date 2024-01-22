<template>
<div class="login-section">
    <div class="container">
        <div class="logo-top">
            <router-link to="/"><img :src="'images/login-logo.png'" style="width:170px" alt=""></router-link>
        </div>
        <div class="login-page">
            <div class="login-info">
                <router-view></router-view>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container">
            <div class="footer-description">
                <p class="uper">{{$moment().format("Y") }} © All rights reserved by
                </p>
                <p class="lower">Designed and Developed by <a href="#" target="_blank"></a></p>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'MainAuth',
    methods: {

    },
    mounted() {

    }
}
</script>
