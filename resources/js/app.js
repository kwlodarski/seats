
import { createApp } from "vue";
import Calendar from "./calendar.vue";
import Settings from "./settings.vue";
import { autoAnimatePlugin } from '@formkit/auto-animate/vue';
import 'tw-elements';
createApp(Calendar).mount("#calendar");
createApp(Settings).use(autoAnimatePlugin).mount("#settings");