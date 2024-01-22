<template>
<main>
    <div class="container">
        <div class="account-title match-title">
            <h4>Feedback</h4>
        </div>

        <div class="row">
            <div class="col-md-12 main-b">
                <div class="row active-card">
                    <div class="col-xl-3 col-md-4 col-sm-4">
                        <div class="card card__one--wrapper text-white mb-4">
                            <div class="card-body">
                                <div class="flex__wrapper-two">
                                    <div>
                                        <p class="card-label-one">Feedback </p>
                                        <h3 class="card-heading-one"> </h3>
                                    </div>
                                    <div>
                                        <i aria-hidden="true" class="fa fa-credit-card"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-4">
                        
                    </div>
                    <div class="col-xl-3 col-md-4 col-sm-4">
                       
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</main>
</template>

<script>
import {
    onMounted,
    ref,
    reactive,
    onUnmounted,
    onBeforeMount,
    watch
} from 'vue'
import store from '../../stores'
import {
    useRouter
} from 'vue-router'


export default {
    name: 'Dashboard',
   
    setup() {
        const user = reactive(store.getters["auth/currentUser"])
        const router = useRouter()

        onMounted(() => {
                if(window.location.pathname == '/feedback')
                {

                }
        });

    

        return {
            user,
        }
    }
}
</script>

<style scoped>
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

@media (max-width:600px) {
    .over-flow {
        overflow-x: scroll;
    }

    .table-over {
        width: 600px;
    }
}
</style>
