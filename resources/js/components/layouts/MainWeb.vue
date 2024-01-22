<template>
    <div id="layer" v-if="tour > 0"></div>
    <div class="custom__container-wrapper">
        <div class="dboard-inner">
            <Header/>
            <div id="layoutSidenav">
                <div id="layoutSidenav_content">
                    <router-view ></router-view>
                    <Footer />
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import {
    ref,
    onMounted,
    watch,
    onBeforeMount
} from 'vue'
import {
    useRouter,
    useRoute
} from 'vue-router'

import store from '../../stores'
import Header from './Header.vue'
import Footer from './Footer.vue'
import Dashboard from '../Web/Dashboard.vue'
import axios from "axios";
export default {
    name: 'MainWeb',
    components: {
        Header,
        Dashboard,
        Footer
    },
    setup() {
        const user = ref({})
        const router = useRouter()
        
        onBeforeMount(() => {
            // getTutorials()
        })

        onMounted(() => {
            user.value = store.getters["auth/currentUser"]
           
        })

        const logout = async () => {
            await axios.post('logout').then(res=>{
            localStorage.getItem("currentUser");
            localStorage.removeItem("currentUser");
            store.commit("auth/removeCurrentUser");
            window.location.href = '/'
            // router.push({ name: 'login' });
        });
        }

     

        return {
            user,
            logout,
        }
    }

}

</script>
<style scoped>
.nav-link.active {
    background-color: #01804a;
    z-index: 999;
}

.overlay {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.7);
    transition: opacity 500ms;
    visibility: visible;
    opacity: 1;
    z-index: 9999;
    overflow: scroll;
}

.pop-tos {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 20px;
}

.pop-tos a {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 20px;
    background: rgb(4, 138, 79);
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    border: 1px solid rgb(4, 138, 79);
    border-radius: 10px;
    text-decoration: none;
    cursor: pointer;
    width: 142px;
}

.pop-tos a:hover {
    background-color: transparent;
    border: 1px solid rgb(4, 138, 79);
    transition: all .5s ease-in-out;
    color: rgb(4, 138, 79);
}

.pop-tos .tos1 a:hover {
    background-color: transparent;
    border: 1px solid rgb(4, 138, 79);
    transition: all .5s ease-in-out;
    color: rgb(4, 138, 79);
}

.tos1 {
    padding-right: 10px;
    color: #fff;
}

.tos2 {
    color: #fff;
}

.pop-tos .tos2 a:hover {
    background-color: transparent;
    border: 1px solid rgb(4, 138, 79);
    transition: all .5s ease-in-out;
    color: rgb(4, 138, 79) !important;
}

.bchat-s {
    position: absolute;
    bottom: 50px;
    right: 50px;
    width: 50px;
    height: 50px;
    z-index: 999;
}

.bchat-s img {
    width: 100%;
    height: 100%;
}

.dis-overlay {
    overflow-y: auto;
}

.Disclamer {
    width: 65%;
}

@media (max-width:767px) {
    .Disclamer {
        width: 90%;
    }

    .popup {
        width: 300px !important;
    }
}

.step_link_1 {
    position: relative;
}


/* .step_link_1 .tour_modal {
    position: absolute;
    right: -169%;
    z-index: 9999;
    width: 340px;
    border-radius: 4px;
    box-shadow: 0 3px 20px rgb(0 0 0 / 15%);
    background-color: #fefffb;
    -webkit-transition: opacity 0.4s;
    -moz-transition: opacity 0.4s;
    transition: opacity 0.4s;
    border-color: #fefffb;
} */


.sb-topnav {
    padding-left: 0;
    height: 56px;
    z-index: 99;
}

#layer {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: calc(100%);
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.step_link .tour_modal {
    position: absolute;
    right: -169%;
    z-index: 9999;
    width: 340px;
    border-radius: 4px;
    box-shadow: 0 3px 20px rgb(0 0 0 / 15%);
    background-color: #fefffb;
    -webkit-transition: opacity 0.4s;
    -moz-transition: opacity 0.4s;
    transition: opacity 0.4s;
    border-color: #fefffb;
    display: block;
}

.step_link .tour_modal .card {
    padding: 20px;
}

.step_link .tour_modal .card h6 {
    color: #000;
}

.step_link .tour_modal .card p {
    color: #000;
}

.step_link .tour_modal .card b {
    color: #000;
}

.tour_modal .card a {
    color: #000;
    margin-left: 15px;
    font-size: 0.8rem;
    font-weight: bold;
    text-decoration: none;
}

.step_link_2,
.step_link_3 {
    position: relative;
}

.step_link_1>.tour_modal,
.step_link_2>.tour_modal,
.step_link_4>.tour_modal,
.step_link_5>.tour_modal,
.step_link_6>.tour_modal,
.step_link_7>.tour_modal {
    display: block;
}

/* .step_link.active::after {
    content: '';
    position: absolute;
    right: -27%;
    width: 0;
    height: 0;
    border-top: 38px solid transparent;
    border-right: 59px solid #01804a;
    border-bottom: 31px solid transparent;

} */

.zoom-in-zoom-out-corner {
    position: absolute;
    left: -5px;
    top: 0;
    bottom: 0;
    margin: auto;
    width: 20px;
    height: 20px;
    background: #fff;
    transform: rotate(45deg);
    z-index: 9;
}

.zoom-in-zoom-out {
    position: absolute;
    left: -28px;
    top: 0;
    bottom: 0;
    margin: auto;
    width: 10px;
    height: 10px;
    background: #ff962c;
    border-radius: 50%;
    animation: zoom-in-zoom-out 2s ease-out infinite;
}

.tour_small {
    display: none;
}

.tour_small .popup {
    z-index: 9993;
    height: fit-content;
    width: 50%;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}

.tour_small .popup .close {
    position: absolute;
    top: 0 !important;
    right: 0 !important;
    transition: all 200ms;
    font-size: 25px;
    font-weight: bold;
    text-decoration: none;
    color: #333;
}

.tour_modal .close {
    position: absolute;
    top: 15px !important;
    right: 20px !important;
    transition: all 200ms;
    font-size: 25px !important;
    font-weight: bold;
    text-decoration: none;
    color: #333;
}

@media (max-width:991px) {
    .step_link .tour_modal {
        display: none;
    }

    .tour_small {
        display: block;
    }
}

@-webkit-keyframes zoom-in-zoom-out {
    0% {
        box-shadow: 0 0 0 0 #ff962c;
    }

    100% {
        box-shadow: 0 0 0 20px rgba(255, 150, 44, 0);
    }
}

@-moz-keyframes zoom-in-zoom-out {
    0% {
        box-shadow: 0 0 0 0 #ff962c;
    }

    100% {
        box-shadow: 0 0 0 20px rgba(255, 150, 44, 0);
    }
}

@keyframes zoom-in-zoom-out {
    0% {
        box-shadow: 0 0 0 0 #ff962c;
    }

    100% {
        box-shadow: 0 0 0 20px rgba(255, 150, 44, 0);
    }
}
</style>
