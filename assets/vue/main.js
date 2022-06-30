console.log('init app');
import { createApp  } from 'vue'
console.log('init app1');
import App from "./App";
console.log('init app2');
import router from "@/vue/router";
console.log('init app3');




const app = createApp(App)
console.log('init app4');
app.use(router)
console.log('init app5');
app.mount('#app');
console.log('init app6');
console.log('init app7');
