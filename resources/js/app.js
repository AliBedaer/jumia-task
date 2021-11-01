import Vue from "vue";
import VueRouter from "vue-router";
import App from "./App.vue";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

Vue.use(VueRouter);

// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);
// const Foo = { template: "<div>foo</div>" };
// const Bar = { template: "<div>bar</div>" };

// const router = new VueRouter({
//     mode: "history",
//     base: "/",
//     routes: [
//         { path: "/foo", component: Foo },
//         { path: "/bar", component: Bar }
//     ]
// });

new Vue({
    el: "#app",
    components: {
        App
    }
    // router
});
