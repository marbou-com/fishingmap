require('./bootstrap');

import { createApp } from 'vue';

// import ExampleComponent from './components/ExampleComponent.vue'

import LikeComponent from './components/LikeComponent.vue'
import FollowComponent from './components/FollowComponent.vue'
//import VueComponent from './components/VueComponent.vue'
//import Vue2Component from './components/Vue2Component.vue'



createApp({
    components:{
        LikeComponent,
        FollowComponent,
        //VueComponent,
        //Vue2Component,
    }
    
}).mount('#app')



