<template>
<nav class="sb-topnav navbar navbar-expand custm__navbar--wrapper">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <router-link class="navbar-brand text-center" to="/feedback">
        <img :src="'/assets/images/logo.png'" :style='"height:30px"' alt="" />
    </router-link>
    <div class="flex__wrapper">

        <div class="flex__wrapper--center">

            <div class="dropdown d-flex justify-content-center">
                <div>
                    <img class="dropdown-toggle" :src="user.image || '/assets/images/Profile.jpeg'" alt="" style="width: 30px;height: 30px;border-radius:20px;" />
                </div>
                <div class="d-flex">
                    <div>
                        <span style="text-decoration:none;margin-left:10px;color:#3c3c3c;">{{ user.username }}</span>
                    </div>
                    <div>
                        <a href="#" style="text-decoration:none;margin-left:10px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span style="text-decoration:none;margin-left:-1px;color:#3c3c3c"><i class="fa fa-angle-down"></i></span></a>
                        <div class="dropdown-menu dropdown__menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" v-if="user.role == 'student'" v-on:click="profile_setting" href="#">
                                <path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z">
                                </path><i class="fa fa-cog"></i> &nbsp; Settings
                            </a>
                            <a class="dropdown-item" v-else v-on:click="account_setting" href="#">
                                <path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z">
                                </path><i class="fa fa-cog"></i> &nbsp; Settings
                            </a>
                            <a class="dropdown-item " href="#" v-on:click="logout">
                                <path fill="currentColor" d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z">
                                </path><i class="fa fa-lock"></i> &nbsp; Logout
                            </a>
                        </div>
                    </div>
                </div>
                <svg class="svg-inline--fa non fa-sign-out-alt fa-w-16 pr-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sign-out-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""></svg>
            </div>
        </div>
    </div>
</nav>
</template>

<script>
export default {
    name: 'Header',
    data() {
        return {
            user: '',
            popup2: false,
            v$: {},
        }
    },
    methods: {
        async logout() {
            try {
                await axios.post('logout');
                localStorage.removeItem("currentUser");
                this.$store.commit("auth/removeCurrentUser");

                Toast.fire({
                    text: 'Your session has been logged out.',
                    timer: 5000,
                    icon: 'success',
                    position: 'top-end',
                });

                setTimeout(() => {
                    this.$router.push({
                        name: 'login'
                    });
                }, 3000);
            } catch (error) {
                console.error('Error during logout:', error);
                Toast.fire({
                    text: 'An error occurred during logout.',
                    timer: 5000,
                    icon: 'error',
                    position: 'top-end',
                });
            }
        },

        closeClick: function () {
            // this.$refs.sidebar.hide();
        },

        closePopup() {
            if (this.v$ && this.v$.$clearExternalResults) {
                this.v$.$clearExternalResults();
            }
            this.popup2 = false;
        },
    },

    mounted() {
        const user = JSON.parse(localStorage.getItem("currentUser"));
        if (user) {
            this.user = user;
        }
    }
}
</script>

<style scoped>
@media (max-width:375px) {
    .dropdown span {
        margin-left: 2px !important;
    }

    .non {
        display: none !important;
    }

    a {
        margin-left: 0px !important;
    }
}
</style>
