import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

import Vue3Toastify, { toast } from "vue3-toastify";

const app = createApp(App);

app.use(router);

app.use(Vue3Toastify, {
    autoClose: 3000,
    position: toast.POSITION.TOP_RIGHT,
    theme: "light",
});

app.mount("#app");
