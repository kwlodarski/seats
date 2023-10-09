
import { createApp } from "vue";
import Calendar from "./calendar.vue";
import Settings from "./settings.vue";
import Vacations from "./vacations.vue";
import { autoAnimatePlugin } from '@formkit/auto-animate/vue';
import { VueScreenSizeMixin } from 'vue-screen-size';
import Vue3TouchEvents from "vue3-touch-events";
import 'tw-elements';


const openMobileMenuElem = document.getElementById('open-mobile-menu');
const closeMobileMenuElem = document.getElementById('close-mobile-menu');
const navbar = document.getElementById('navbar-default');

openMobileMenuElem.addEventListener('click', function handleClick() {
    navbar.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
});

closeMobileMenuElem.addEventListener('click', function handleClick() {
    navbar.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});

if (document.querySelector("#calendar")) {
    createApp(Calendar).use(Vue3TouchEvents).mixin(VueScreenSizeMixin).mount("#calendar");
}
if (document.querySelector("#settings")) {
    createApp(Settings).use(autoAnimatePlugin).mount("#settings");
}
if (document.querySelector("#vacations")) {
    createApp(Vacations).use(autoAnimatePlugin).mount("#vacations");
}
