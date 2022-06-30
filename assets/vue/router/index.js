import { createRouter, createWebHistory } from 'vue-router'
import App from "@/vue/App";

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: App
        },
    ]
})

export default router
