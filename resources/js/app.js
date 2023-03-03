import {createApp} from 'vue'
import {createPinia} from 'pinia'
import Vue3Toastify from 'vue3-toastify';
import App from './App.vue'
import router from "./router";
import "../assets/tailus.css";
import 'vue3-toastify/dist/index.css';

const pinia = createPinia()
const app = createApp(App)

app.use(router)
app.use(pinia)
app.use(Vue3Toastify)
app.mount('#app')
