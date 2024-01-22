<template>
<div class="login-title">
    <h1>Login</h1>
</div>
<div class="logoin-logo"><img :src="'images/login-icon.png'" alt="Login icon">
</div>
<div class="login-form">

    <div class="email-feild">
        <input type="text" name="email" id="email" v-model="state.email" placeholder="Email" required @keyup.enter="login()">
        <div class="icon"><img :src="'images/user.png'" alt=""></div>
    </div>
    <div v-if="v$.email.$error" style="text-align:center">
        <b style="color:red;">
            {{ v$.email.$errors[0].$message }}
        </b>
    </div>
    <div class="email-feild">
        <input type="password" name="password" id="password" v-model="state.password" placeholder="Password" required @keyup.enter="login()">
        <div class="icon"><img :src="'images/password.png'" alt=""></div>
    </div>
    <div v-if="v$.password.$error" style="text-align:center">
        <b style="color:red;">
            {{ v$.password.$errors[0].$message }}
        </b>
    </div>
    <div class="login-form-btn">
        <div class="btn"><a @click.prevent="login()">Sign In</a></div>
        <!-- <div class="forget">
            <router-link to="/forget">Forgot Password?</router-link>
        </div> -->
        <div class="forget">
            <router-link to="/sign_up">Sign Up</router-link>
        </div>
    </div>

</div>
</template>

<script>
import axios from 'axios';
import store from '../../stores'
import useVuelidate from "@vuelidate/core";
import {
    reactive,
    ref
} from "vue";

import {
    required,
    email,
    minLength,
    helpers
} from "@vuelidate/validators";
import {
    useRouter
} from 'vue-router';

export default {

    setup() {
        const state = reactive({
            email: '',
            password: '',

        })

        const router = useRouter()
        const $externalResults = ref({})
        const rules = {
            email: {
                required: helpers.withMessage('Email must be required', required),
                email: helpers.withMessage("Enter valid email address.", email),
            },

            password: {
                required: helpers.withMessage('Password must be required', required),
            },
        }

        const v$ = useVuelidate(rules, state, {
            $externalResults
        })

        const login = async () => {
            v$.value.$clearExternalResults()
            v$.value.$validate() // checks all inputs

            if (!v$.value.$error) {
                await axios.post('login', state).then(response => {
                    if (response.data.success == true) {
                        const user = response.data.user;
                        store.dispatch("auth/setCurrentUser", user);
                        // window.location.href = '/dashboard'

                        setTimeout(() => {
                            window.location.href = '/feedback'
                        }, 3000)
                        Toast.fire({
                            text: response.data.message,
                            timer: 3000,
                            icon: 'success',
                            position: 'top-end',
                        });
                        setTimeout(() => {
                            window.location.href = '/feedback'
                        }, 3000)

                    } else {
                        $externalResults.value = {
                            email: [
                                response.data.message
                            ]
                        }
                    }
                })
            }
        }

        return {
            state,
            login,
            v$
        }
    }
}
</script>

<style scoped>
::placeholder {
    opacity: 0.3;
}
</style>
