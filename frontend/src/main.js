import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { pinia } from './store'
import './index.css'

document.documentElement.classList.add('dark')

createApp(App).use(router).use(pinia).mount('#app')
