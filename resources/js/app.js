require('./bootstrap');

import { createApp } from 'vue';

// import ExampleComponent from './components/ExampleComponent.vue'

import LikeComponent from './components/LikeComponent.vue'
import FollowComponent from './components/FollowComponent.vue'
//import VueComponent from './components/VueComponent.vue'



createApp({
    components:{
        LikeComponent,
        FollowComponent,
        //VueComponent
    }
    
}).mount('#app')



