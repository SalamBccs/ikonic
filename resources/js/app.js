require('./bootstrap');
import { createApp } from 'vue';
import App from './App.vue';
import router from './router'
import store from './stores'
import Select2 from 'vue3-select2-component';
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import moment from 'moment'


// before a request is made start the loader
axios.interceptors.request.use(config => {
  switch (config.url) {
        case 'get-offers':
          break;
    default:
      Startloader(true);
      break;
  }
  return config
})

// before a response is returned stop loader
axios.interceptors.response.use(response => {
  Startloader(false)
  return response
})

axios.interceptors.response.use(undefined, function (error) {
  if (error) {
    const originalRequest = error.config;
    if (error.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;
      const user = localStorage.getItem("currentUser");
      if(user){
        Toast.fire({
          text: 'You must login first.',
          timer: 3000,
          icon: 'error',
          position: 'top-end',
        });
        localStorage.removeItem("currentUser");
        store.commit("auth/removeCurrentUser");
        setTimeout(() => {
          window.location.href = '/';
        }, 3000);
      }
    }
    else if (error.response.status === 403 && !originalRequest._retry) {
      originalRequest._retry = true;
      router.push({ name: 'dashboard' });
      Toast.fire({
        text: 'Access Denied.',
        timer: 3000,
        icon: 'error',
        position: 'top-end',
      });
    }
    else {
      // router.push(window.location.href)
      Startloader(false)
      Toast.fire({
        text: 'Something Went Wrong!',
        timer: 3000,
        icon: 'error',
        position: 'top-end',
      });
      store.commit('handle_error', JSON.parse(error.response.data.message));
    }
  }
})


const app = createApp(App);
app.use(router);
app.use(store);
app.config.globalProperties.$moment = moment
app.component('Select2', Select2);
app.component('EasyDataTable', Vue3EasyDataTable);
app.mount('#app');
