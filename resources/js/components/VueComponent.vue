<template>
  <div class="card alert-primary">
    <div class="card-body text-left">
      <h2 class="card-title text-center">{{ title }}</h2>
      <p class="card-text h5">{{ message }}</p>
     <hr />
      <div>
        <div class="form-group">
          <label>計算内容</label>
          <textarea class="form-control mb-2" v-model="result"></textarea>

          <button v-for="option in options" v-bind:key="option" @click="sel(option)" >{{ option }}</button> 
          {{ val }}
        </div>
        <div class="text-center">
          <button class="btn btn-primary" @click="doAction">計算する</button>
          <button class="btn btn-primary" @click="clear">クリア</button>

        </div>
      </div>


      
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: "結果:", 
      result: " ",
      val:'',
      options: [
      1,2,3,4,5,6,7,8,9,0,'+','-','*','/'
    ]

    };
  },
  methods: {
    //ボタの押したらresultに書く
    sel :function(option) {
      this.result+=String(option);
    },
    doAction() {//計算します！
      let last = this.result;
      let fn = "";
      fn += "return " + last + ";";
      let exp = "function f(){" + fn + "} f();";
      let ans = eval(exp);//expを実行
      this.message = "こたえ: " + ans;
    },
    clear() {//！
      this.result = '';
      this.message = "結果:";
    },  
  },
};
</script>