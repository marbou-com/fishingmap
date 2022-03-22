<template>
    <div class="container">
        <div class="row justify-content-center mt-1">
            <div class="col-md-12">
                <div>

                    <button @click="favorite()" class=" " v-if="result">
                        <i class="far fa-heart"></i><!--いいねしていない状態：白-->
                    </button>

                     <button @click="unfavorite()" class=" " v-else>
                        <i class="fas fa-heart"></i><!--いいねしている状態：黒-->
                    </button>

                    {{ count }}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['post'],
        data() {
            return {
                count: "",
                result: "false" //追加

            }
        },
    
        mounted () {
            this.hasfavorites();
            this.countfavorites(); //追加
            
        },
        methods: {

            favorite() {
                axios.get('/posts/' + this.post +'/favorites')
                .then(res => {
                    this.result = res.data.result;
                    this.count = res.data.count;
                }).catch(function(error) {
                    console.log(error);
                });
            },
            unfavorite() {
                axios.get('/posts/' + this.post +'/unfavorites')
                .then(res => {
                    this.result = res.data.result;
                    this.count = res.data.count;
                }).catch(function(error){
                    console.log(error);
                });
            },
            countfavorites() {
                axios.get('/posts/' + this.post +'/countfavorites')
                .then(res => {
                    this.count = res.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            hasfavorites() { //追加
                axios.get('/posts/' + this.post +'/hasfavorites')
                .then(res => {
                    this.result = res.data;
                }).catch(function(error){
                    console.log(error);
                });
            }
        }
     }
</script>
