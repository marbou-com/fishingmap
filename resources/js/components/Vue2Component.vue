<template>
  <div class="card alert-primary">
    <div class="card-body text-left">
      <h2 class="card-title text-center">{{ title }}</h2>
      <p class="card-text h5">{{ message }}</p>
     <hr />
      <div>
        app1:{{ message }}

      </div>


      
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: "hello!"

    };
  },
  
};
</script>