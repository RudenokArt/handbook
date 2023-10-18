<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<div id="app">{{ message }}</div>
<script>
  Vue.createApp({
    data () {
    	return {
    		message: 'hello',
    	};
    }
  }).mount('#app');
</script>


Вставить переменные в шаблон:
<img v-bind:src="`<?php echo $photo_galery_url;?>${item.image_url}`" alt="">