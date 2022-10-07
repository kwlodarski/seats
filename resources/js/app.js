
import { createApp } from "vue";
import Calendar from "./calendar.vue";
import Settings from "./settings.vue";
import 'tw-elements';
createApp(Calendar).mount("#calendar");
createApp(Settings).mount("#settings");