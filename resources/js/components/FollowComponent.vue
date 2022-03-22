<template>
    <button @click="follow()" class=" " v-if="result">
        フォローする
    </button>
    <button @click="unfollow()" class=" " v-else>
        フォローをはずす
    </button>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                //count: "",
                result: "false" //追加

            }
        },
    
        mounted () {
            this.hasfavorites();
            //this.countfavorites(); //追加

        },
        methods: {

            follow() {
                axios.get('/users/' + this.user +'/follows')
                .then(res => {
                    this.result = res.data.result;
                    //this.count = res.data.count;
                }).catch(function(error) {
                    console.log(error);
                });
            },
            unfollow() {
                axios.get('/users/' + this.user +'/unfollows')
                .then(res => {
                    this.result = res.data.result;
                    //this.count = res.data.count;
                }).catch(function(error){
                    console.log(error);
                });
            },
            // countfavorites() {
            //     axios.get('/users/' + this.user +'/countfavorites')
            //     .then(res => {
            //         this.count = res.data;
            //     }).catch(function(error){
            //         console.log(error);
            //     });
            // },
            hasfavorites() { //追加
                axios.get('/users/' + this.user +'/hasfavorites')
                .then(res => {
                    this.result = res.data;
                    //console.log( res.data);

                }).catch(function(error){
                    console.log(error);
                });
            }
        }
     }
</script>
